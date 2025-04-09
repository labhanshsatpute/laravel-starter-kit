<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Gender;
use App\Enums\Permission as EnumsPermission;
use App\Enums\Permissions\PermissionGroup;
use App\Enums\Permissions\Setting as PermissionsSetting;
use App\Enums\SettingKey;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Setting;

interface SettingInterface
{
    public function viewSetting();
    public function viewAccountSetting();
    public function handleAccountSetting(Request $request);
    public function viewPasswordSetting();
    public function handlePasswordSetting(Request $request);
    public function viewRolePermission();
    public function viewRoleCreate();
    public function handleRoleCreate(Request $request);
    public function viewRoleUpdate($id);
    public function handleRoleUpdate(Request $request, $id);
    public function handleRemovePermission($role_id, $permission_id);
    public function viewApplicationSetting();
    public function handleApplicationSetting(Request $request);
}

class SettingController extends Controller implements SettingInterface
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except('logout');
    }

    /**
     * View Setting
     *
     * @return mixed
     */
    public function viewSetting(): mixed
    {
        try {

            return view('admin.pages.setting.setting');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Account Setting
     *
     * @return mixed
     */
    public function viewAccountSetting(): mixed 
    {
        try {

            $genders = Gender::class;

            return view('admin.pages.setting.account-setting',[
                'genders'=> $genders
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * Handle Account Setting
     *
     * @return RedirectResponse
     */
    public function handleAccountSetting(Request $request): RedirectResponse
    {
        try {
            
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:250'],
                'email' => [
                    'required', 'string', 'min:1', 'max:250',
                    Rule::unique('admins')->ignore(auth('admin')->user()->id, 'id')
                ],
                'phone' => [
                    'required', 'numeric', 'digits_between:10,20',
                    Rule::unique('admins')->ignore(auth('admin')->user()->id, 'id')
                ],
                'profile_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp'],
                'date_of_birth' => ['nullable', 'string', 'min:1', 'max:50'],
                'gender' => ['nullable', 'string', 'min:1', 'max:50'],
                'account_password' => ['required', 'string', 'min:1', 'max:100'],
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            if (Hash::check($request->input('account_password'), auth('admin')->user()->password)) {

                $admin = Admin::find(auth('admin')->user()->id);
                $admin->name = $request->input('name');
                $admin->email = $request->input('email');
                $admin->phone = $request->input('phone');
                $admin->gender = $request->input('gender');
                $admin->date_of_birth = $request->input('date_of_birth');
                if ($request->hasFile('profile_image')) {
                    if (!is_null(auth('admin')->user()->profile_image)) Storage::delete(auth('admin')->user()->profile_image);
                    $admin->profile_image = $request->file('profile_image')->store('admins');
                }
                $admin->update();
                
                return redirect()->back()->with('message', [
                    'status' => 'success',
                    'title' => 'Changes saved',
                    'description' => 'The changes are successfully saved'
                ]);
            }

            return redirect()->back()->withErrors([
                'account_password' => 'Incorrect password'
            ]);

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Password Setting
     *
     * @return mixed
     */
    public function viewPasswordSetting(): mixed 
    {
        try {

            return view('admin.pages.setting.password-setting');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * Handle Password Setting
     *
     * @return RedirectResponse
     */
    public function handlePasswordSetting(Request $request): RedirectResponse
    {
        try {
            
            $validation = Validator::make($request->all(), [
                'current_password' => ['required', 'string', 'min:1', 'max:100'],
                'password' => ['required', 'string', 'min:6', 'max:20', 'confirmed'],
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            if (Hash::check($request->input('current_password'), auth('admin')->user()->password)) {

                $admin = Admin::find(auth('admin')->user()->id);
                $admin->password = Hash::make($request->input('password'));
                $admin->update();
                
                return redirect()->back()->with('message', [
                    'status' => 'success',
                    'title' => 'Password updated',
                    'description' => 'The password is successfully updated'
                ]);
            }

            return redirect()->back()->withErrors([
                'current_password' => 'Current password not matched'
            ]);

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Role & Permission
     *
     * @return mixed
     */
    public function viewRolePermission(): mixed 
    {
        try {

            $admin = Admin::find(auth('admin')->user()->id);
            if (!$admin->can(PermissionsSetting::ROLES_AND_PERMISSION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $roles = Role::all();

            return view('admin.pages.setting.role-permission-setting',[
                'roles' => $roles
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * View Role Create
     *
     * @return mixed
     */
    public function viewRoleCreate(): mixed 
    {
        try {

            $admin = Admin::find(auth('admin')->user()->id);
            if (!$admin->can(PermissionsSetting::ROLES_AND_PERMISSION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }

            $permission_groups = Permission::get()->groupBy('group');

            return view('admin.pages.setting.role-create',[
                'permission_groups' => $permission_groups
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * Handle Role Create
     *
     * @return RedirectResponse
     */
    public function handleRoleCreate(Request $request): RedirectResponse
    {
        try {

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:100','unique:roles'],
                'permissions' => ['required', 'array'],
                'permissions.*' => ['required', 'string']
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $role = Role::create(['name' => $request->input('name')]);
            
            if ($request->permissions) {
                foreach ($request->permissions as $value) {
                    $permission = Permission::findById($value);
                    $role->givePermissionTo($permission);
                }
            }

            return redirect()->route('admin.view.setting.role.permission')->with('message', [
                'status' => 'success',
                'title' => 'Role Created',
                'description' => 'The role is successfully created'
            ]);

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Role Update
     *
     * @return mixed
     */
    public function viewRoleUpdate($id): mixed 
    {
        try {

            $admin = Admin::find(auth('admin')->user()->id);
            if (!$admin->can(PermissionsSetting::ROLES_AND_PERMISSION->value)) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Unauthorized Access',
                    'description' => "You do not have access to this url"
                ]);
            }
            
            $role = Role::findById($id);

            if (!$role) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Role not found',
                    'description' => 'Role not found with specified ID'
                ]);
            }

            $permission_groups = Permission::get()->groupBy('group');
            $role_permissions = $role->getAllPermissions();

            return view('admin.pages.setting.role-update',[
                'role' => $role,
                'permission_groups' => $permission_groups,
                'role_permissions' => $role_permissions,
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * Handle Role Update
     *
     * @return RedirectResponse
     */
    public function handleRoleUpdate(Request $request, $id): RedirectResponse
    {
        try {

            $role = Role::findById($id);

            if (!$role) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Role not found',
                    'description' => 'Role not found with specified ID'
                ]);
            }

            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:1', 'max:100'],
                'permissions' => ['nullable', 'array'],
                'permissions.*' => ['required', 'string']
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            $role->name = $request->input('name');
            $role->update();

            $role->syncPermissions($request->permissions);

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved'
            ]);

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Handle Remove Permission
     *
     * @return RedirectResponse
     */
    public function handleRemovePermission($role_id, $permission_id): RedirectResponse
    {
        try {

            $role = Role::findById($role_id);

            if (!$role) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Role not found',
                    'description' => 'Role not found with specified ID'
                ]);
            }

            $permission = Permission::findById($permission_id);

            if (!$permission) {
                return redirect()->back()->with('message', [
                    'status' => 'warning',
                    'title' => 'Permission not found',
                    'description' => 'Permission not found with specified ID'
                ]);
            }

            $role->revokePermissionTo($permission);

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Permission removed',
                'description' => 'The permission is successfully removed'
            ]);

        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

    /**
     * View Application Setting
     *
     * @return mixed
     */
    public function viewApplicationSetting(): mixed 
    {
        try {

            $genders = Gender::class;

            return view('admin.pages.setting.application-setting',[
                'genders'=> $genders
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }    
    }

    /**
     * Handle Application Setting
     *
     * @return RedirectResponse
     */
    public function handleApplicationSetting(Request $request): RedirectResponse
    {
        try {
            
            $validation = Validator::make($request->all(), [
                'application_name' => ['required', 'string', 'min:1', 'max:250'],
                'application_summary' => ['required', 'string', 'min:1', 'max:250'],
                'application_logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
                'application_favicon' => ['nullable', 'file', 'mimes:jpg,jpeg,png']
            ]);
    
            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation)->withInput();
            }

            if ($request->hasFile('application_logo')) {

                $old_logo = Setting::where('key', SettingKey::APPLICATION_LOGO->value)->first()->value;

                Storage::delete($old_logo);

                $new_logo = $request->file('application_logo')->storeAs('others/logo', 'logo.png');

                Setting::where('key', SettingKey::APPLICATION_LOGO->value)->update([
                    'value' => $new_logo
                ]);
            }

            if ($request->hasFile('application_favicon')) {

                $old_favicon = Setting::where('key', SettingKey::APPLICATION_FAVICON->value)->first()->value;
                
                Storage::delete($old_favicon);

                $new_favicon = $request->file('application_favicon')->storeAs('others/favicon', 'favicon.png');

                Setting::where('key', SettingKey::APPLICATION_FAVICON->value)->update([
                    'value' => $new_favicon
                ]);
            }

            Setting::where('key', SettingKey::APPLICATION_NAME->value)->update([
                'value' => $request->input('application_name')
            ]);

            Setting::where('key', SettingKey::APPLICATION_SUMMARY->value)->update([
                'value' => $request->input('application_summary')
            ]);

            return redirect()->back()->with('message', [
                'status' => 'success',
                'title' => 'Changes saved',
                'description' => 'The changes are successfully saved'
            ]);
                
        } catch (Exception $exception) {
            return redirect()->back()->with('message', [
                'status' => 'error',
                'title' => 'An error occcured',
                'description' => $exception->getMessage()
            ]);
        }
    }

}