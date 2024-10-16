@extends('layouts.app')
@section('tittle', 'Metreum')
@section('content')


    <x-navbar />
    <div class="py-6 px-4">
        <h1 class="font-medium text-xl">Konfirmasi Pesanan</h1>
        <form action="{{ route('order.store') }}" method="POST"
            class="bg-white px-4 py-4 pb-6 rounded-lg shadow-md mt-6 border border-t-gray-200">
            @csrf
            <div class=" px-4 py-4 pb-6  mb-4">
                <div>
                    <label for="no_meja" class="block text-base font-medium leading-6 text-gray-900">No Meja</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="number" name="no_meja" id="no_meja" required
                            class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="">
                    </div>
                </div>
                <div class=" mt-4">
                    <label for="nama" class="block text-base font-medium leading-6 text-gray-900">Nama Pemesan</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="text" name="nama" id="nama" required="required"
                            class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="">
                    </div>
                </div>
                <div class=" mt-4">
                    <label for="no_hp" class="block text-base font-medium leading-6 text-gray-900">No Telp</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="number" name="no_hp" id="no_hp" required="required"
                            class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="">
                    </div>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                @foreach ($order->detailPesanan as $item)
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <img src="{{ Storage::url('public/' . $item->menu->gambar) }}"
                                alt="{{ $item->menu->nama_menu }}" class="w-16 h-16 object-cover rounded-lg">
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold">{{ $item->menu->nama_menu }}</h2>
                                <p class="text-gray-600">Rp{{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-4">
                            <span class="text-lg" id="quantity-{{ $item->id_menu }}">{{ $item->qty }}</span>
                            <div class="loading-icon hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 15s1-1 4-1v7a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V15zm16 0s1-1 4-1v7a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V15z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 15s1-1 4-1v7a1 1 0 0 1-1 1H17a1 1 0 0 1-1-1V15z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="text-right">
                    <h2 class="text-xl font-semibold" id="total-harga">Total:
                        Rp{{ number_format($order->detailPesanan->sum(function ($item) {return $item->menu->harga * $item->qty;}),0,',','.') }}
                    </h2>
                </div>
            </div>
            <div class="bg-green-900 rounded-full mt-4">
                <button type="submit" class="w-full text-white font-bold py-2 px-4 ">Pesan</button>
            </div>
        </form>

        
    </div>

@endsection
