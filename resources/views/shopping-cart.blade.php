<!DOCTYPE html>
<html lang="en">

<x-page-title>
    <x-slot:title> Login </x-slot:title>
</x-page-title>

<body class="bg-gray-50 text-gray-800 antialiased">
    <x-navbar/>
    <section class="w-full bg-white py-9 px-8">
        <h1 class="text-center text-[#191919] dark:text-white text-[32px] font-semibold leading-[38px]">
            My Shopping Cart
        </h1>

        <div id="loadingSpinner" class="text-center mt-8">
            <p class="text-gray-500">Loading cart...</p>
        </div>

        <div id="emptyCart" class="text-center mt-8 hidden">
            <p class="text-gray-500 text-lg mb-4">Your cart is empty</p>
            <a href="/Products" class="px-8 py-3.5 bg-[#00b206] text-white rounded-[43px] inline-block">
                Continue Shopping
            </a>
        </div>

        <div id="cartContent" class="hidden">
            <div class="flex items-start mt-8 gap-6">
                <div class="bg-white p-4 w-[800px] rounded-xl">
                    <table class="w-full bg-white rounded-xl">
                        <thead>
                            <tr
                                class="text-center border-b border-gray-400 w-full text-[#7f7f7f] text-sm font-medium uppercase leading-[14px] tracking-wide">
                                <th class="text-left px-2 py-2">Product</th>
                                <th class="px-2 py-2">Price</th>
                                <th class="px-2 py-2">Quantity</th>
                                <th class="px-2 py-2">Subtotal</th>
                                <th class="w-7 px-2 py-2"></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <!-- Cart items will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr class="border-t border-gray-400">
                                <td class="px-2 py-2" colspan="3">
                                    <a href="/Products"
                                        class="px-8 cursor-pointer py-3.5 bg-[#f2f2f2] rounded-[43px] text-[#4c4c4c] text-sm font-semibold leading-[16px]">
                                        Return to shop
                                    </a>
                                </td>
                                <td class="px-2 py-2" colspan="2">
                                    <button id="updateCartBtn"
                                        class="px-8 py-3.5 cursor-pointer bg-[#f2f2f2] rounded-[43px] text-[#4c4c4c] text-sm font-semibold leading-[16px]">
                                        Update Cart
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="w-[424px] bg-white rounded-lg p-6">
                    <h2 class="text-[#191919] mb-2 text-xl font-medium leading-[30px]">
                        Cart Total
                    </h2>
                    <div class="w-[376px] py-3 justify-between items-center flex">
                        <span class="text-[#4c4c4c] text-base font-normal leading-normal">Subtotal:</span>
                        <span id="subtotal" class="text-[#191919] text-base font-semibold leading-tight">$0.00</span>
                    </div>
                    <div
                        class="w-[376px] py-3 shadow-[0px_1px_0px_0px_rgba(229,229,229,1.00)] justify-between items-center flex">
                        <span class="text-[#4c4c4c] text-sm font-normal leading-[21px]">Shipping:</span>
                        <span class="text-[#191919] text-sm font-medium leading-[21px]">Free</span>
                    </div>
                    <div
                        class="w-[376px] py-3 shadow-[0px_1px_0px_0px_rgba(229,229,229,1.00)] justify-between items-center flex">
                        <span class="text-[#4c4c4c] text-sm font-normal leading-[21px]">Total:</span>
                        <span id="total" class="text-[#191919] text-sm font-medium leading-[21px]">$0.00</span>
                    </div>
                    <button
                        class="w-[376px] text-white mt-5 px-10 py-4 bg-[#00b206] rounded-[44px] gap-4 text-base font-semibold leading-tight">
                        Proceed to checkout
                    </button>
                </div>
            </div>

            <div
                class="mt-6 p-5 w-[800px] bg-white rounded-lg border border-[#e6e6e6] justify-start items-center gap-6 inline-flex">
                <h3 class="text-[#191919] w-1/4 text-xl font-medium leading-[30px]">
                    Coupon Code
                </h3>
                <div class="w-full border border-[#e6e6e6]">
                    <input id="couponInput" placeholder="Enter code" type="text"
                        class="w-2/3 px-6 py-3.5 outline-none bg-white rounded-[46px] text-[#999999] text-base font-normal leading-normal" />
                    <button id="applyCouponBtn"
                        class="px-10 py-4 bg-[#333333] rounded-[43px] text-white text-base font-semibold leading-tight">
                        Apply Coupon
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;
        let cartItems = [];

        // Load cart on page load
        document.addEventListener('DOMContentLoaded', loadCart);

        async function loadCart() {
            try {
                const response = await fetch('/cart', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    if (response.status === 401) {
                        window.location.href = '/Login';
                        return;
                    }
                    throw new Error('Failed to load cart');
                }

                const data = await response.json();
                cartItems = data.items;

                if (cartItems.length === 0) {
                    document.getElementById('loadingSpinner').classList.add('hidden');
                    document.getElementById('emptyCart').classList.remove('hidden');
                } else {
                    renderCart();
                    document.getElementById('loadingSpinner').classList.add('hidden');
                    document.getElementById('cartContent').classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error loading cart:', error);
                document.getElementById('loadingSpinner').innerHTML =
                    '<p class="text-red-500">Error loading cart. Please try again.</p>';
            }
        }

        function renderCart() {
            const tbody = document.getElementById('cartTableBody');
            tbody.innerHTML = '';

            let subtotal = 0;

            cartItems.forEach(item => {
                const itemSubtotal = item.product.price * item.quantity;
                subtotal += itemSubtotal;

                const row = document.createElement('tr');
                row.className = 'text-center cart-row';
                row.dataset.cartId = item.id;
                row.innerHTML = `
                    <td class="px-2 py-2 text-left align-top">
                        <img src="https://www.dummyimage.com/100x100/83e688/fff.png&text=${item.product.name}"
                            alt="${item.product.name}" class="w-[100px] mr-2 inline-block h-[100px]" />
                        <span>${item.product.name}</span>
                    </td>
                    <td class="px-2 py-2">$${parseFloat(item.product.price).toFixed(2)}</td>
                    <td class="p-2 mt-9 bg-white rounded-[170px] border border-[#a0a0a0] justify-around items-center flex">
                        <button class="qty-dec cursor-pointer hover:opacity-70">
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.33398 7.5H11.6673" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                        <span class="qty-value w-10 text-center text-[#191919] text-base font-normal">${item.quantity}</span>
                        <button class="qty-inc cursor-pointer hover:opacity-70">
                            <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.33398 7.49998H11.6673M7.00065 2.83331V12.1666" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </td>
                    <td class="px-2 py-2">$${itemSubtotal.toFixed(2)}</td>
                    <td class="px-2 py-2">
                        <button class="remove-btn cursor-pointer hover:opacity-70" title="Remove item">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 23.5C18.0748 23.5 23 18.5748 23 12.5C23 6.42525 18.0748 1.5 12 1.5C5.92525 1.5 1 6.42525 1 12.5C1 18.5748 5.92525 23.5 12 23.5Z" stroke="#CCCCCC" stroke-miterlimit="10"></path>
                                <path d="M16 8.5L8 16.5" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16 16.5L8 8.5" stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>
                    </td>
                `;

                row.querySelector('.qty-dec').addEventListener('click', () => updateQty(item.id, item.quantity - 1));
                row.querySelector('.qty-inc').addEventListener('click', () => updateQty(item.id, item.quantity + 1));
                row.querySelector('.remove-btn').addEventListener('click', () => removeItem(item.id));

                tbody.appendChild(row);
            });

            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `$${subtotal.toFixed(2)}`;
        }

        async function updateQty(cartId, newQty) {
            if (newQty < 1 || newQty > 10) {
                alert('Quantity must be between 1 and 10');
                return;
            }

            try {
                const response = await fetch(`/cart/${cartId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ quantity: newQty })
                });

                if (response.ok) {
                    const item = cartItems.find(i => i.id === cartId);
                    if (item) {
                        item.quantity = newQty;
                        renderCart();
                    }
                } else {
                    alert('Failed to update quantity');
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
            }
        }

        async function removeItem(cartId) {
            if (!confirm('Remove this item from cart?')) return;

            try {
                const response = await fetch(`/cart/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });

                if (response.ok) {
                    cartItems = cartItems.filter(item => item.id !== cartId);
                    if (cartItems.length === 0) {
                        document.getElementById('cartContent').classList.add('hidden');
                        document.getElementById('emptyCart').classList.remove('hidden');
                    } else {
                        renderCart();
                    }
                } else {
                    alert('Failed to remove item');
                }
            } catch (error) {
                console.error('Error removing item:', error);
            }
        }

        document.getElementById('updateCartBtn')?.addEventListener('click', () => {
            alert('Cart updated!');
        });

        document.getElementById('applyCouponBtn')?.addEventListener('click', () => {
            const code = document.getElementById('couponInput').value;
            if (!code.trim()) {
                alert('Please enter a coupon code');
                return;
            }
            alert(`Coupon "${code}" applied! (Feature coming soon)`);
        });
    </script>
</body>

</html>
