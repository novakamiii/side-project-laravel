<!DOCTYPE html>
<html lang="en">

<x-page-title>
    <x-slot:title> Products </x-slot:title>
</x-page-title>

<body class="bg-gray-50 text-gray-800 antialiased">
    <x-navbar> </x-navbar>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto px-4">
        @foreach ($products as $product)
            <x-product-card :sale="$product->sale">
                <x-slot:prodImg>
                    "https://www.dummyimage.com/600x400/83e688/fff.png&text={{ $product->name }}"
                </x-slot:prodImg>
                <x-slot:prodName>
                    {{ $product->name }}
                </x-slot:prodName>
                <x-slot:prodDesc>
                    {{ $product->desc }}
                </x-slot:prodDesc>
                <x-slot:prodPrice>
                    ${{ $product->price }}
                </x-slot:prodPrice>
                <x-slot:prodId>
                    {{ $product->id }}
                </x-slot:prodID>
            </x-product-card>
        @endforeach
    </div>
</body>

</html>
