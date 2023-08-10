@php use App\Enum\OrderStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach($orders as $orderInfo)
                        <h2 class="text-2xl font-bold mb-2">{{ $orderInfo['week'] }}</h2>

                        <div class="grid grid-cols-4 gap-4 mt-4">
                            <div class="border p-4">
                                <h3 class="text-xl">Total value</h3>
                                <span>${{ number_format($orderInfo['orders']->sum('total'), 2) }}</span>
                            </div>
                            <div class="border p-4">
                                <h3 class="text-xl">Total orders</h3>
                                <span>{{ $orderInfo['orders']->count() }}</span>
                            </div>
                            <div class="border p-4">
                                <h3 class="text-xl">Completed Orders</h3>
                                <span>{{ $orderInfo['orders']->where('status', OrderStatus::COMPLETED->value)->count() }}</span>
                            </div>
                            <div class="border p-4">
                                <h3 class="text-xl">Pending Orders</h3>
                                <span>{{ $orderInfo['orders']->where('status', OrderStatus::PENDING->value)->count() }}</span>
                            </div>
                        </div>

                        <table class="table-auto w-full mt-4 mb-4">
                            <thead>
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">User</th>
                                <th class="px-4 py-2">Order time</th>
                                <th class="px-4 py-2">Delivery time</th>
                                <th class="px-4 py-2">Products Amount</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderInfo['orders'] as $order)
                                <tr>
                                    <td class="border px-4 py-2">{{ $order->id }}</td>
                                    <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                    <td class="border px-4 py-2">{{ $order->order_time }}</td>
                                    <td class="border px-4 py-2">{{ $order->delivery_time }}</td>
                                    <td class="border px-4 py-2">{{ $order->products_count }}</td>
                                    <td class="border px-4 py-2">${{ number_format($order->total, 2) }}</td>
                                    <td class="border px-4 py-2">{{ $order->status }}</td>
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
