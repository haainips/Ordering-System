@extends('layouts.app')
@section('title', 'Cart')

@section('content')

    <x-navbar />
    <div class="px-6 py-4">
        <span class="flex gap-x-2">
            <a href="{{ route('daftarmenu') }}" class="text-gray-400 text-base hover:text-gray-800 hover:underline">Daftar
                Menu</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="grey"
                width="20" height="20" class="pt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <a href="" class="text-gray-900 text-base">Pembayaran</a>
        </span>
        <h1 class="py-4 text-bold text-xl font-bold">Pembayaran</h1>
        <div class="flex justify-center">
            <button type="submit" id="pay-button" class="bg-green-900 px-6 py-2 rounded-full w-fit text-white font-bold">Selesaikan Pesanan</button>
        </div>
        <div class="flex justify-center mt-4">
            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 px-6 py-2 rounded-full w-fit text-white font-bold" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">Batalkan Pesanan</button>
            </form>
        </div>
    </div>
    <div id="snap-container"></div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    window.location.href = '{{ route('payment.success') }}'
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    window.location.href = '{{ route('daftarmenu') }}'
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
@endsection
