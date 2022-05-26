<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        // if(Auth::user()->role=='user'){
        // $lowongan ['status'] = true;
            $lowongan = Lowongan::all();
            return response()->json(['success' => true, 'message' => 'List Semua Data', 'data' => $lowongan], 200);
        // }
    }
    public function store(Request $request)
    {
        if(Auth::user()->role=='admin')
        {
            $validate = Validator::make($request->all(), [
                'name'          => 'required',
                'description'   => 'required',
                'jobdesc'       => 'required',
                'kualification' => 'required',
                'image'         => 'image:jpeg,png,jpg|max:2048'
            ]);
            if($validate->fails())
            {
                return response()->json(['error' => $validate->errors()], 401);
            }
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $file->move(public_path('images', $filename));

            $lowongan = new Lowongan();
            $lowongan->name = $request->name;
            $lowongan->description = $request->description;
            $lowongan->jobdesc = $request->jobdesc;
            $lowongan->kualification = $request->kualification;
            $lowongan->image = $filename;
            $lowongan->date = $request->date;
            $lowongan->save();

            // $lowongan['status'] = true;
            // $lowongan['message'] = 'Lowongan Berhasil Ditambahkan';
            return response()->json(['message' => 'Data Berhasil disimpan']);
        }
        // else{
        //     $lowongan = Lowongan::all();
        //     return response()->json('lowongan', 200);
        // }

    }
    public function update(Request $request, $id)
    {
        if(Auth::user()->role=='admin'){
            $validate = Validator::make($request->all(), [
                'name'          => 'required',
                'description'   => 'required',
                'jobdesc'       => 'required',
                'kualification' => 'required',
                'image'         => 'image:jpeg,png,jpg|max:2048'
            ]);
            if($validate->fails())
            {
                $response['status'] = false;
                $response['message'] = 'Lowongan Gagal Ditambahkan';
                $response['error'] = $validate->errors();
                return response()->json('response', 401);
            }

            if($request->hasFile('file_image'))
            {
                $file = $request->image('file_image');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('images', $filename));

                Lowongan::where('id', $id)->update([
                    "name" => $request->name,
                    "description" => $request->description,
                    "jobdesc" => $request->jobdesc,
                    "kualification" => $request->kualification,
                    "iamge" => $filename,
                    "date" => $request->date
                ]);
                return response()->json(['message' => 'Data Berhasil diubah']);
            }else {
                Lowongan::where('id', $id)->update([
                    "name" => $request->name,
                    "description" => $request->description,
                    "jobdesc" => $request->jobdesc,
                    "kualification" => $request->kualification,
                    "date" => $request->date
                ]);
                return response()->json(['message' => 'Data Berhasil diubah']);
            }
        }else{
            return response()->json(['message' => 'Hanya Admin yg bisa mengubah']);
        }
    }
    public function show(Request $request, $id)
    {
        if(Auth::user()->role=='admin'){
            $lowongan = Lowongan::where('id', $id)->first();
            $peserta = Peserta::where('lowongan_id', $lowongan->id)->get();
            return response()->json(['message' => 'Data Peserta', 'data' => $peserta]);
        }

    }

}
