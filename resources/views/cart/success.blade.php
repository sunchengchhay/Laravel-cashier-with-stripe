<x-app-layout>
    <div class="flex justify-center mt-20 md:mt-40">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
            <p class="text-lg font-semibold">Product Payment: Confirmed</p>
            <p class="pb-5"> Your product has been successfully confirmed and is now being processed.</p>
            <a class="underline text-blue-500 hover:text-blue-800" href="{{ route('dashboard') }}">back to
                dashboard</a>
        </div>
    </div>
</x-app-layout>
