<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <ul>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions', ['value' => 'sum']) }}">
                                Sum order totals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions', ['value' => 'avg']) }}">
                                Average order value
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions', ['value' => 'count']) }}">
                                Orders per User
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions', ['value' => 'min']) }}">
                                Min order
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions', ['value' => 'max']) }}">
                                Max order
                            </a>
                        </li>
                    </ul>

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Value</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                <td class="border px-4 py-2">{{ $order->value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
