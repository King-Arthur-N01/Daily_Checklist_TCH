<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        $this->middleware('permission:manageuser', ['only' => ['indexusertable','authenticatecreate','authenticateedit','deleteuser']]);
    }
    public function indexusertable()
    {
        $users=User::get();
        return view('auth.tableuser',['users'=>$users]);
    }
    public function readdatauser($id)
    {
        $getusers=User::find($id);
        return response()->json(['getusers' => $getusers]);
    }
    public function authenticatecreate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'unique:users'],
            'status' => ['required', 'boolean'],
            'department' => ['required','string','max:255'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        // Check if user with same NIK already exists
        $existinguser = User::where('nik', $request->input('nik'))->first();

        if ($existinguser) {
            return response()->json(['error' => 'This USER already exists!'], 422);
        }
        $data = $request->all();
        $user = $this->createuser($data);
        return response()->json(['success' => 'USER account created successfully!']);
    }
    protected function createuser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'status' => $data['status'],
            'department' =>  $data['department'],
            'password' => Hash::make($data['password']),
        ]);
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
        $deleteuser = User::where('id', $id)->delete();

        if ($deleteuser > 0) {
            return response()->json(['success' => 'Data user berhasil dihapus.']);
        } else {
            return response()->json(['error' => 'Data user gagal dihapus!'], 422);
        }
    }
}
