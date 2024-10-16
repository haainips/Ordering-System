@extends('layouts.app')
@section('tittle', 'Metreum')

@section('content')
    <div
        class=" h-full flex flex-col justify-center items-center min-h-screen bg-gradient-to-t from-lime-100 to-emerald-900">
        <div class="flex flex-col space-y-5 text-center">
            <h1 class="text-white text-5xl font-extrabold drop-shadow-md">Metreum</h1>
            <p class="text-center text-white">Selamat datang di Cafe Metreum.</p>
            <a href="{{route('daftarmenu')}}"
                class="bg-white font-semibold text-black p-2 rounded-lg drop-shadow-lg hover:bg-green-700 hover:text-white delay-50 transition-colors">Daftar
                Menu</a>
            <a href="/cek"
                class="bg-white font-semibold text-black p-2 rounded-lg drop-shadow-lg hover:bg-green-700 hover:text-white delay-50 transition-colors">Cek
                Pesanan</a>
        </div>
    </div>

@endsection
