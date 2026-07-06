<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
                             ->latest()
                             ->get();

        return view('news.bookmarks', compact('bookmarks'));
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::where('id', $id)
                            ->where('user_id', auth()->id())
                            ->firstOrFail();

        $bookmark->delete();

        return back()->with('success', 'Berita berhasil dihapus dari favorit.');
    }
}