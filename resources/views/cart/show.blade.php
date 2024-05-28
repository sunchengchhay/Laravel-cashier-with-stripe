<x-app-layout>
    <x-nav-link :href="route('products.index')"
        class="mx-4 bg-slate-300 my-4 py-2 px-6 hover:bg-slate-400 hover:text-white rounded-md">
        back
    </x-nav-link>

    <h2 class="text-center text-4xl mb-10">Your Cart</h2>
    <div class="w-full flex-col justify-center">
        @if (session('cart'))
            <table class="table border border-gray-300 mx-auto text-center">
                <thead class="text-2xl">
                    <tr>
                        <th class="px-4 py-2">No.</th>
                        <th class="px-4 py-2">Product</th>
                        <th class="px-4 py-2">Quantity</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = 1;
                        $totalAmount = 0;
                    @endphp
                    @foreach (session('cart') as $id => $details)
                        @php
                            $total = $details['quantity'] * $details['price'];
                            $totalAmount += $total;
                        @endphp
                        <tr>
                            <td class="px-4 py-2">{{ $counter++ }}</td>
                            <td class="px-4 py-2">{{ $details['name'] }}</td>
                            <td class="px-4 py-2">{{ $details['quantity'] }}</td>
                            <td class="px-4 py-2">${{ $details['price'] }}</td>
                            <td class="px-4 py-2">${{ $details['quantity'] * $details['price'] }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger bg-red-500 hover:bg-red-700 text-white p-2 rounded">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="px-4 py-2 font-bold text-right">Total Amount</td>
                        <td class="px-4 py-2 font-bold">${{ $totalAmount }}</td>
                    </tr>
                </tbody>
            </table>
            <form action="{{ route('cart.checkout') }}" method="POST" class="flex justify-center mt-4">
                @csrf
                <button type="submit"
                    class="btn btn-success p-2 bg-slate-300 hover:bg-slate-400 hover:text-white">Checkout</button>
            </form>
        @else
            <p class="text-center">Your cart is empty.</p>
        @endif
    </div>
</x-app-layout>
