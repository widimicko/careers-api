<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Recruitment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Storage;
use DB;

class RecruitmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lowongan = Recruitment::all();
        return response()->json(['success' => true, 'message' => 'List Semua Data', 'data' => $lowongan], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'required',
            // 'description'   => 'required',
            'jobdesc'       => 'required',
            'qualification' => 'required',
            'image'         => 'image:jpeg,png,jpg|max:2048'
        ]);
        if($validate->fails())
        {
            $response['status'] = false;
            $response['message'] = 'Lowongan Gagal Ditambahkan';
            $response['error'] = $validate->errors();

            return response()->json('response', 401);
        }
        // $file = $request->image;
        // $filename = $file->getClientOriginalName();
        // $file->move(public_path('images', $filename));

        $file_image  = $request->image;
        $fileimage   = $file_image->getClientOriginalExtension();
        $nama_image = date('YmdHis').".$fileimage";
        $upload_path = 'images';
        $file_image->move($upload_path, $nama_image);

        // $extension = Input::file('photo')->getClientOriginalExtension();

        $lowongan = new Recruitment();
        // dd($lowongan);
        $lowongan->category_id      = $request->category_id;
        $lowongan->name             = $request->name;
        // $lowongan->description = $request->description;
        $lowongan->jobdesc          = $request->jobdesc;
        $lowongan->qualification    = $request->qualification;
        $lowongan->address          = $request->address;
        $lowongan->type             = $request->type;
        $lowongan->image            = $nama_image;
        $lowongan->date             = $request->date;
        $lowongan->save();

        // $lowongan['status'] = true;
        // $lowongan['message'] = 'Lowongan Berhasil Ditambahkan';
        return response()->json(['message' => 'Data Berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lowongan = Recruitment::where('id', $id)->first();
        $peserta = Participant::where('recruitment_id', $lowongan->id)->get();
        return response()->json(['message' => 'Data Peserta', 'data' => $peserta]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name'          => 'required',
            // 'description'   => 'required',
            'jobdesc'       => 'required',
            'qualification' => 'required',
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
            $file_image  = $request->image;
            $fileimage   = $file_image->getClientOriginalExtension();
            $nama_image = date('YmdHis').".$fileimage";
            $upload_path = 'images';
            $file_image->move($upload_path, $nama_image);

            Recruitment::where('id', $id)->update([
                "category_id"   => $request->category_id,
                "name"          => $request->name,
                // "description" => $request->description,
                "jobdesc"       => $request->jobdesc,
                "qualification" => $request->qualification,
                "address"       => $request->address,
                "type"          => $request->type,
                "image"         => $nama_image,
                "date"          => $request->date
            ]);
            return response()->json(['message' => 'Data Berhasil diubah']);
        }else {
            Recruitment::where('id', $id)->update([
                "category_id"   => $request->category_id,
                "name"          => $request->name,
                // "description" => $request->description,
                "jobdesc"       => $request->jobdesc,
                "qualification" => $request->qualification,
                "address"       => $request->address,
                "type"          => $request->type,
                "date"          => $request->date
            ]);
            return response()->json(['message' => 'Data Berhasil diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lowongan = Recruitment::find($id);
        $lowongan->delete();
        return response()->json(['message' => 'Lowongan berhasil dihapus']);
    }
}
