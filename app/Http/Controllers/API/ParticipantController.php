<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Recruitment;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Participant::with('recruitment')
        //     ->where('category_id', 2)
        //     ->orderBy('id', 'DESC')
        //     ->get();
        $data = Recruitment::with('participant')
                ->where('category_id', 2)
                ->orderBy('id', 'DESC')
                ->get();

        return response()->json(['data' => $data]);
    }

    public function recruitment()
    {
        // $data = Participant::with('recruitment')
        //         ->where('category_id', 1)
        //         ->orderBy('id', 'DESC')
        //         ->get();
        $data = Recruitment::with('participant')
                ->where('category_id', 1)
                ->orderBy('id', 'DESC')
                ->get();

        return response()->json(['data' => $data]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peserta = Participant::where('id', $id)->first();
        $file = File::where('participant_id', $peserta->id)->get();

        return response()->json(['message' => 'Menampilkan File Participant', 'data' => $file]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
