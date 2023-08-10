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
                    <h2 class="text-2xl">Users count by Status</h2>

                    <table class="table-auto w-full">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Count</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">Active</td>
                                <td class="border px-4 py-2">{{ $statusCount['1']->count }}</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">Inactive</td>
                                <td class="border px-4 py-2">{{ $statusCount['0']->count }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
