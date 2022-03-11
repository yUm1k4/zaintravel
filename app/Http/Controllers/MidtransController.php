<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Set konfigurasi Midtrans
        Config::$clientKey = config('midtrans.clientKey');
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        //  Buat instance midtrans notification
        $notif = new Notification();

        // pecah order id agar bisa diterima oleh database
        // TEST-17 menjadi 17
        $order = explode('-', $notif->order_id);

        // assign variable utk memudahkan coding
        $status = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraud = $notif->fraud_status;
        $order_id = $order[1];

        // cari transaksi berdasarkan id
        $transaction = Transaction::findOrFail($order_id);

        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaction->transaction_status = 'CHALLENGE';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        } elseif ($status == 'settlement') { // sudah terbayarkan
            $transaction->transaction_status = 'SUCCESS';
        } elseif ($status == 'pending') {
            $transaction->transaction_status = 'PENDING';
        } elseif ($status == 'deny') {
            $transaction->transaction_status = 'FAILED';
        } elseif ($status == 'expire') {
            $transaction->transaction_status = 'EXPIRED';
        } elseif ($status == 'cancel') {
            $transaction->transaction_status = 'FAILED';
        }

        // Simpan transaksi
        $transaction->save();

        // Kirimkan email
        if ($transaction) {
            if ($status == 'capture' && $fraud == 'accept') {
                Mail::to($transaction->user)->send(new \App\Mail\TransactionSuccess($transaction));
            } else if ($status == 'settlement') {
                Mail::to($transaction->user)->send(new \App\Mail\TransactionSuccess($transaction));
            } else if ($status == 'success') {
                Mail::to($transaction->user)->send(new \App\Mail\TransactionSuccess($transaction));
            } else if ($status == 'capture' && $fraud == 'challenge') {
                return response()->json([
                    'meta' => [
                        'code'      => 200,
                        'message'   => 'Midtrans Payment Challenge'
                    ],
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code'      => 200,
                        'message'   => 'Midtrans Payment not settlement'
                    ],
                ]);
            }

            return response()->json([
                'meta' => [
                    'code'      => 200,
                    'message'   => 'Midtrans notification success'
                ],
            ]);
        }
        // jangan lupa ubah VerifyCsrfToken.php exceptnya midtrans/*
    }

    public function finishRedirect(Request $request)
    {
        return view('pages.success');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('pages.unsuccess');
    }

    public function errorRedirect(Request $request)
    {
        return view('pages.failed');
    }
}
