<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteCategoryController extends Controller
{
    public function index()
    // Mengambil kategori favorit user yang sedang login
    $favorites = Category::whereHas('users', function($query) {
        $query->where('user_id', auth()->id());
    })->get();

    return view('categories.favorites', compact('favorites'));
}
