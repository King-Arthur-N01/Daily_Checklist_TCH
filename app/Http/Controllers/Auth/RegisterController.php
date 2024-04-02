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
        $this->middleware('permission:view posts', ['only' => ['indexregistration']]);
        $this->middleware('permission:create posts', ['only' => ['createuser']]);
        $this->middleware('permission:delete posts', ['only' => ['deleteuser']]);
    }
    public function readusertable()
    {
        $users=User::get();
        return view('auth.tableuser',['users'=>$users]);
    }
    public function indexregistration()
    {
        return view('auth.register');
    }
    public function indexedit($id)
    {
        $users=User::find($id);
        return view('auth.edituser',['users'=>$users]);
    }
    public function authenticatecreate(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'unique:users'],
            'department' => ['required','string','max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data = $request->all();
        $check = $this->createuser($data);
        return redirect("manageuser")->withSuccess('Data telah diinput');
    }
    protected function createuser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'nik' => $data['nik'],
            'department' =>  $data['department'],
            'password' => Hash::make($data['password']),
        ]);
    }
    public function authenticateedit(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'unique:users'],
            'status' => ['required', 'boolean'],
            'department' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route("manageuser")->withSuccess('User updated successfully.');
    }
    public function deleteuser($id){
        User::where('id',$id)->delete();
        return back()->with('success','User berhasil dihapus');
    }
}
