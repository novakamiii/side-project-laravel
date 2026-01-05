@props(['sale' => true])
<div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition overflow-hidden group">
    <div class="relative">
        <img src={{ $prodImg }} alt="Product Image"
            class="w-full h-60 object-cover group-hover:scale-105 transition-transform" />
        @if ($sale)
            <span class="absolute top-3 right-3 bg-red-600 text-white text-xs px-2 py-1 rounded">SALE</span>
        @else
            <span class="absolute top-3 right-3 bg-black text-white text-xs px-2 py-1 rounded">NEW</span>
        @endif
    </div>
    <div class="p-5">
        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $prodName }}</h3>
        <p class="text-sm text-gray-500 mb-2">{{ $prodDesc }}</p>
        <div class="flex justify-between items-center mt-4">
            <span class="text-lg font-semibold text-green-600">{{ $prodPrice }}</span>
            <a href="{{ url('Product') }}?item={{ $prodId }}">
                <button class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">Buy</button>
            </a>
        </div>
    </div>
</div>
