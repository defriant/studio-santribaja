<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function get_section()
    {
        $data = Section::orderBy('section_order')->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function switch_order(Request $request)
    {
        $sectionTo = Section::where('section_order', $request->section_order)->first();

        $sectionFrom = Section::find($request->id);
        $sectionFrom = $sectionFrom->section_order;

        Section::find($request->id)->update([
            "section_order" => $request->section_order
        ]);

        $sectionTo->update([
            "section_order" => $sectionFrom
        ]);

        $response = [
            "response" => "success"
        ];

        return response()->json($response);
    }

    public function status(Request $request)
    {
        Section::find($request->id)->update([
            "status" => $request->status
        ]);

        $response = [
            "response" => "success"
        ];

        return response()->json($response);
    }
}
