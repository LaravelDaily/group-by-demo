<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders By Week') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach($orders as $week => $ordersList)
                        <h2 class="text-2xl font-bold mb-2">{{ $week }}</h2>

                        <table class="table-auto w-full mt-4 mb-4">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Order time</th>
                                <th class="px-4 py-2">Delivery time</th>
                                <th class="px-4 py-2">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ordersList as $order)
                                <tr>
                                    <td class="border px-4 py-2">{{ $order->id }}</td>
                                    <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $order->order_time }}</td>
                                    <td class="border px-4 py-2">{{ $order->delivery_time }}</td>
                                    <td class="border px-4 py-2">${{ number_format($order->total, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
