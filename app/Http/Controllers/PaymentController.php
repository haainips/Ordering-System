<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function checkOrder()
    {
        return view('orders.formcekpesanan');
    }

    public function viewOrder(Request $request)
    {
        $request->validate([
            'no_hp' => 'required|numeric',
        ]);

        $no_hp = $request->input('no_hp');
        $order = Pesanan::where('no_hp', $no_hp)->with('detailPesanan.menu')->first();

        if (!$order) {
            return redirect()->route('order.view')->with('error', 'Pesanan tidak ditemukan');
        }

        return view('orders.show-pesanan', compact('order'));
    }

}
