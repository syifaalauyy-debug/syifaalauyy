<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'indonesia');
        $apiKey   = config('services.news.key');

        $searchQuery = match($category) {
            'politics'      => 'politik indonesia',
            'national'      => 'nasional indonesia',
            'business'      => 'bisnis ekonomi indonesia',
            'tech'          => 'teknologi indonesia',
            'science'       => 'sains ilmu pengetahuan',
            'health'        => 'kesehatan indonesia',
            'sports'        => 'olahraga indonesia',
            'entertainment' => 'hiburan artis indonesia',
            'automotive'    => 'otomotif mobil motor indonesia',
            'travel'        => 'wisata travel indonesia',
            'lifestyle'     => 'gaya hidup lifestyle indonesia',
            'property'      => 'properti rumah indonesia',
            'education'     => 'pendidikan sekolah universitas indonesia',
            'law'           => 'hukum kriminal pengadilan indonesia',
            default         => 'indonesia',
        };

        $articles = Cache::remember("news_{$category}", now()->addMinutes(15), function () use ($searchQuery, $apiKey) {
            try {
                $response = Http::timeout(10)->get('https://newsapi.org/v2/everything', [
                    'q'        => $searchQuery,
                    'language' => 'id',
                    'sortBy'   => 'publishedAt',
                    'pageSize' => 100, // maksimal NewsAPI
                    'apiKey'   => $apiKey,
                ]);

                if (!$response->successful()) return [];

                $articles = $response->json('articles') ?? [];

                // Filter minimal — hanya buang yang benar-benar sampah
                $articles = array_filter($articles, function ($a) {
                    return !empty($a['title'])
                        && $a['title'] !== '[Removed]'
                        && ($a['description'] ?? '') !== '[Removed]'
                        && $a['title'] !== 'Removed'; // variasi lain
                });

                // Buang duplikat berdasarkan domain sumber
                $seen   = [];
                $unique = [];
                foreach ($articles as $a) {
                    $domain = parse_url($a['url'], PHP_URL_HOST);
                    if (!in_array($domain, $seen)) {
                        $seen[]   = $domain;
                        $unique[] = $a;
                    }
                    if (count($unique) >= 25) break; // hero + 24 grid
                }

                return $unique;

            } catch (\Exception $e) {
                return [];
            }
        });

        // Fallback jika kosong
        if (empty($articles)) {
            $articles = [[
                'title'       => 'Berita tidak dapat dimuat',
                'urlToImage'  => null,
                'url'         => '#',
                'description' => 'Periksa API key atau koneksi internet. Limit free plan: 100 request/hari.',
                'source'      => ['name' => 'Info'],
                'publishedAt' => now()->toISOString(),
            ]];
        }

        $comments = Comment::with('user')->latest()->get();

        return view('dashboard', compact('articles', 'comments', 'category'));
    }
}