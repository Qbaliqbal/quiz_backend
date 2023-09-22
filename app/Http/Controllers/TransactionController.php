<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(Request $request){
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'address_id' => 'required|exists:customer_addresses,id',
                'product_id' => 'required|exists:products,id',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $transaction = new Transaction([
                'customer_id' => $request->customer_id,
                'address_id' => $request->address_id,
                'product_id' => $request->product_id,
                'payment_method_id' => $request->payment_method_id,
                'quantity' => $request->quantity,
            ]);

            $transaction->save();

            return response()->json(['message' => 'Transaksi berhasil dibuat'], 201);
        }
}
