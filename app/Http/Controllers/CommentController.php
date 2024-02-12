<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * コメントの新規作成
     * 
     * 
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required | string | max:200',
            'review_id' => 'required | integer | exists:reviews,id',
        ]);

        $comment = Comment::create([
            'content' => $validatedData['content'],
            'review_id' => $validatedData['review_id'],
            'user_id' => Auth::id()
        ]);

        $comment->load('user');

        return response()->json($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
