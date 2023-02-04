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
use App\Models\ProductImage;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function company(Request $request)
    {
        $visitor = geoip($request->ip());

        $isExist = Visitor::where('ip_address', $visitor->ip)->orderBy('created_at', 'DESC')->first();

        if ($isExist) {
            $shouldAddAfter = strtotime('+5 minutes', strtotime($isExist->created_at));
            if ($shouldAddAfter <= time()) Visitor::create([
                'ip_address' => $visitor->ip,
                'iso_code' => $visitor->iso_code,
                'country' => $visitor->country,
                'state' => $visitor->state_name,
                'city' => $visitor->city,
                'postal_code' => $visitor->postal_code
            ]);
        } else {
            Visitor::create([
                'ip_address' => $visitor->ip,
                'iso_code' => $visitor->iso_code,
                'country' => $visitor->country,
                'state' => $visitor->state_name,
                'city' => $visitor->city,
                'postal_code' => $visitor->postal_code
            ]);
        }


        $data = Information::with('about_images')->find('santribajaindonesia')->toArray();
        $data['about_images'] = array_map(fn ($v) => asset('assets/images/' . $v['filename']), $data['about_images']);

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
                $desc = Description::where('target', 'category')->first();
                $data = Category::orderBy('created_at')->get()->toArray();
                $data = array_map(function ($v) {
                    $v['image'] = asset('assets/images/' . $v['image']);
                    return $v;
                }, $data);

                return [
                    'type' => 'category',
                    'description' => $desc->displayed ? $desc->description : '',
                    'data' => $data
                ];
                break;

            case 'banner_grid_2':
                return [
                    'type' => 'banner_grid_2',
                    'data' => array_map(function ($v) {
                        return asset('assets/images/' . $v['filename']);
                    }, Banner::where('type', 'banner_grid_2')->orderBy('banner_order')->get()->toArray())
                ];
                break;

            case 'gallery':
                $desc = Description::where('target', 'gallery')->first();
                $data = Gallery::orderBy('created_at', 'DESC')->take(4)->get()->toArray();
                $data = array_map(function ($v) {
                    $v['thumbnail'] = asset('assets/images/' . $v['thumbnail']);
                    return $v;
                }, $data);

                return [
                    'type' => 'gallery',
                    'description' => $desc->displayed ? $desc->description : '',
                    'data' => $data
                ];
                break;

            case 'banner_grid_3':
                return [
                    'type' => 'banner_grid_3',
                    'data' => array_map(function ($v) {
                        return asset('assets/images/' . $v['filename']);
                    }, Banner::where('type', 'banner_grid_3')->orderBy('banner_order')->get()->toArray())
                ];
                break;

            case 'album':
                $desc = Description::where('target', 'album')->first();
                $data = Album::orderBy('created_at', 'DESC')->take(4)->get()->toArray();
                $data = array_map(function ($v) {
                    $v['image'] = asset('assets/images/' . $v['image']);
                    return $v;
                }, $data);

                return [
                    'type' => 'album',
                    'description' => $desc->displayed ? $desc->description : '',
                    'data' => $data
                ];
                break;

            case 'article':
                $desc = Description::where('target', 'article')->first();
                $data = Article::orderBy('created_at', 'DESC')->take(4)->get()->toArray();
                $data = array_map(function ($v) {
                    $v['image'] = asset('assets/images/' . $v['image']);
                    return $v;
                }, $data);

                return [
                    'type' => 'article',
                    'description' => $desc->displayed ? $desc->description : '',
                    'data' => $data
                ];
                break;
        }
    }

    public function home()
    {
        $main_banner = Banner::where('type', 'main_banner')->first();
        $main_banner['filename'] = asset('assets/images/' . $main_banner['filename']);
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

    public function categories()
    {
        $data = Category::all()->toArray();

        $data = array_map(function ($v) {
            $v['image'] = asset('assets/images/' . $v['image']);
            return $v;
        }, $data);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function products(Request $request)
    {
        $data = [];

        if ($request->c_id) {
            $products = Product::where('category_id', $request->c_id)->with('image')->get()->toArray();
            $data = array_map(function ($v) {
                $v['image'] = asset('assets/images/' . $v['image'][0]['filename']);
                $v['specification'] = asset('assets/files/' . $v['specification']);
                return $v;
            }, $products);
        } else {
            $products = Product::with('image')->get()->toArray();
            $data = array_map(function ($v) {
                $v['image'] = asset('assets/images/' . $v['image'][0]['filename']);
                $v['specification'] = asset('assets/files/' . $v['specification']);
                return $v;
            }, $products);
        }

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function product_detail($id)
    {
        $data = Product::find($id);

        if (!$data) return response()->json([
            'error' => true,
            'message' => 'Product not found'
        ], 404);

        $data['specification'] = asset('assets/files/' . $data['specification']);
        $data['image'] = asset('assets/images/' . ProductImage::where('product_id', $id)->first()->filename);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function distributors()
    {
        $data = Distributor::all();

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function articles()
    {
        $data = Article::all()->toArray();

        $data = array_map(function ($v) {
            $v['image'] = asset('assets/images/' . $v['image']);
            return $v;
        }, $data);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function article_detail($id)
    {
        $data = Article::find($id);

        if (!$data) return response()->json([
            'error' => true,
            'message' => 'Article not found'
        ], 404);

        $data['image'] = asset('assets/images/' . $data['image']);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function galleries()
    {
        $data = Gallery::all()->toArray();

        $data = array_map(function ($v) {
            $v['thumbnail'] = asset('assets/images/' . $v['thumbnail']);
            return $v;
        }, $data);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function albums()
    {
        $data = Album::all()->toArray();

        $data = array_map(function ($v) {
            $v['image'] = asset('assets/images/' . $v['image']);
            return $v;
        }, $data);

        return response()->json([
            'error' => false,
            'data' => $data
        ]);
    }

    public function add_mailbox(Request $request)
    {
        $validator = $this->validateRequest($request->all(), [
            'name' => 'any',
            'phone' => 'any',
            'email' => 'any',
            'message' => 'any',
        ]);

        if ($validator['failed']) return response()->json($validator['response'], $validator['err_code']);

        Mailbox::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'is_read' => 0
        ]);

        $response = [
            'error' => false,
            'message' => 'Pesan anda berhasil dikirim !'
        ];

        return response()->json($response);
    }
}
