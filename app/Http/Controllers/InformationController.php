<?php

namespace App\Http\Controllers;

use App\Models\AboutImage;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function information_get()
    {
        $data = Information::with('about_images')->find('santribajaindonesia');

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function update_general(Request $request)
    {
        if ($request->logo != '') {
            $this->delete_file('logo.png', '/assets/images/');
            $this->upload_logo($request->logo, '/assets/images/', 'logo');
        }

        Information::where('id', 'santribajaindonesia')->update([
            "email" => $request->email,
            "telepon" => $request->telepon,
            "facebook"  => $request->facebook,
            "instagram"  => $request->instagram,
            "youtube"  => $request->youtube,
            "whatsapp"  => $request->whatsapp
        ]);

        $response = [
            "response" => "success",
            "message" => "General information has been updated"
        ];

        return response()->json($response);
    }

    public function update_about(Request $request)
    {
        Information::find('santribajaindonesia')->update([
            "about" => $request->about
        ]);

        $response = [
            "response" => "success",
            "message" => "About us updated"
        ];

        return response()->json($response);
    }

    public function about_image_add(Request $request)
    {
        AboutImage::create([
            'information_id' => 'santribajaindonesia',
            'filename' => $this->upload_image($request->image, '/assets/images/', 'about')
        ]);

        return response()->json([
            'response' => 'success',
            'message' => 'About us image has been added'
        ]);
    }

    public function about_image_update(Request $request, $id)
    {
        $about_image = AboutImage::find($id);
        $this->delete_file($about_image->filename, '/assets/images/');
        $about_image->update([
            'filename' => $this->upload_image($request->image, '/assets/images/', 'about')
        ]);

        return response()->json([
            'response' => 'success',
            'message' => 'Image has been updated'
        ]);
    }

    public function about_image_delete($id)
    {
        $about_image = AboutImage::find($id);
        $this->delete_file($about_image->filename, '/assets/images/');
        $about_image->delete();

        return response()->json([
            'response' => 'success',
            'message' => 'Image has been deleted'
        ]);
    }
}
