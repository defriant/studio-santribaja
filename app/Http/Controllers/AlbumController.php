<?php

namespace App\Http\Controllers;

use App\Models\Description;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function album_description(Request $request)
    {
        $desc = Description::where('target', 'album')->first();

        if (!$desc) {
            Description::create([
                'target' => 'album',
                'description' => $request->description,
                'displayed' => $request->displayed
            ]);
        } else {
            $desc->update([
                'description' => $request->description,
                'displayed' => $request->displayed
            ]);
        }

        return response()->json([
            'response' => 'success',
            'message' => 'Album description has been updated'
        ]);
    }

    public function album_description_display(Request $request)
    {
        $desc = Description::where('target', 'album')->first();

        if ($desc) {
            $desc->update([
                'displayed' => $request->displayed
            ]);
        }

        return response()->json();
    }

    public function album_get()
    {
        $album = Album::orderBy('created_at', 'DESC')->get();
        $data = [];

        foreach ($album as $f) {
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $albumDate = date('Y-m-d', strtotime($f->created_at));

            if ($today == $albumDate) {
                $posted_at = "Today";
            } else if ($yesterday == $albumDate) {
                $posted_at = "Yesterday";
            } else {
                $posted_at = date('d F Y', strtotime($f->created_at));
            }

            $data[] = [
                "id" => $f->id,
                "image" => $f->image,
                "caption" => $f->caption,
                "posted_at" => $posted_at
            ];
        }

        $desc = Description::where('target', 'album')->first();
        $desc['displayed'] = $desc['displayed'] ? true : false;

        $response = [
            "response" => "success",
            "description" => $desc,
            "data" => $data
        ];

        return response()->json($response);
    }

    public function album_add(Request $request)
    {
        $image = $this->upload_image($request->image, '/assets/images/', 'album');
        Album::create([
            "image" => $image,
            "caption" => $request->caption
        ]);

        $response = [
            "response" => "success",
            "message" => "Album has been added"
        ];

        return response()->json($response);
    }

    public function album_edit(Request $request)
    {
        $album = Album::find($request->id);
        $album->update([
            "caption" => $request->caption
        ]);

        if ($request->image != "") {
            $this->delete_file($album->image, '/assets/images/');
            $newImage = $this->upload_image($request->image, '/assets/images/', 'album');
            $album->update([
                "image" => $newImage
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Album updated"
        ];

        return response()->json($response);
    }

    public function album_delete(Request $request)
    {
        $album = Album::find($request->id);
        $this->delete_file($album->image, '/assets/images/');
        $album->delete();

        $response = [
            "response" => "success",
            "message" => "Album deleted"
        ];

        return response()->json($response);
    }
}
