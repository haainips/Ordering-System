<div class="flex flex-col justify-center items-center p-4 bg-white drop-shadow-lg rounded-xl border-t-2">
    <img class="w-28 h-28 object-cover mx-auto rounded-full" src="{{ Storage::url('public/') . $item->gambar }}"
    alt="{{ $item->nama_menu }}" />
    <h3 class="text-center pt-2">{{ $item->nama_menu }}</h3>
    <p class="mt-2 text-sm font-regular">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>

    <div class="add-to-cart">

        <form action="{{ route('order.add') }}" method="POST" class="add-to-cart-form">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $item->id }}">
            <input type="hidden" name="quantity" value="1">
            <button class="add-to-cart-btn" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" class="size-10 mt-2">
                    <path fill-rule="evenodd"
                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</div>
