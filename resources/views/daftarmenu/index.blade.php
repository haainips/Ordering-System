@extends('layouts.app')
@section('tittle', 'Metreum')

@section('content')
    <x-navbar />
    <div class="p-4 md:p-10">
        <h1 class="py-4 text-bold text-xl font-bold">Daftar Menu</h1>


        <div class="flex overflow-x-auto whitespace-nowrap gap-2 mb-3 pb-3">
            @foreach ($kategori as $kategori)
                <x-sliderkategori :item="$kategori" :selectedCategoryId="$selectedCategoryId" />
            @endforeach
        </div>
        {{-- Tampilkan pesan sukses jika ada --}}
        @if (session('success'))
            <div id="success-alert" class="alert alert-success text-center py-2 px-4">
                <div class="p-2 bg-white items-center px-4 text-black border border-gray-100 leading-none rounded-full drop-shadow-xl flex lg:inline-flex"
                    role="alert">
                    <span class="flex rounded-full bg-green-400 uppercase px-2 py-2 text-xs font-bold mr-3"></span>
                    <span class="font-semibold mr-2 text-left flex-auto">{{ session('success') }}</span>
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
    </div>

    <div id="menu-container" class="flex flex-wrap justify-evenly md:justify-around gap-3 md:gap-y-6 mt-2">
        @foreach ($menu as $item)
            {{-- <x-cardmenu :item="$item" /> --}}
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
        @endforeach
    </div>


    <div id="skeleton-loader" class="hidden skeleton-loader">
        <div class="flex flex-wrap justify-center gap-6">
            <div class="w-40 h-52 bg-shimmer-gradient bg-[length:200%_200%] animate-shimmer rounded-lg skeleton"></div>
            <div class="w-40 h-52 bg-shimmer-gradient bg-[length:200%_200%] animate-shimmer rounded-lg skeleton"></div>
            <div class="w-40 h-52 bg-shimmer-gradient bg-[length:200%_200%] animate-shimmer rounded-lg skeleton"></div>
            <div class="w-40 h-52 bg-shimmer-gradient bg-[length:200%_200%] animate-shimmer rounded-lg skeleton"></div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const categoryLinks = document.querySelectorAll('.category-link');
            const menuContainer = document.getElementById('menu-container');
            const skeletonLoader = document.getElementById('skeleton-loader');
            const alertsuccess = document.getElementById('alert-success');
            const storageUrl = "{{ Storage::url('public/') }}";

            // Add click event listener to success alert
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.addEventListener('click', () => {
                    successAlert.classList.add('hidden');
                });
            }

            categoryLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const categoryId = link.getAttribute('data-id');

                    // Disable all category links
                    categoryLinks.forEach(link => link.setAttribute('disabled', true));

                    // Highlight the selected category link
                    categoryLinks.forEach(link => link.classList.remove('bg-green-900',
                        'text-white'));
                    link.classList.add('bg-green-900', 'text-white');

                    // Show the skeleton loader and hide the menu container
                    menuContainer.classList.add('hidden');
                    skeletonLoader.classList.remove('hidden');

                    axios.get(`/menu/filter/${categoryId}`)
                        .then(response => {
                            const menus = response.data;
                            let html = '';

                            if (menus.length === 0) {
                                html =
                                    '<p class="mt-20 text-gray-600 text-center text-xl font-medium">Menu tidak tersedia</p>';
                            } else {
                                menus.forEach(menu => {
                                    html += `
                                <div class="flex flex-col justify-center items-center p-4 bg-white drop-shadow-lg rounded-xl border-t-2 menu-item" data-category-id="${menu.kategori_id}">
                                    <h3 class="text-center pb-2">${menu.nama_menu}</h3>
                                    <img class="w-28 h-28 object-cover mx-auto rounded-full" src="${storageUrl}${menu.gambar}" alt="${menu.nama_menu}" />
                                    <p class="mt-2 text-sm font-bold">Rp${new Intl.NumberFormat('id-ID').format(menu.harga)}</p>
                                    <div class="add-to-cart">
                                        <form action="{{ route('order.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="${menu.id}">
                                            <button class="add-to-cart-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="green" class="size-10 mt-2">
                                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            `;
                                });
                            }

                            menuContainer.innerHTML = html;
                            skeletonLoader.classList.add('hidden');
                            menuContainer.classList.remove('hidden');

                            // Re-enable all category links
                            categoryLinks.forEach(link => link.removeAttribute('disabled'));
                        })
                        .catch(error => {
                            console.error('Error fetching menus:', error);

                            // Re-enable all category links even if there is an error
                            categoryLinks.forEach(link => link.removeAttribute('disabled'));
                        });
                });
            });
        });
    </script>
@endsection
