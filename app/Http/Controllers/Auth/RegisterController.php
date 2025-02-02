<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('permission:manageuser', ['only' => ['manage_user']]);
    }
    public function indexusertable()
    {
        return view('auth.tableuser');
    }
    public function refreshtableuser()
    {
        try{
            $refreshusers = User::get();
            return response()->json(['refreshusers' => $refreshusers]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 500);
        }
    }
    public function finduser($id)
    {
        $getusers=User::find($id);
        return response()->json(['getusers' => $getusers]);
    }
    public function authenticatecreate(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'nik' => ['required', 'string', 'unique:users'],
                'status' => ['required', 'boolean'],
                'department' => ['required','string','max:255'],
                'role' => ['required','string','max:255'],
                'password' => ['required', 'string', 'confirmed'],
            ]);

            $data = $request->all();
            $this->createuser($data);
            return response()->json(['success' => 'USER account created successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'This NIK already exists! or Password confirmation not match'], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating user'], 500);
        }
    }

    protected function createuser(array $data)
    {
        // Buat user baru
        $user = User::create([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'status' => $data['status'],
            'department' => $data['department'],
            'password' => Hash::make($data['password']),
        ]);

        // Menetapkan role berdasarkan input
        switch ($data['role']) {
            case '6':
                $user->assignRole('planner');
                break;
            case '5':
                $user->assignRole('operator');
                break;
            case '4':
                $user->assignRole('leader');
                break;
            case '3':
                $user->assignRole('foreman');
                break;
            case '2':
                $user->assignRole('supervisor');
                break;
            case '1':
                $user->assignRole('manager');
                break;
            default:
                // Handle case where role is not recognized
                break;
        }

        return $user;
    }
    public function authenticateedit(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'department' => ['required'],
        ]);
        $user = User::find($id);
        $user->update($request->all());
        return response()->json(['success' => 'USER account update successfully!']);
    }
    // public function deleteuser($id){
    //     User::where('id',$id)->delete();
    //     return back()->with('success','User berhasil dihapus');
    // }
    public function deleteuser($id) {
        try{
            $DeleteUser = User::where('id', $id);
            $DeleteUser->delete();
            return response()->json(['success' => 'User account berhasil di HAPUS!']);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Error delete data'], 500);
        }
    }
}
