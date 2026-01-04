<!DOCTYPE html>
<html lang="en">

<x-page-title>
    <x-slot:title> Home </x-slot:title>
</x-page-title>

<body>
    <x-navbar> </x-navbar>

    <section class="px-4">
        <div
            class="bg-gradient-to-br from-emerald-300 via-green-300 to-teal-400 p-6 sm:p-10 rounded-2xl w-full text-white flex items-center justify-between max-w-2xl mx-auto mt-20">

            <div class="flex flex-col gap-6">
                <div class="">
                    <span class="text-gray-200">Black friday sale</span>
                    <br>
                    <span class="text-gray-200 text-4xl text-white font-semibold">20% off every Product</span>
                </div>
                <a href="" target="_blank" rel="noreferrer"
                    class="text-black bg-white hover:bg-gray-50 px-4 py-2 rounded-lg w-fit  ease duration-300 flex gap-1 items-center group">
                    <span>Buy now</span>
                    <svg data-v-e660a7a7="" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                        class="group-hover:translate-x-1 transition-transform ease duration-200" width="1em"
                        height="1em" viewBox="0 0 256 256">
                        <path fill="currentColor"
                            d="m221.66 133.66l-72 72a8 8 0 0 1-11.32-11.32L196.69 136H40a8 8 0 0 1 0-16h156.69l-58.35-58.34a8 8 0 0 1 11.32-11.32l72 72a8 8 0 0 1 0 11.32Z">
                        </path>
                    </svg>
                </a>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-100" viewBox="0 0 15 15">
                    <path fill="currentColor" fill-rule="evenodd"
                        d="M4.5 0A2.5 2.5 0 0 0 2 2.5v.286c0 .448.133.865.362 1.214H1.5A1.5 1.5 0 0 0 0 5.5v1A1.5 1.5 0 0 0 1.5 8H7V4h1v4h5.5A1.5 1.5 0 0 0 15 6.5v-1A1.5 1.5 0 0 0 13.5 4h-.862c.229-.349.362-.766.362-1.214V2.5A2.5 2.5 0 0 0 10.5 0c-1.273 0-2.388.68-3 1.696A3.498 3.498 0 0 0 4.5 0ZM8 4h2.786C11.456 4 12 3.456 12 2.786V2.5A1.5 1.5 0 0 0 10.5 1A2.5 2.5 0 0 0 8 3.5V4ZM7 4H4.214C3.544 4 3 3.456 3 2.786V2.5A1.5 1.5 0 0 1 4.5 1A2.5 2.5 0 0 1 7 3.5V4Z"
                        clip-rule="evenodd"></path>
                    <path fill="currentColor"
                        d="M7 9H1v3.5A2.5 2.5 0 0 0 3.5 15H7V9Zm1 6h3.5a2.5 2.5 0 0 0 2.5-2.5V9H8v6Z">
                    </path>
                </svg>
            </div>
        </div>
    </section>

    <br>

    <section class="px-4">
        <!-- Category Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <a href="{{ url('Products') }}?tag=all"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">All</a>

            <a href="{{ url('Products') }}?tag=Headphones"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">Headphones</a>

            <a href="{{ url('Products') }}?tag=Shoes"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">Shoes</a>

            <a href="{{ url('Producst') }}?tag=Watches"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">Watches</a>

            <a href="{{ url('Products') }}?tag=Accessories"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full hover:bg-gray-300">Accessories</a>
        </div>


        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- Product Card -->
            <x-product-card :sale="true">
                <x-slot:prodImg>
                    "https://plus.unsplash.com/premium_photo-1680346529160-549ad950bd1f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                </x-slot:prodImg>
                <x-slot:prodName>
                    Noise Cancelling Earphones
                </x-slot:prodName>
                <x-slot:prodDesc>
                    30hr Battery · Bluetooth 5.3
                </x-slot:prodDesc>
                <x-slot:prodPrice>
                    $129.00
                </x-slot:prodPrice>
            </x-product-card>

            <x-product-card :sale="false">
                <x-slot:prodImg>
                    "https://images.unsplash.com/photo-1709258228137-19a8c193be39?q=80&w=2011&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                </x-slot:prodImg>
                <x-slot:prodName>
                    Running Shoes Pro
                </x-slot:prodName>
                <x-slot:prodDesc>
                    Lightweight · Breathable
                </x-slot:prodDesc>
                <x-slot:prodPrice>
                    $89.00
                </x-slot:prodPrice>
            </x-product-card>

            <x-product-card :sale="false">
                <x-slot:prodImg>
                    "https://images.unsplash.com/photo-1718309602791-8f3cc83840b7?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                </x-slot:prodImg>
                <x-slot:prodName>
                    Smart Fitness Watch
                </x-slot:prodName>
                <x-slot:prodDesc>
                    Heart Rate · Sleep Tracking
                </x-slot:prodDesc>
                <x-slot:prodPrice>
                    $149.00
                </x-slot:prodPrice>
            </x-product-card>
        </div>

    </section>


</body>

</html>
