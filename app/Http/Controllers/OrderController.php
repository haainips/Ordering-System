<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{

    public function addToCart(Request $request)
    {
        $order = session()->get('order', new Pesanan());

        $menu = Menu::find($request->menu_id);
        $quantity = $request->quantity;

        $existingItem = $order->detailPesanan->firstWhere('id_menu', $menu->id);

        if ($existingItem) {
            $existingItem->qty += $quantity;
        } else {
            $orderItem = new DetailPesanan(['id_menu' => $menu->id, 'qty' => $quantity]);
            $order->detailPesanan->add($orderItem);
        }

        session()->put('order', $order);

        return back()->with('success', 'Menu ditambahkan ke dalam keranjang');
    }

    public function cart()
    {
        $order = session()->get('order', new Pesanan());
        return view('orders.cart', compact('order'));
    }

    public function decreaseQuantity($itemId)
    {
        $order = session()->get('order');
        if ($order) {
            $item = $order->detailPesanan->where('id_menu', $itemId)->first();
            if ($item && $item->qty > 1) {
                $item->qty--;
                session()->put('order', $order);
            }
        }
        return redirect()->route('order.cart');
    }

    public function increaseQuantity($itemId)
    {
        $order = session()->get('order');
        if ($order) {
            $item = $order->detailPesanan->where('id_menu', $itemId)->first();
            if ($item) {
                $item->qty++;
                session()->put('order', $order);
            }
        }
        return redirect()->route('order.cart');
    }

    public function deleteItem($itemId)
    {
        // Mengambil session order
        $order = session()->get('order');

        if ($order) {
            // Menghapus item berdasarkan id_menu
            $detailPesanan = $order->detailPesanan->where('id_menu', $itemId)->first();
            if ($detailPesanan) {
                $order->detailPesanan = $order->detailPesanan->filter(function ($item) use ($itemId) {
                    return $item->id_menu != $itemId;
                });
                session()->put('order', $order);
            }
        }

        // Redirect kembali ke halaman cart dengan pesan sukses
        return redirect()->route('order.cart')->with('success', 'Item berhasil dihapus dari cart.');
    }

    public function confirmOrder()
    {

        $order = session()->get('order');

        return view('orders.confirmation', compact('order'));
    }


    public function storeOrder(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.is_production');
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $request->validate([
            'no_meja' => 'required|numeric',
            'nama' => 'required|string',
            'no_hp' => 'required|numeric',
        ]);

        $orderData = session()->get('order');

        if ($orderData instanceof Pesanan) {
            $totalHarga = 0;
            foreach ($orderData->detailPesanan as $detail) {
                $totalHarga += $detail->menu->harga * $detail->qty;
            }

            $order = new Pesanan();
            $order->kode_order = rand(1, 1000);
            $order->no_meja = $request->input('no_meja');
            $order->nama = $request->input('nama');
            $order->no_hp = $request->input('no_hp');
            $order->total_harga = $totalHarga;
            $order->status_pesanan = 'Menunggu';
            $order->save();

            foreach ($orderData['detailPesanan'] as $detail) {
                $detailMenu = Menu::find($detail['id_menu']);
                DetailPesanan::create([
                    'id_pesanan' => $order->id,
                    'id_menu' => $detail['id_menu'],
                    'qty' => $detail['qty'],
                    'harga' => $detailMenu->harga,
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order['kode_order'],
                    'gross_amount' => $order['total_harga'],
                ],
                'customer_details' => [
                    'email' => 'G4Cp6@example.com',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            return view('payments.snap', compact('snapToken', 'order'));
        }
    }

    public function paymentSuccess()
    {
        session()->forget('order');

        return redirect()->route('daftarmenu')->with('success', 'Pesanan Berhasil Dibuat, Anda dapat melihatnya pada menu Cek Pesanan');
    }

    public function paymentCancel($id)
    {

        $order = Pesanan::find($id);

        if ($order) {
            $order->detailPesanan()->delete();

            $order->delete();


            return redirect()->route('daftarmenu')->with('success', 'Pesanan dibatalkan');
        } else {
            return redirect()->route('daftarmenu')->with('error', 'Pesanan tidak ditemukan');
        }
    }

    
}




// \Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
//         // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
//         \Midtrans\Config::$isProduction = false;
//         // Set sanitization on (default)
//         \Midtrans\Config::$isSanitized = true;
//         // Set 3DS transaction for credit card to true
//         \Midtrans\Config::$is3ds = true;

//         $params = array(
//             'transaction_details' => array(
//                 'order_id' => rand(),
//                 'gross_amount' => 10000,
//             ),
//             'customer_details' => array(
//                 'first_name' => 'budi',
//                 'last_name' => 'pratama',
//                 'email' => 'budi.pra@example.com',
//                 'phone' => '08111222333',
//             ),
//         );
        // $snapToken = \Midtrans\Snap::getSnapToken($params);


//Proses Save Order Sebelumnya
// $order = new Pesanan();
//             $order->no_meja = $request->input('no_meja');
//             $order->nama = $request->input('nama');
//             $order->no_hp = $request->input('no_hp');
//             $order->total_harga = $totalHarga;
//             $order->status_pesanan = 'Menunggu';
//             $order->save();

//             // Simpan detail pesanan
//             foreach ($orderData->detailPesanan as $detail) {
//                 DetailPesanan::create([
//                     'id_pesanan' => $order->id,
//                     'id_menu' => $detail['id_menu'],
//                     'qty' => $detail['qty'],
//                     'harga' => $detail['menu']['harga'],
//                 ]);
//             }
//             // Hapus order dari session setelah disimpan ke database
//             session()->forget('order');