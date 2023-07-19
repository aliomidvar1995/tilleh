<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\News;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(News $news)
    {
        return $news->comments()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::query()->create([
            'content' => $request->content,
            'news_id' => $request->news_id
        ]);

        return response(['comment' => $comment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        if($request->likes) {
            $comment->update([
                'likes' => $comment->likes += 1
            ]);
            return response()->noContent();
        }
        if($request->dislikes) {
            $comment->update([
                'dislikes' => $comment->dislikes += 1
            ]);
            return response()->noContent();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
