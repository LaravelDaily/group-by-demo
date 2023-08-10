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
                            <a href="{{ route('group-by') }}">Group By Example</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate') }}">Group By Aggregate Example</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-functions') }}">Group By Aggregate Functions
                                Example</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-aggregate-with-calculations') }}">Group By Aggregate With
                                Calculations Example</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-related-column') }}">Group By Related Column - DB Raw</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-related-column-eloquent') }}">Group By Related Column - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-and-order-related-column-eloquent') }}">Group By and Order By Related Column - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-raw-day-with-eloquent') }}">Group By Raw Day - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-raw-month-with-eloquent') }}">Group By Raw Month - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-multiple-columns-eloquent') }}">Group By Multiple Columns - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-multiple-columns-builder') }}">Group By Multiple Columns - Builder</a>
                        </li>
                        <li>
                            <a href="{{ route('group-by-multiple-columns-error') }}">Group By Multiple Columns Error - Eloquent</a>
                        </li>
                        <li>
                            <a href="{{ route('questions-list-groupped-by-topic') }}">Questions groupped by Topic</a>
                        </li>
                        <li>
                            <a href="{{ route('topics-by-name') }}">Topics By Name</a>
                        </li>
                        <li>
                            <a href="{{ route('users-by-age') }}">Users by Age</a>
                        </li>
                        <li>
                            <a href="{{ route('orders-dashboard') }}">Orders Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('active-and-inactive-users') }}">Active and inactive users count</a>
                        </li>
                        <li>
                            <a href="{{ route('employee-timesheet-report') }}">Employee Timesheet Report</a>
                        </li>
                        <li>
                            <a href="{{ route('orders-by-week-collection') }}">Orders grouped by week - collection</a>
                        </li>
                        <li>
                            <a href="{{ route('order-reports') }}">Order Reports - Collections and Database</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
