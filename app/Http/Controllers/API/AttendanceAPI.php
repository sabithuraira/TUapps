<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Attendance::withcount('user')->get();
        if ($data->isNotEmpty()) {
            $res = [
                'message' => 'success',
                'data' => $data
            ];
            return response($res);
        } else {
            $res = [
                'message' => 'data kosong',
            ];
            return response($res);
        }
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
        $data =
            Attendance::create(
                [
                    'nama' => $request->name,
                    'open' => $request->open,
                    'close' => $request->close
                ]
            );

        if ($data) {
            $res = [
                'message' => 'success',
            ];
            return response($res);
        } else {
            $res = [
                'message' => 'Failed',
            ];
            return response($res);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $attendance = Attendance::find($id);
        if ($attendance) {
            // dd($request->all());
            $attendance->nama = $request->name;
            $attendance->open = $request->open;
            $attendance->close = $request->close;
            $attendance->save();
            $res = [
                'message' => 'successful',
            ];
            return response($res);
        } else {
            $res = [
                'message' => 'Failed',
            ];
            return response($res);
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
        $attendance = Attendance::find($id);
        if ($attendance) {
            $attendance->delete();
            $res = [
                'message' => 'success',
            ];
            return response($res);
        } else {
            $res = [
                'message' => 'Failed',
            ];
            return response($res);
        }
    }
}
