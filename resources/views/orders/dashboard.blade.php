<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="">
                            <h2 class="text-xl">Total Orders</h2>
                            <span>$ {{ number_format($orders->sum('total'), 2) }}</span>
                        </div>
                        <div class="">
                            <h2 class="text-xl">Average Order Value</h2>
                            <span>$ {{ number_format($orders->avg('total'), 2) }}</span>
                        </div>
                        <div class="">
                            <h2 class="text-xl">Minimum Order value</h2>
                            <span>$ {{ number_format($orders->min('total'), 2) }}</span>
                        </div>
                        <div class="">
                            <h2 class="text-xl">Maximum Order value</h2>
                            <span>$ {{ number_format($orders->max('total'), 2) }}</span>
                        </div>
                    </div>

                    <table class="table-auto w-full mt-4">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Order ID</th>
                                <th class="px-4 py-2">Customer Name</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="border px-4 py-2">{{ $order->id }}</td>
                                    <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $order->total }}</td>
                                    <td class="border px-4 py-2">{{ $order->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
