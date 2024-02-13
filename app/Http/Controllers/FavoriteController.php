<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
  public function toggleFavorite(Request $request)
  {
    $validatedData = $request->validate([
      'media_id' => 'required | integer',
      'media_type' => 'required | string',
    ]);

    $existingFavorite = Favorite::where('user_id', Auth::id())
      ->where('media_type', $validatedData['media_type'])
      ->where('media_id', $validatedData['media_id'])
      ->first();

    // お気に入りが存在する場合
    if ($existingFavorite) {
      $existingFavorite->delete();
      return response()->json(['status' => 'removed']);
    } else {
      // お気に入りが存在しない場合
      $favorite = new Favorite();
      $favorite->media_id = $validatedData['media_id'];
      $favorite->media_type = $validatedData['media_type'];
      $favorite->user_id = Auth::id();
      $favorite->save();
      return response()->json(['status' => 'added']);
    }
  }

  public function checkFavoriteStatus(Request $request)
  {
    $validatedData = $request->validate([
      'media_id' => 'required | integer',
      'media_type' => 'required | string',
    ]);

    $isFavorite = Favorite::where('user_id', Auth::id())
      ->where('media_type', $validatedData['media_type'])
      ->where('media_id', $validatedData['media_id'])
      ->exists();

    return response()->json($isFavorite);
  }
}
