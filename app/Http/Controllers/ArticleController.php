<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Description;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function article_description(Request $request)
    {
        $desc = Description::where('target', 'article')->first();

        if (!$desc) {
            Description::create([
                'target' => 'article',
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
            'message' => 'Article description has been updated'
        ]);
    }

    public function article_description_display(Request $request)
    {
        $desc = Description::where('target', 'article')->first();

        if ($desc) {
            $desc->update([
                'displayed' => $request->displayed
            ]);
        }

        return response()->json();
    }

    public function article_get()
    {
        $data = Article::orderBy('created_at', 'DESC')->get();

        $desc = Description::where('target', 'article')->first();
        $desc['displayed'] = $desc['displayed'] ? true : false;

        $response = [
            "response" => "success",
            "data" => $data,
            "description" => $desc
        ];

        return response()->json($response);
    }

    public function article_add(Request $request)
    {
        $image = $this->upload_image($request->image, '/assets/images/', 'article');
        Article::create([
            "image" => $image,
            "description" => $request->description,
            "source" => $request->source
        ]);

        $response = [
            "response" => "success",
            "message" => "New article has been created"
        ];

        return response()->json($response);
    }

    public function article_edit(Request $request)
    {
        $article = Article::find($request->id);
        $article->update([
            "description" => $request->description,
            "source" => $request->source
        ]);

        if ($request->image != "") {
            $this->delete_file($article->image, '/assets/images/');
            $newImage = $this->upload_image($request->image, '/assets/images/', 'article');
            $article->update([
                "image" => $newImage
            ]);
        }

        $response = [
            "response" => "success",
            "message" => "Article has been updated"
        ];

        return response()->json($response);
    }

    public function article_delete(Request $request)
    {
        $article = Article::find($request->id);
        $this->delete_file($article->image, '/assets/images/');
        $article->delete();

        $response = [
            "response" => "success",
            "message" => "Article has been deleted"
        ];

        return response()->json($response);
    }
}
