<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    public function storeComment(Request $request)
    {
        $request->validate([
            'news_url' => 'required',
            'comment_text' => 'required|string|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'news_url' => $request->news_url,
            'comment_text' => $request->comment_text,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function storeBookmark(Request $request)
    {
        $request->validate([
            'news_title' => 'required',
            'news_url' => 'required',
            'image_url' => 'nullable',
        ]);

        $exists = Bookmark::where('user_id', Auth::id())
                          ->where('news_url', $request->news_url)
                          ->exists();

        if (!$exists) {
            Bookmark::create([
                'user_id' => Auth::id(),
                'news_title' => $request->news_title,
                'news_url' => $request->news_url,
                'image_url' => $request->image_url,
            ]);
            return redirect()->back()->with('success', 'Berita berhasil disimpan!');
        }

        return redirect()->back()->with('info', 'Berita ini sudah ada di bookmark kamu.');
    }
}