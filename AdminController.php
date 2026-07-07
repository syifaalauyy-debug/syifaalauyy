<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use App\Models\Bookmark;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::withCount(['comments', 'bookmarks'])
                     ->latest()
                     ->get();

        $totalUsers    = $users->count();
        $totalKomentar = Comment::count();
        $totalBookmark = Bookmark::count();

        return view('admin.index', compact('users', 'totalUsers', 'totalKomentar', 'totalBookmark'));
    }
}