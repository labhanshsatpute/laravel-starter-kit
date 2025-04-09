@extends('admin.layouts.app')

@section('panel-header')
    <div>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.view.dashboard') }}">Admin</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.setting') }}">Settings</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.setting.role.permission') }}">Roles & Permissions</a></li>
            <li><i data-feather="chevron-right"></i></li>
            <li><a href="{{ route('admin.view.setting.role.update', ['id' => $role->id]) }}">Edit Role</a></li>
        </ul>
        <h1 class="panel-title">Edit Role</h1>
    </div>
@endsection

@section('panel-body')
    <form action="{{ route('admin.handle.setting.role.update', ['id' => $role->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <figure class="panel-card">
            <div class="panel-card-header">
                <div>
                    <h1 class="panel-card-title">Edit Information</h1>
                    <p class="panel-card-description">Please fill the required fields</p>
                </div>
            </div>
            <div class="panel-card-body">
                <div class="grid 2xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-5">

                    {{-- Name --}}
                    <div class="input-group">
                        <label for="name" class="input-label">Name <em>*</em></label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}"
                            class="input-box-md @error('name') input-invalid @enderror" placeholder="Enter Name"
                            minlength="1" maxlength="250" required>
                        @error('name')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Permissions --}}
                    <div class="space-y-2 2xl:col-span-5 md:col-span-4 sm:col-span-1">
                        <label for="name" class="input-label">Permissions <em>*</em></label>
                        <div class="overflow-x-scroll">
                            <table class="border">
                                @foreach ($permission_groups as $key => $permission_group)
                                <tr>
                                    <td class="border py-2 px-3" colspan="4">
                                        <h6 class="font-medium">{{ucwords(str_replace('_',' ',strtolower($key)))}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    @foreach ($permission_group as $permission)
                                    <td class="border py-2 px-3">
                                        <div class="input-radio">
                                                <input @checked($role->hasPermissionTo($permission)) type="checkbox" name="permissions[]" value="{{$permission->id}}" id="permission_{{$permission->name}}">
                                            <label for="permission_{{$permission->name}}">
                                            {{ucwords(str_replace('_',' ',strtolower($permission->name)))}}
                                            </label>
                                        </div>        
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        @error('permissions')
                            <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="panel-card-footer">
                <button type="submit" class="btn-primary-md md:w-fit sm:w-full">Save Changes</button>
            </div>
        </figure>
    </form>
@endsection

@section('panel-script')
    <script>
        document.getElementById('setting-tab').classList.add('active');

        const handleRemovePermission = (permission_id) => {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this permission!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location =
                            `{{ url('admin/setting/role/remove/permission/' . $role->id . '/${permission_id}') }}`;
                    }
                });
        }
    </script>
@endsection
