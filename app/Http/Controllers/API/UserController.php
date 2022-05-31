<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
// use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
// use Auth;

class UserController extends Controller
{
    // public $succes_status = 200;

    public function login()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')]))
        {
            // $user = Auth::user();
            if(Auth::user()->division_id==1)
            {
                $user = Auth::user();
                $response ['status'] =  true;
                $response ['message'] =  'Admin Divisi UI/UX Berhasil Login';
                $response ['data'] ['token'] =  $user->createToken('cms')->accessToken;

                return response()->json($response, 200);
            }
            else
            {
                $user = Auth::user();
                $response ['status'] =  true;
                $response ['message'] =  'Berhasil Login';
                $response ['data'] ['token'] =  $user->createToken('cms')->accessToken;

                return response()->json($response, 200);;
            }
        }
        else
        {
            // return response()->json(['error' => 'Unauthorised', 'status' => false], 401);
            $response['status'] = false;
            $response['message'] = 'Email atau Password Salah';

            return response()->json($response, 401);
        }
    }
    public function register(Request $request)
    {
        // $request->validate([
        $validate = Validator::make($request->all(),[
            'name'          => 'required|string',
            'email'         => 'required|email|string',
            'password'      => 'required|min:8|string',
            // 'C_password'    => 'required|same:password'
        ]);
        if ($validate->fails())
        {
            $response['status'] = false;
            $response['message'] = 'Gagal registrasi';
            $response['error'] = $validate->errors();
            return response()->json($response, 401);
        }
        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->division_id    = $request->division_id;
        $user->password = bcrypt($request->password);
        $user->role     = 'admin';
        $user->save();

        // $user = User::create([
        //     'name' => $request['name'],
        //     'email' => $request['email'],
        //     'password' => Hash::make($request['password']),
        //     'role' => $request->user,
        // ]);

        $response['status'] = true;
        $response['message'] = 'Berhasil registrasi';
        $response['token'] =  $user->createToken('cms')->accessToken;
        return response()->json($response, 200);
    }
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'required|string',
            'email'         => 'required|email|string',
            'password'      => 'required|min:8|string',
        ]);
        if ($validate->fails())
        {
            $response['status'] = false;
            $response['message'] = 'Gagal Menambahkan';
            $response['error'] = $validate->errors();
            return response()->json($response, 401);
        }
        $user = new User();
        $user->name           = $request->name;
        $user->email          = $request->email;
        $user->division_id    = $request->division_id;
        $user->password       = bcrypt($request->password);
        $user->save();

        $response['status']     = true;
        $response['message']    = 'Berhasil Menambahkan';
        $response['token']      =  $user->createToken('cms')->accessToken;
        return response()->json($response, 200);

    }
}
