@extends('layouts.app')
@section('title', 'Cek Pesanan')

@section('content')
    <x-navbar />
    <form action="{{ route('order.check') }}" method="POST">
        @csrf

        <div class=" px-4 py-6 flex justify-center">
            <div class="flex flex-col px-6 py-4 border rounded-2xl">
                <h1 class="font-bold text-2xl">Cek Status Pesananmu</h1>
                @if (session('error'))
                    <div id="success-alert" class="alert alert-success text-center pt-8">
                        <div class="p-2 bg-white items-center px-4 text-black border border-gray-100 leading-none rounded-full drop-shadow-xl flex lg:inline-flex"
                            role="alert">
                            <span class="flex rounded-full bg-red-500 uppercase px-2 py-2 text-xs font-bold mr-3"></span>
                            <span class="font-semibold mr-2 text-left flex-auto">{{ session('error') }}</span>
                            <button>
                                <svg class="fill-current h-4 w-4 text-red" role="button" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                <div>
                    <label for="no_hp" class="block text-base font-medium leading-6 text-gray-900 mt-4">Masukkan No
                        Telp</label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="number" name="no_hp" id="no_hp" required
                            class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="Masukkan nomor handphone">
                    </div>
                    <div class="flex justify-center w-full">
                        <button type="submit"
                            class=" mt-4 text-white font-medium py-2 px-6 rounded-xl bg-green-900">Cek</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
