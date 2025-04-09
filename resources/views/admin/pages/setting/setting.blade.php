@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{route('admin.view.dashboard')}}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{route('admin.view.setting')}}">Settings</a></li>
        </ul>
        <h1 class="panel-title">Settings</h1>
    </div>
@endsection


@section('panel-body')
<div class="grid 2xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 lg:gap-7 sm:gap-5">

    <figure class="panel-card">
        <div class="panel-card-body">
            <div class="space-y-3">
                <div>
                    <div class="h-[50px] w-[50px] bg-complement rounded-full flex items-center justify-center text-ascent">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>
                    </div>
                </div>
                <div>
                    <h1 class="title-lg">Account Settings</h1>
                    <p class="description">Manage your account information</p>
                </div>
                <div>
                    <a href="{{route('admin.view.setting.account')}}" class="link text-sm flex items-center space-x-2">
                        <span>Edit Information</span>    
                        <i data-feather="edit" class="h-3 w-3 stroke-[2.5px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </figure>

    <figure class="panel-card">
        <div class="panel-card-body">
            <div class="space-y-3">
                <div>
                    <div class="h-[50px] w-[50px] bg-complement rounded-full flex items-center justify-center text-ascent">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z"></path></svg>
                    </div>
                </div>
                <div>
                    <h1 class="title-lg">Update Password</h1>
                    <p class="description">Change your account password</p>
                </div>
                <div>
                    <a href="{{route('admin.view.setting.password')}}" class="link text-sm flex items-center space-x-2">
                        <span>Update Password</span>    
                        <i data-feather="edit" class="h-3 w-3 stroke-[2.5px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </figure>

    @can(\App\Enums\Permissions\Setting::ROLES_AND_PERMISSION->value)
    <figure class="panel-card">
        <div class="panel-card-body">
            <div class="space-y-3">
                <div>
                    <div class="h-[50px] w-[50px] bg-complement rounded-full flex items-center justify-center text-ascent">
                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <div>
                    <h1 class="title-lg">Roles & Permissions</h1>
                    <p class="description">Manage roles & permission settings</p>
                </div>
                <div>
                    <a href="{{route('admin.view.setting.role.permission')}}" class="link text-sm flex items-center space-x-2">
                        <span>Manage Settings</span>    
                        <i data-feather="edit" class="h-3 w-3 stroke-[2.5px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </figure>
    @endcan

    @can(\App\Enums\Permissions\Setting::APPLICATION_SETTING->value)
    <figure class="panel-card">
        <div class="panel-card-body">
            <div class="space-y-3">
                <div>
                    <div class="h-[50px] w-[50px] bg-complement rounded-full flex items-center justify-center text-ascent">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 32 32" height="1.5em" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="M 5.25 2.75 L 4.6875 3.28125 L 3.28125 4.6875 L 2.75 5.25 L 3.15625 5.90625 L 5.25 9.40625 L 5.53125 9.90625 L 8.46875 9.90625 L 12.46875 13.875 C 8.894531 17.464844 4.347656 22.027344 4.1875 22.1875 C 2.621094 23.753906 2.617188 26.320313 4.21875 27.8125 C 5.78125 29.355469 8.328125 29.394531 9.8125 27.8125 C 9.824219 27.800781 9.832031 27.792969 9.84375 27.78125 L 16 21.59375 L 22.1875 27.8125 L 22.28125 27.875 C 23.851563 29.355469 26.347656 29.375 27.8125 27.8125 L 27.8125 27.78125 L 27.84375 27.78125 C 29.375 26.214844 29.390625 23.667969 27.8125 22.1875 L 27.78125 22.15625 L 22.5625 16.96875 C 26.074219 16.640625 28.824219 13.675781 28.875 10.09375 L 28.90625 10.09375 C 28.910156 10.074219 28.90625 10.050781 28.90625 10.03125 C 28.90625 10.019531 28.90625 10.011719 28.90625 10 C 29.003906 8.84375 28.753906 7.738281 28.15625 6.78125 L 27.46875 5.71875 L 22.8125 10.375 L 21.40625 8.90625 L 26.15625 4.15625 L 24.78125 3.59375 C 23.976563 3.25 23.046875 3 22 3 C 18.15625 3 15 6.15625 15 10 C 15 10.417969 15.089844 10.78125 15.15625 11.15625 C 14.71875 11.59375 14.390625 11.953125 13.875 12.46875 L 9.90625 8.5 L 9.90625 5.53125 L 9.40625 5.25 L 5.90625 3.15625 Z M 22 5 C 22.140625 5 22.238281 5.082031 22.375 5.09375 L 18.59375 8.875 L 19.28125 9.59375 L 22.09375 12.5 L 22.78125 13.21875 L 26.75 9.25 C 26.769531 9.480469 26.933594 9.648438 26.90625 9.90625 L 26.90625 10 C 26.90625 12.753906 24.660156 15 21.90625 15 C 21.539063 15 21.09375 14.914063 20.59375 14.8125 L 20.0625 14.71875 L 19.6875 15.09375 L 8.40625 26.40625 L 8.375 26.40625 L 8.375 26.4375 C 7.664063 27.214844 6.421875 27.234375 5.59375 26.40625 L 5.59375 26.375 L 5.5625 26.375 C 4.785156 25.664063 4.765625 24.421875 5.59375 23.59375 C 5.972656 23.214844 13.3125 15.8125 16.90625 12.21875 L 17.3125 11.8125 L 17.15625 11.25 C 17.074219 10.925781 17 10.367188 17 10 C 17 7.246094 19.246094 5 22 5 Z M 5.5625 5.25 L 7.90625 6.6875 L 7.90625 7.6875 L 7.6875 7.90625 L 6.6875 7.90625 L 5.25 5.5625 Z M 20.1875 17.40625 L 26.40625 23.59375 L 26.40625 23.625 L 26.4375 23.625 C 27.214844 24.335938 27.234375 25.578125 26.40625 26.40625 L 26.375 26.40625 L 26.375 26.4375 C 25.664063 27.214844 24.421875 27.234375 23.59375 26.40625 L 17.40625 20.1875 Z"></path></svg>
                    </div>
                </div>
                <div>
                    <h1 class="title-lg">Application Setting</h1>
                    <p class="description">Manage the application prefrences</p>
                </div>
                <div>
                    <a href="{{route('admin.view.setting.role.permission')}}" class="link text-sm flex items-center space-x-2">
                        <span>Manage Settings</span>    
                        <i data-feather="edit" class="h-3 w-3 stroke-[2.5px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </figure>
    @endcan

</div>
@endsection

@section('panel-script')
<script>
    document.getElementById('setting-tab').classList.add('active');
</script>
@endsection