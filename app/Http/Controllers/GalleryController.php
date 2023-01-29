<?php

namespace App\Http\Controllers;

use App\Models\Description;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function gallery_description(Request $request)
    {
        $desc = Description::where('target', 'gallery')->first();

        if (!$desc) {
            Description::create([
                'target' => 'gallery',
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
            'message' => 'Gallery description has been updated'
        ]);
    }

    public function gallery_description_display(Request $request)
    {
        $desc = Description::where('target', 'gallery')->first();

        if ($desc) {
            $desc->update([
                'displayed' => $request->displayed
            ]);
        }

        return response()->json();
    }

    public function gallery_get()
    {
        $gallery = Gallery::orderBy('created_at', 'DESC')->get();

        $response = [
            "response" => "success",
            "data" => $gallery,
            "description" => Description::where('target', 'gallery')->first()
        ];

        return response()->json($response);
    }

    public function gallery_add(Request $request)
    {
        $thumbnail = $this->upload_image($request->thumbnail, '/assets/images/', 'gallery');
        Gallery::create([
            "thumbnail" => $thumbnail,
            "link_youtube" => $request->link_youtube
        ]);

        $response = [
            "response" => "success",
            "message" => "New gallery has been created"
        ];

        return response()->json($response);
    }

    public function gallery_edit(Request $request)
    {
        $gallery = Gallery::find($request->id);
        $gallery->update([
            "link_youtube" => $request->link_youtube
        ]);

        if ($request->thumbnail != "") {
            $this->delete_file($gallery->thumbnail, '/assets/images/');
            $newThumbnail = $this->upload_image($request->thumbnail, '/assets/images/', 'gallery');
            $gallery->update([
                "thumbnail" => $newThumbnail
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Gallery updated"
        ];

        return response()->json($response);
    }

    public function gallery_delete(Request $request)
    {
        $gallery = Gallery::find($request->id);
        $this->delete_file($gallery->thumbnail, '/assets/images/');
        $gallery->delete();

        $response = [
            "response" => "success",
            "message" => "Gallery has been deleted"
        ];

        return response()->json($response);
    }
}
