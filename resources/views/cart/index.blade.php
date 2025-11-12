@extends('layouts.app')

@section('title', 'Shopping Cart - Wardes')

@section('content')
    <div class="container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Cart Items List -->
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

                @if(count($cartItems) > 0)
                    <div class="bg-white rounded-lg shadow-md">
                        @foreach($cartItems as $cartItem)
                            <div class="flex items-center p-6 hover:bg-gray-50 border-b border-gray-200">
                                <div class="flex-shrink-0 w-24 h-24">
                                    <img class="w-full h-full object-cover rounded"
                                        src="{{ asset('storage/' . $cartItem->item->gambar) }}" alt="{{ $cartItem->item->nama }}"
                                        onerror="this.src='https://via.placeholder.com/150'">
                                </div>

                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $cartItem->item->nama }}</h3>
                                    <p class="text-sm text-gray-600">Rp {{ number_format($cartItem->price, 0, ',', '.') }}</p>

                                    <div class="flex items-center mt-4">
                                        <form action="{{ route('cart.update-quantity', $cartItem->id) }}" method="POST"
                                            class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" onclick="decrementQuantity(this)"
                                                class="text-gray-500 focus:outline-none focus:text-gray-600">
                                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1"
                                                class="mx-2 w-16 text-center border rounded-md" onchange="this.form.submit()">
                                            <button type="button" onclick="incrementQuantity(this)"
                                                class="text-gray-500 focus:outline-none focus:text-gray-600">
                                                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="ml-6">
                                    <p class="text-lg font-semibold text-gray-800">
                                        Rp {{ number_format($cartItem->price * $cartItem->quantity, 0, ',', '.') }}
                                    </p>
                                </div>

                                <form action="{{ route('cart.remove-item', $cartItem->id) }}" method="POST" class="ml-6">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <p class="text-gray-600">Your cart is empty</p>
                        <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700">
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Tax (10%)</span>
                        <span>Rp {{ number_format($totalPrice * 0.1, 0, ',', '.') }}</span>
                    </div>

                    <hr class="my-4">

                    <div class="flex justify-between mb-6">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-lg font-semibold">
                            Rp {{ number_format($totalPrice * 1.1, 0, ',', '.') }}
                        </span>
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6">
                        @csrf
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>

                @push('scripts')
                    <script>
                        function incrementQuantity(button) {
                            const input = button.previousElementSibling;
                            input.value = parseInt(input.value) + 1;
                            input.form.submit();
                        }

                        function decrementQuantity(button) {
                            const input = button.nextElementSibling;
                            const newValue = parseInt(input.value) - 1;
                            if (newValue >= 1) {
                                input.value = newValue;
                                input.form.submit();
                            }
                        }
                    </script>
                @endpush
            </div>
        </div>
    </div>
@endsection