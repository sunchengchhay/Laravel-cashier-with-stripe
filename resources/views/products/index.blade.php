<x-app-layout>
    <h2 class="text-center text-4xl mb-10 mt-5">All Products</h2>
    <div class="w-auto mx-10">
        @if ($products->count())
            <div class="flex justify-around">
                @foreach ($products as $product)
                    <div
                        class="w-[200px] block rounded-lg bg-white p-6 text-surface shadow-secondary-1 dark:bg-surface-dark dark:text-white">
                        <h5 class="mb-2 text-xl font-medium leading-tight">{{ $product->name }}</h5>
                        <p class="mb-4 text-base">{{ $product->description }}</p>
                        <p class="mb-4 text-base">${{ $product->price }}</p>
                        <form
                            class="add-to-cart-form w-22 text-center rounded-md cursor-pointer bg-slate-300 hover:bg-slate-400"
                            method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                class="inline-block text-xs font-medium uppercase leading-normal text-black shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2"
                                data-twe-ripple-init data-twe-ripple-color="light">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <h3 class="text-center">No Products Available</h3>
        @endif
    </div>

    <!-- jQuery (necessary for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart-form').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = "{{ route('cart.add') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(response) {
                        alert(response.success);
                        $('#cart-count').text(response.cartCount);
                    },
                    error: function(response) {
                        alert('Error adding product to cart.');
                    }
                });
            });
        });
    </script>
</x-app-layout>
