<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    public function lowongan()
    {
        $lowongan = Lowongan::all();
        return response()->json(['message' => 'Semua Data Lowongan', 'data' => $lowongan]);
    }
    public function show($id)
    {
        $lowongan = Lowongan::where('id', $id)->first();
        return response()->json(['message' => 'Masuk Detail Lowongan', 'data' => $lowongan]);
    }
    public function daftar(Request $request, $id)
    {
        $lowongan = Lowongan::where('id', $id)->first();
        $validate = Validator::make($request->all(), [
            'name'          => 'required|string',
            'gender'        => 'required',
            'place_birth'   => 'required',
            'date_birth'    => 'required|date',
            'email'         => 'required|email|string',
            'age'           => 'required',
            'address'       => 'required',
            'city'          => 'required',
            'education'     => 'required',
            'major'         => 'required',
            'univercity'    => 'required',
            // 'media_social'  => 'required',
            // 'information'   => 'required',
            'cv'            => 'required',
            'portofolio'    => 'required',
            'foto'          => 'required',
        ]);
        if($validate->fails())
            {
                $response['status'] = false;
                $response['message'] = 'Lowongan Gagal Dilamar';
                $response['error'] = $validate->errors();
                return response()->json('response', 401);
            }
        $lamar = Peserta::where('lowongan_id', $lowongan->id)->first();

        $file_foto  = $request->foto;
        $nama_foto   = $file_foto->getClientOriginalName();
        $file_foto->move(public_path('profile', $nama_foto));

        $file_cv    = $request->cv;
        $nama_cv   = $file_cv->getClientOriginalName();
        $file_cv->move(public_path('berkas', $nama_cv));

        $file_portofolio       = $request->portofolio;
        $nama_portofilo        = $file_portofolio->getClientOriginalName();
        $file_portofolio->move(public_path('berkas', $nama_portofilo));

        $peserta_lamar                  = new Peserta();
        $peserta_lamar->lowongan_id     = $lowongan->id;
        $peserta_lamar->name            = $request->name;
        $peserta_lamar->gender          = $request->gender;
        $peserta_lamar->place_birth     = $request->place_birth;
        // $peserta_lamar->date_birth      = date('Y-m-d', ($request->date_birth));
        $peserta_lamar->date_birth      = $request->date_birth;
        $peserta_lamar->email           = $request->email;
        $peserta_lamar->age             = $request->age;
        $peserta_lamar->address         = $request->address;
        $peserta_lamar->city            = $request->city;
        $peserta_lamar->education       = $request->education;
        $peserta_lamar->major           = $request->major;
        $peserta_lamar->univercity      = $request->univercity;
        $peserta_lamar->media_social    = $request->media_social;
        $peserta_lamar->information     = $request->information;
        $peserta_lamar->cv              = $nama_cv;
        $peserta_lamar->portofolio      = $nama_portofilo;
        $peserta_lamar->foto            = $nama_foto;
        $peserta_lamar->save();

        return response()->json(['message' => 'Berkas Berhasil Ditambahkan']);
    }
}
