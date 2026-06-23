<x-app-layout>
    @section('page_title', 'Profil Saya')

    <div class="max-w-[800px] mx-auto space-y-6">
        <!-- Update Profile Info Card -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-[#E5E7EB]">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-[#E5E7EB]">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="p-6 bg-white rounded-2xl shadow-sm border border-[#E5E7EB]">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
