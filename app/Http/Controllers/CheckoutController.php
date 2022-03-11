<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\TransactionDetail;
use App\TravelPackage;
use Carbon\Carbon as Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $item = Transaction::with(['details', 'travel_package', 'user'])->findOrFail($id);

        return view('pages.checkout', [
            'item'  => $item
        ]);
    }
    
    public function process(Request $request, $id)
    {
        $travel_package = TravelPackage::findOrFail($id);

        $transaction = Transaction::create([
            'travel_packages_id'    => $id,
            'users_id'              => Auth::user()->id,
            'additional_visa'       => 0,
            'transaction_total'     => $travel_package->price,
            'transaction_status'    => 'IN_CART',
        ]);

        TransactionDetail::create([
            'transactions_id'   => $transaction->id,
            'username'          => Auth::user()->username,
            'nationality'       => 'ID',
            'is_visa'           => false,
            'doe_passport'      => Carbon::now()->addYears(5),
        ]);

        return redirect()->route('checkout', $transaction->id);
    }

    public function create(Request $request, $id)
    {
        $request->validate([
            'username'              => 'required|string|exists:users,username',
            'is_visa'               => 'required|boolean',
            'doe_passport'          => 'required|date',
        ]);

        $data = $request->all();
        $data['transactions_id'] = $id;
        
        // insert
        TransactionDetail::create($data);

        $transaction = Transaction::with(['travel_package'])->find($id);

        if ($request->is_visa) { // kalo visa 30 day atau true
            $transaction->transaction_total += 190;
            $transaction->additional_visa += 190;
        }

        $transaction->transaction_total += $transaction->travel_package->price;
        $transaction->save();

        return redirect()->route('checkout', $id);
    }

    public function remove(Request $request, $detail_id)
    {
        $item = TransactionDetail::findOrFail($detail_id);

        $transaction = Transaction::with(['details', 'travel_package'])->findOrFail($item->transactions_id);

        if ($item->is_visa) { // kalo visa 30 day atau true
            $transaction->transaction_total -= 190;
            $transaction->additional_visa -= 190;
        }

        $transaction->transaction_total -= $transaction->travel_package->price;
        $transaction->save();
        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);
    }

    public function success(Request $request, $id)
    {
        $transaction = Transaction::with(['details', 'travel_package.galleries', 'user'])->findorFail($id);
        $transaction->transaction_status = 'PENDING';
        $transaction->save();

        // dd($transaction);

        // * flow baru midtrans
        // Set konfigurasi midtrans
        Config::$clientKey = config('midtrans.clientKey');
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Utk dikirim ke midtrans
        $midtrans_params = array(
            'transaction_details' => array(
                'order_id' => 'TEST-' . $transaction->id,
                'gross_amount' => (int) $transaction->transaction_total,
            ),
            'customer_details' => array(
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ),
            'enabled_payments'  => ['gopay', 'shopeepay'], // hanya memakai pembayaran via gopay
            'vtweb' => [] // harus diaktifkan walau kosong
        );
        // Link snap: https://snap-docs.midtrans.com/#shopeepay

        // Buat Snap Object
        // $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;
        try {
            $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

            // Redirect ke halaman midtrans
            header('Location: ' . $paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
            // return redirect()->route('checkout', $id)->with(['error' => $e->getMessage()]);
        }
        // harus di ubah dulu ke web live, settingan yg ada di SNAP Preferensce (dashboard midtrans)
        // tapi karena pake local ya bisa apa, jadinya pakai ngrok
        // tutorial : https://www.youtube.com/watch?v=iY6ydhRrumA atau https://class.buildwithangga.com/course_playing/full-stack-web-developer/191
        // local pake ngrok : http://zaintravel.test:80 atau acak : http://7956-125-164-154-178.ngrok.io/zaintravel/public

        // * flow lama
        // Kirim email ke user e-ticket nya
        // Mail::to($transaction->user)->send(new \App\Mail\TransactionSuccess($transaction));

        // return view('pages.success');
    }
}
