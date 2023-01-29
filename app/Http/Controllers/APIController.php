<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Feeds;
use App\Models\Banner;
use App\Models\Article;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Description;
use App\Models\Distributor;
use App\Models\Gallery;
use App\Models\Information;
use App\Models\Mailbox;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function company(Request $request)
    {
        $visitor = geoip($request->ip());

        Visitor::create([
            "ip_address" => $visitor->ip,
            "iso_code" => $visitor->iso_code,
            "country" => $visitor->country,
            "state" => $visitor->state_name,
            "city" => $visitor->city,
            "postal_code" => $visitor->postal_code
        ]);

        $data = Information::with('about_images')->find('santribajaindonesia');

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function get_home_section($section)
    {
        if ($section['status'] !== 'active') return false;

        switch ($section['type']) {
            case 'category':
                return [
                    'type' => 'category',
                    'description' => Description::where('target', 'category')->first()->description,
                    'data' => Category::orderBy('created_at')->get()
                ];
                break;

            case 'banner_grid_2':
                return [
                    'type' => 'banner_grid_2',
                    'data' => array_map(function ($v) {
                        return $v['filename'];
                    }, Banner::where('type', 'banner_grid_2')->orderBy('banner_order')->get()->toArray())
                ];
                break;

            case 'gallery':
                return [
                    'type' => 'gallery',
                    'description' => Description::where('target', 'gallery')->first()->description,
                    'data' => Gallery::orderBy('created_at', 'DESC')->take(4)->get()
                ];
                break;

            case 'banner_grid_3':
                return [
                    'type' => 'banner_grid_3',
                    'data' => array_map(function ($v) {
                        return $v['filename'];
                    }, Banner::where('type', 'banner_grid_3')->orderBy('banner_order')->get()->toArray())
                ];
                break;

            case 'album':
                return [
                    'type' => 'album',
                    'description' => Description::where('target', 'album')->first()->description,
                    'data' => Album::orderBy('created_at', 'DESC')->take(4)->get()
                ];
                break;

            case 'article':
                return [
                    'type' => 'article',
                    'description' => Description::where('target', 'article')->first()->description,
                    'data' => Article::orderBy('created_at', 'DESC')->take(4)->get()
                ];
                break;
        }
    }

    public function home()
    {
        $main_banner = Banner::where('type', 'main_banner')->first();
        $rawSections = Section::orderBy('section_order')->get()->toArray();

        $sections = array_map(fn ($v) => $this->get_home_section($v), $rawSections);
        $sections = array_values(array_filter($sections, fn ($v) => $v));

        return response()->json([
            'error' => false,
            'data' => [
                'main_banner' => $main_banner,
                'sections' => $sections
            ]
        ]);
    }
}
