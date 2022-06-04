@extends('master')

@section('content')

<div class="space-y-4">

    <x-heading>
        <x-slot:left>Admin</x-slot:left>
        <x-slot:right>
            <button type="button"
                class="flex items-center bg-gray-50 border border-gray-400 py-1 px-2 rounded hover:bg-gray-100"
                onclick="dispatchVueEvent('show_new_upload_form')"
            >
                <x-feathericon-upload class="w-5 h-5 mr-2"/>
                New Upload
            </button>
        </x-slot:right>
    </x-heading>

    <div>
        <resource-upload></resource-upload>
        <admin-dashboard-view></admin-dashboard-view>
    </div>
</div>


@endsection
