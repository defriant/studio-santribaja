<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function main_banner_get()
    {
        $data = Banner::where('type', 'main_banner')->first();
        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function main_banner_update(Request $request)
    {
        $data = Banner::where('type', 'main_banner')->first();

        if ($request->main_banner) {
            $this->delete_file($data->filename, '/assets/images/');
            $filename = $this->upload_image($request->main_banner, '/assets/images/', 'mainbanner');

            $data->update([
                "title" => $request->title,
                "description" => $request->description,
                "filename" => $filename
            ]);

            return response()->json([
                "response" => "success",
                "message" => "Main banner updated"
            ]);
        }

        $data->update([
            "title" => $request->title,
            "description" => $request->description
        ]);

        return response()->json([
            "response" => "success",
            "message" => "Main banner updated"
        ]);
    }

    public function main_banner_delete(Request $request)
    {
        $data = Banner::find($request->id);
        $this->delete_file($data->filename, '/assets/images/');

        $data->delete();

        $response = [
            "response" => "success",
            "message" => "Banner successfully deleted"
        ];
        return response()->json($response);
    }

    public function other_banner_get()
    {
        $banner_grid_3 = Banner::where('type', 'banner_grid_3')->orderBy('banner_order')->get();
        $banner_grid_2 = Banner::where('type', 'banner_grid_2')->orderBy('banner_order')->get();

        $response = [
            "response" => "success",
            "banner_grid_3" => $banner_grid_3,
            "banner_grid_2" => $banner_grid_2
        ];

        return response()->json($response);
    }

    public function other_banner_update(Request $request)
    {
        $banner = Banner::where('type', $request->type)->where('banner_order', $request->banner_order)->first();
        if ($banner->filename != "grey.jpg") {
            $this->delete_file($banner->filename, '/assets/images/');
        }

        $newBanner = $this->upload_image($request->banner, '/assets/images/', $request->type);
        $banner->update([
            "filename" => $newBanner
        ]);

        $response = [
            "response" => "success",
            "message" => "Banner has been updated"
        ];
        return response()->json($response);
    }
}
