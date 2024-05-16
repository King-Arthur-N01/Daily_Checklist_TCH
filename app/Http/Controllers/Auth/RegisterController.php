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
        $this->middleware('permission:manageuser', ['only' => ['readusertable']]);
        $this->middleware('permission:create', ['only' => ['authenticatecreate']]);
        $this->middleware('permission:delete', ['only' => ['deleteuser']]);
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
