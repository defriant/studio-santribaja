<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function distributor_get()
    {
        $data = Distributor::orderBy('created_at', 'DESC')->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function distributor_add(Request $request)
    {
        Distributor::create([
            "nama" => $request->nama,
            "wilayah" => $request->wilayah,
            "instagram" => $request->instagram,
            "whatsapp" => $request->whatsapp,
            "alamat" => $request->alamat
        ]);

        $response = [
            "response" => "success",
            "message" => "Distributor has been added"
        ];

        return response()->json($response);
    }

    public function distributor_edit(Request $request)
    {
        Distributor::find($request->id)->update([
            "nama" => $request->nama,
            "wilayah" => $request->wilayah,
            "instagram" => $request->instagram,
            "whatsapp" => $request->whatsapp,
            "alamat" => $request->alamat
        ]);

        $response = [
            "response" => "success",
            "message" => "Distributor $request->nama has been updated"
        ];

        return response()->json($response);
    }

    public function distributor_delete(Request $request)
    {
        Distributor::find($request->id)->delete();

        $response = [
            "response" => "success",
            "message" => "Distributor $request->nama has been deleted"
        ];

        return response()->json($response);
    }
}
