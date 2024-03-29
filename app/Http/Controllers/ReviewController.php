<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * レビューを全件取得
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($media_type, $media_id): \Illuminate\Http\JsonResponse
    {
        $reviews = Review::with('user')
            ->where('media_type', $media_type)
            ->where('media_id', $media_id)
            ->get();
        return response()->json($reviews);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 新規レビューを登録
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'content' => 'required | string',
            'rating' => 'required | integer',
            'media_id' => 'required | integer',
            'media_type' => 'required | string',
        ]);

        $review = new Review();
        $review->content = $validatedData['content'];
        $review->rating = $validatedData['rating'];
        $review->media_id = $validatedData['media_id'];
        $review->media_type = $validatedData['media_type'];
        $review->user_id = Auth::id();
        $review->save();

        $review->load('user');
        return response()->json($review);
    }

    /**
     * 指定のレビューを取得
     * 
     * @param Review $review
     */
    public function show(Review $review)
    {
        $review->load('user', 'comments.user');

        return response()->json($review);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * 指定されたレビューを更新
     * 
     * @param Request $request
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Review $review): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'content' => 'required | string',
            'rating' => 'required | integer',
        ]);

        $review->content = $validatedData['content'];
        $review->rating = $validatedData['rating'];
        $review->save();

        return response()->json($review);
    }

    /**
     * 指定されたレビューを削除
     * 
     * @param Review $review
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json(['message' => '正常にレビューを削除しました。']);
    }
}
