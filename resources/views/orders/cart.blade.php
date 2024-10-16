@extends('layouts.app')
@section('title', 'Cart')

@section('content')

    <x-navbar />
    <div class="p-4 md:p-10">
        <span class="flex gap-x-2">
            <a href="{{ route('daftarmenu') }}" class="text-gray-400 text-base hover:text-gray-800 hover:underline">Daftar
                Menu</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="grey"
                width="20" height="20" class="pt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <a href="" class="text-gray-900 text-base">Keranjang</a>
        </span>
        <h1 class="py-4 text-bold text-xl font-bold">Keranjang Anda</h1>

        @if ($order instanceof \App\Models\Pesanan && $order->detailPesanan->count() > 0)
            <div class="bg-white p-4 rounded-lg shadow-md">
                @foreach ($order['detailPesanan'] as $item)
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <img src="{{ Storage::url('public/' . $item->menu->gambar) }}"
                                alt="{{ $item->menu->nama_menu }}" class="w-16 h-16 object-cover rounded-lg">
                            <div class="ml-4">
                                <h2 class="text-base font-semibold">{{ $item->menu->nama_menu }}</h2>
                                <p class="text-gray-600">Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-2">
                            <a href="{{ route('order.decreaseQuantity', $item->id_menu) }}"
                                class="text-black px-2 py-2 rounded-md bg-gray-300 ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                </svg>
                            </a>
                            <span class="text-lg" id="quantity-{{ $item->id_menu }}">{{ $item->qty }}</span>
                            <a href="{{ route('order.increaseQuantity', $item->id_menu) }}"
                                class="text-black px-2 py-2 rounded-md bg-gray-300 increase-quantity"
                                data-detail-pesanan-id="{{ $item->id_menu }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </a>
                            <div class="loading-icon hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 15s1-1 4-1v7a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V15zm16 0s1-1 4-1v7a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V15z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 15s1-1 4-1v7a1 1 0 0 1-1 1H17a1 1 0 0 1-1-1V15z" />
                                </svg>
                            </div>
                            <form action="{{ route('order.deleteItem', $item['id_menu']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="text-right">
                    <h2 class="text-xl font-semibold" id="total-harga">Total:
                        Rp{{ number_format($order['detailPesanan']->sum(function ($item) {return $item->menu->harga * $item->qty;}),0,',','.') }}
                    </h2>
                </div>
            </div>
        @else
            <p class="text-center text-gray-600">Keranjang belanja Anda kosong.</p>
        @endif
        <div class=" py-4">
            @if ($order->detailPesanan->count() < 0)
                <div class="bg-green-900 px-4 py-2 rounded-xl w-fit flex justify-end hover:scale-105 duration-100">
                    <a href="{{ route('order.confirm') }}" class="text-white text-center font-medium">
                        Pesan Menu
                    </a>
                </div>
                @else
                <div class="bg-green-900 px-4 py-2 rounded-xl w-fit flex justify-end hover:scale-105 duration-100">
                    <a href="{{ route('order.confirm') }}" class="text-white text-center font-medium">
                        Konfirmasi Pesanan
                    </a>
                </div>
            @endif
        </div>
    </div>





@endsection
