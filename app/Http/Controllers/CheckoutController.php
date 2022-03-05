<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use App\TransactionDetail;
use App\TravelPackage;
use Carbon\Carbon as Carbon;

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
        $transaction = Transaction::findorFail($id);
        $transaction->transaction_status = 'PENDING';
        $transaction->save();

        return view('pages.success');
    }
}
