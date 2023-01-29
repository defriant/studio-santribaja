<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Description;
use App\Models\Information;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function update_category_desc(Request $request)
    {
        $desc = Description::where('target', 'category')->first();

        if (!$desc) {
            Description::create([
                'target' => 'category',
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
            'message' => 'Category description has been updated'
        ]);
    }

    public function update_category_display(Request $request)
    {
        $desc = Description::where('target', 'category')->first();

        if ($desc) {
            $desc->update([
                'displayed' => $request->displayed
            ]);
        }

        return response()->json();
    }

    public function kategori_get()
    {
        $data = Category::orderBy('created_at')->get();
        $desc = Description::where('target', 'category')->first();

        $response = [
            "response" => "success",
            "description" => $desc,
            "data" => $data
        ];

        return response()->json($response);
    }

    public function independent_product_get()
    {
        $data = Product::where('category_id', null)->get();

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function kategori_add(Request $request)
    {
        $cek = Category::where('name', $request->name)->first();
        if ($cek) {
            $response = [
                "response" => "success",
                "status" => "failed",
                "message" => "Category $request->name already exist"
            ];
        } else {
            $id = $this->random('mix', 5);
            while (true) {
                $cek = Category::where('id', $id)->first();
                if ($cek) {
                    $id = $this->random('mix', 5);
                } else {
                    break;
                }
            }

            $newCategory = Category::create([
                "id" => $id,
                "name" => $request->name,
                "image" => $this->upload_image($request->image, '/assets/images/', 'category'),
            ]);

            if (count($request->products) > 0) {
                foreach ($request->products as $p) {
                    Product::find($p)->update([
                        "category_id" => $newCategory->id
                    ]);
                }
            }

            $response = [
                "response" => "success",
                "status" => "success",
                "message" => "New category has been created"
            ];
        }

        return response()->json($response);
    }

    public function kategori_update(Request $request)
    {
        $category = Category::find($request->id);

        if ($request->image) {
            $this->delete_file($category->image, '/assets/images/');
            $category->update([
                "name" => $request->name,
                "image" => $this->upload_image($request->image, '/assets/images/', 'category'),
            ]);

            return response()->json([
                "response" => "success",
                "message" => "Category has been updated"
            ]);
        }

        $category->update([
            "name" => $request->name
        ]);

        return response()->json([
            "response" => "success",
            "message" => "Category has been updated"
        ]);
    }

    public function kategori_delete(Request $request)
    {
        $category = Category::find($request->id);
        $this->delete_file($category->image, '/assets/images/');
        $category->delete();

        $products = Product::where('category_id', $request->id)->get();
        foreach ($products as $p) {
            Product::find($p->id)->update([
                "category_id" => null
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Category $request->name has been deleted"
        ];

        return response()->json($response);
    }

    public function product_get()
    {
        $product = Product::orderBy('product_order', 'ASC')->get();
        $data = [];

        foreach ($product as $p) {
            if ($p->category_id != null) {
                $category = [
                    "id" => $p->category_id,
                    "name" => $p->category->name
                ];
            } else {
                $category = null;
            }

            $data[] = [
                "id" => $p->id,
                "product_order" => $p->product_order,
                "category" => $category,
                "name" => $p->name,
                "description" => $p->description,
                "image" => $p->image,
                "specification" => $p->specification
            ];
        }

        $response = [
            "response" => "success",
            "data" => $data
        ];

        return response()->json($response);
    }

    public function product_add(Request $request)
    {
        $id = $this->random('mix', 5);
        while (true) {
            $cek = Product::where('id', $id)->first();
            if ($cek) {
                $id = $this->random('mix', 5);
            } else {
                break;
            }
        }

        Product::create([
            "id" => $id,
            "product_order" => Product::max('product_order') + 1,
            "category_id" => ($request->category != '') ? $request->category : null,
            "name" => $request->name,
            "description" => $request->description,
            "specification" => $request->specification ?
                $this->upload_file($request->specification['content'], '/assets/files/', $request->specification['filename'])
                :
                null
        ]);

        $image = [
            $this->upload_image($request->image_1, '/assets/images/', 'product'),
            // $this->upload_image($request->image_2, '/assets/images/', 'product'),
            // $this->upload_image($request->image_3, '/assets/images/', 'product')
        ];

        for ($i = 0; $i < count($image); $i++) {
            ProductImage::create([
                "product_id" => $id,
                "image_order" => $i,
                "filename" => $image[$i]
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Product has been added"
        ];

        return response()->json($response);
    }

    public function product_update(Request $request)
    {
        $product = Product::find($request->id);

        $product->update([
            "category_id" => ($request->category != '') ? $request->category : null,
            "name" => $request->name,
            "description" => $request->description,
        ]);

        if ($request->specification) {
            if ($product->specification) $this->delete_file($product->specification, '/assets/files/');

            $product->update([
                "specification" => $this->upload_file($request->specification['content'], '/assets/files/', $request->specification['filename'])
            ]);
        }

        if ($request->image_1 != "") {
            $fileDelete = ProductImage::where('product_id', $request->id)->where('image_order', 0)->first()->filename;
            $this->delete_file($fileDelete, '/assets/images/');

            $fileAdd = $this->upload_image($request->image_1, '/assets/images/', 'product');
            ProductImage::where('product_id', $request->id)->where('image_order', 0)->update([
                "filename" => $fileAdd
            ]);
        }

        if ($request->image_2 != "") {
            $fileDelete = ProductImage::where('product_id', $request->id)->where('image_order', 1)->first()->filename;
            $this->delete_file($fileDelete, '/assets/images/');

            $fileAdd = $this->upload_image($request->image_2, '/assets/images/', 'product');
            ProductImage::where('product_id', $request->id)->where('image_order', 1)->update([
                "filename" => $fileAdd
            ]);
        }

        if ($request->image_3 != "") {
            $fileDelete = ProductImage::where('product_id', $request->id)->where('image_order', 2)->first()->filename;
            $this->delete_file($fileDelete, '/assets/images/');

            $fileAdd = $this->upload_image($request->image_3, '/assets/images/', 'product');
            ProductImage::where('product_id', $request->id)->where('image_order', 2)->update([
                "filename" => $fileAdd
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Product $request->name has been updated"
        ];

        return response()->json($response);
    }

    public function product_delete(Request $request)
    {
        $product = Product::find($request->id);
        $productOrderMax = Product::max('product_order');

        if ($product->product_order < $productOrderMax) {
            for ($i = $product->product_order; $i < $productOrderMax; $i++) {
                Product::where('product_order', $i + 1)->first()->update([
                    "product_order" => $i
                ]);
            }
        }

        Product::where('id', $request->id)->delete();

        $image = ProductImage::where('product_id', $request->id)->get();
        foreach ($image as $img) {
            $this->delete_file($img->filename, '/assets/images/');
        }

        if ($product->specification) $this->delete_file($product->specification, '/assets/files/');

        ProductImage::where('product_id', $request->id)->delete();

        $response = [
            "response" => "success",
            "message" => "Product $request->name has been deleted",
            "data" => $product
        ];

        return response()->json($response);
    }

    public function switch_order(Request $request)
    {
        $productTo = Product::where('product_order', $request->product_order)->first();

        $productFrom = Product::find($request->id);
        $productFrom = $productFrom->product_order;

        Product::find($request->id)->update([
            "product_order" => $request->product_order
        ]);

        $productTo->update([
            "product_order" => $productFrom
        ]);

        $response = [
            "response" => "success"
        ];

        return response()->json($response);
    }
}
