<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return News::query()->paginate(2);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $image = Storage::put('/public/images', $request->file('image'));
        $image = str_replace('public', 'storage', $image);
        $news = News::query()->create([
            'image' => url($image),
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response(['news' => $news]);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return $news;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        if($request->likes) {
            $news->update([
                'likes' => $news->likes += 1
            ]);
            return response()->noContent();
        }
        if($request->dislikes) {
            $news->update([
                'dislikes' => $news->dislikes += 1
            ]);
            return response(['likes' => $news->likes]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //
    }
}
