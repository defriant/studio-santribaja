<?php

namespace App\Http\Controllers;

use App\Models\Feeds;
use App\Models\Banner;
use App\Models\Article;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Distributor;
use App\Models\Information;
use App\Models\Mailbox;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;

class APIControllerOld extends Controller
{
    public function get_informations(Request $request)
    {
        $data = Information::find('syifaaviglowing');

        $visitorInfo = geoip($request->ip());

        if ($request->header('vstr') != null || $request->header('vtmp') != null) {
            Visitor::create([
                "ip_address" => $visitorInfo->ip,
                "iso_code" => $visitorInfo->iso_code,
                "country" => $visitorInfo->country,
                "state" => $visitorInfo->state_name,
                "city" => $visitorInfo->city,
                "postal_code" => $visitorInfo->postal_code
            ]);
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_main_banner()
    {
        $data = Banner::where('type', 'main_banner')->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_category()
    {
        $data = Category::all();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_section_category()
    {
        $data = Category::all();

        return $data;
    }

    public function get_popular_products()
    {
        $product = Product::where('popular', true)->orderBy('product_order', 'ASC')->get();
        $product_price = Information::find('syifaaviglowing')->product_price;
        $data = [];

        foreach ($product as $p) {
            $data[] = [
                "id" => $p->id,
                "category" => ($p->category_id != null) ? $p->category->name : "",
                "name" => $p->name,
                "price" => ($product_price == "show") ? $p->price : "",
                "description" => $p->description,
                "how_to_use" => $p->how_to_use,
                "product_contains" => $p->product_contains,
                "popular" => ($p->popular == true) ? true : false,
                "image" => $p->image[0]->filename
            ];
        }

        return $data;
    }

    public function get_all_products()
    {
        $product = Product::orderBy('product_order', 'ASC')->get();
        $product_price = Information::find('syifaaviglowing')->product_price;
        $data = [];

        foreach ($product as $p) {
            if ($p->category_id != null) {
                $category = [
                    "id" => $p->category_id,
                    "name" => $p->category->name
                ];
            } else {
                $category = "";
            }

            $data[] = [
                "id" => $p->id,
                "category" => $category,
                "name" => $p->name,
                "price" => ($product_price == "show") ? $p->price : "",
                "description" => $p->description,
                "how_to_use" => $p->how_to_use,
                "product_contains" => $p->product_contains,
                "popular" => ($p->popular == true) ? true : false,
                "image" => $p->image[0]->filename
            ];
        }

        return $data;
    }

    public function get_banner_grid_3()
    {
        $data = Banner::where('type', 'banner_grid_3')->get();

        return $data;
    }

    public function get_banner_grid_2()
    {
        $data = Banner::where('type', 'banner_grid_2')->get();

        return $data;
    }

    public function get_testimonial()
    {
        $data = Testimonial::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function get_feeds()
    {
        $feeds = Feeds::orderBy('created_at', 'DESC')->get();
        $data = [];

        foreach ($feeds as $f) {
            $today = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime("-1 days"));
            $feedDate = date('Y-m-d', strtotime($f->created_at));

            if ($today == $feedDate) {
                $posted_at = "Today";
            } else if ($yesterday == $feedDate) {
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

        return $data;
    }

    public function get_article()
    {
        $data = Article::orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function get_sections()
    {
        $sections = Section::orderBy('section_order')->get();
        $data = [];

        foreach ($sections as $i => $s) {
            switch ($s->type) {
                case 'category':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_section_category()
                        ];
                    }
                    break;

                case 'popular_product':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_popular_products()
                        ];
                    }
                    break;

                case 'all_product':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_all_products()
                        ];
                    }
                    break;

                case 'banner_grid_3':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_banner_grid_3()
                        ];
                    }
                    break;

                case 'banner_grid_2':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_banner_grid_2()
                        ];
                    }
                    break;

                case 'testimonial':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_testimonial()
                        ];
                    }
                    break;

                case 'feed':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_feeds()
                        ];
                    }
                    break;

                case 'article':
                    if ($s->status == "active") {
                        $data[] = [
                            "order" => $i,
                            "type" => $s->type,
                            "data" => $this->get_article()
                        ];
                    }
                    break;
            }
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_category_by_id($id)
    {
        $data = Category::find($id);

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_product_by_id($id)
    {
        $p = Product::find($id);
        $product_price = Information::find('syifaaviglowing')->product_price;
        if ($p) {
            if ($p->category_id != null) {
                $category = [
                    "id" => $p->category_id,
                    "name" => $p->category->name
                ];
            } else {
                $category = "";
            }

            $data = [
                "id" => $p->id,
                "category" => $category,
                "name" => $p->name,
                "price" => ($product_price == "show") ? $p->price : "",
                "description" => $p->description,
                "how_to_use" => $p->how_to_use,
                "product_contains" => $p->product_contains,
                "popular" => ($p->popular == true) ? true : false,
                "image" => $p->image[0]->filename
            ];
        } else {
            $data = [];
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function get_product_by_category($id)
    {
        $product = Product::where('category_id', $id)->get();
        $product_price = Information::find('syifaaviglowing')->product_price;
        $data = [];

        foreach ($product as $p) {
            $data[] = [
                "id" => $p->id,
                "category" => [
                    "id" => $p->category_id,
                    "name" => $p->category->name
                ],
                "name" => $p->name,
                "price" => ($product_price == "show") ? $p->price : "",
                "description" => $p->description,
                "how_to_use" => $p->how_to_use,
                "product_contains" => $p->product_contains,
                "popular" => ($p->popular == true) ? true : false,
                "image" => $p->image[0]->filename
            ];
        }

        $category = Category::find($id);

        $response = [
            "response" => "success",
            "data" => $data,
            "category" => [
                "id" => $category->id,
                "name" => $category->name
            ]
        ];

        return response()->json($response);
    }

    public function get_distributor()
    {
        $data = Distributor::orderBy('created_at', 'DESC')->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function search_distributor(Request $request)
    {
        $data = Distributor::where('wilayah', 'like', '%' . $request->search . '%')->orWhere('alamat', 'like', '%' . $request->search . '%')->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function add_mailbox(Request $request)
    {
        Mailbox::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "email" => $request->email,
            "message" => $request->message,
            "is_read" => 0
        ]);

        $response = [
            "response" => "success",
            "message" => "Pesan anda berhasil dikirim !"
        ];

        return response()->json($response);
    }

    public function generate_user_account(Request $request)
    {
        if ($request->header('token') === "QI46iT9Rq6EptVQYH8NFt13ibgzyu5Gg6P0810IMd445cS35Au") {
            $data = [
                "name" => $request->name,
                "username" => $request->username,
                "password" => bcrypt($request->password)
            ];

            User::create($data);

            $response = [
                "response" => "success",
                "message" => "User account successfully created !"
            ];
        } else {
            $response = [
                "response" => "failed",
                "message" => "Token missmatch"
            ];
        }

        return response()->json($response);
    }
}
