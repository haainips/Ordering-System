@extends('layouts.app')
@section('title', 'Cek Pesanan')

@section('content')
    <x-navbar />
    <div class="px-6 py-4">
        <h1 class="text-xl font-bold">Detail Pesananmu</h1>
        <span class="flex gap-x-2">
            <a href="{{ route('order.view') }}" class="text-gray-400 text-base hover:text-gray-800 hover:underline">Cek Pesanan</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="grey"
                width="20" height="20" class="pt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <a href="" class="text-gray-900 text-base">Detail Pesanan</a>
        </span>

        <div class="mt-6 rounded-2xl border px-6 py-4">
            <span class="flex justify-between items-center py-2">
                <h1 class="font-bold text-2xl text-yellow-500">{{ $order->status_pesanan }}</h1>
                <div class="flex gap-x-1 items-center">
                    <p class="text-gray-600 text-base">Meja</p>
                    <p class="font-bold text-2xl">{{ $order->no_meja }}</p>
                </div>
            </span>

            @foreach ($order->detailPesanan as $item)
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <img src="{{ Storage::url('public/' . $item->menu->gambar) }}" alt="{{ $item->menu->nama_menu }}"
                            class="w-16 h-16 object-cover rounded-lg">
                        <div class="ml-4">
                            <h2 class="text-lg font-semibold">{{ $item->menu->nama_menu }}</h2>
                            <p class="text-gray-600">Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <span class="text-lg" id="quantity-{{ $item->id_menu }}">x{{ $item->qty }}</span>
                    </div>
                </div>
            @endforeach


            <span class="flex justify-between py-1">
                <h1 class="font-bold text-xl text-black">Total</h1>
                <p class="font-bold text-lg">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
            </span>
            <h1 class="text-black text-xl mt-4">Informasi Pemesan</h1>
            <span>
                <h1 class="font-regular text-xl text-gray-600">{{$order->nama}}</h1>
                <p class="text-base text-gray-600">+62 {{$order->no_hp}}</p>
                <span class="flex justify-end">
                    <p class="text-base text-gray-600">{{$order->created_at->diffForHumans()}}</p>
                </span>
            </span>
        </div>
    </div>
@endsection
