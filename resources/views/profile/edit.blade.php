{{-- filepath: resources/views/profile/edit.blade.php --}}
@extends('layouts.new_app')

@section('content')
<div class="py-8 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Profile</h2>

        <div class="space-y-8">
            <!-- Update Profile Information -->
            <div class="bg-white rounded-xl shadow p-8">
                <h3 class="text-lg font-semibold text-indigo-700 mb-4">Update Profile Information</h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-xl shadow p-8">
                <h3 class="text-lg font-semibold text-indigo-700 mb-4">Update Password</h3>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete User -->
            <div class="bg-white rounded-xl shadow p-8">
                <h3 class="text-lg font-semibold text-red-600 mb-4">Delete Account</h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
