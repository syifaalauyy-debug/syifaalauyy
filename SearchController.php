<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->query('q', ''));

        if (empty($query)) {
            return redirect()->route('dashboard');
        }

        $apiKey = config('services.news.key');

        $articles = Cache::remember("search_" . md5($query), now()->addMinutes(10), function () use ($query, $apiKey) {
            try {
                $response = Http::timeout(10)->get('https://newsapi.org/v2/everything', [
                    'q'        => $query,
                    'language' => 'id',
                    'sortBy'   => 'relevancy',
                    'pageSize' => 30,
                    'apiKey'   => $apiKey,
                ]);

                if (!$response->successful()) return [];

                $articles = $response->json('articles') ?? [];

                // Filter artikel tidak lengkap
                $articles = array_filter($articles, function ($a) {
                    return !empty($a['title'])
                        && !empty($a['description'])
                        && $a['title'] !== '[Removed]'
                        && $a['description'] !== '[Removed]'
                        && strlen($a['description'] ?? '') > 40;
                });

                // Buang duplikat domain
                $seen   = [];
                $unique = [];
                foreach ($articles as $a) {
                    $domain = parse_url($a['url'], PHP_URL_HOST);
                    if (!in_array($domain, $seen)) {
                        $seen[]   = $domain;
                        $unique[] = $a;
                    }
                    if (count($unique) >= 20) break;
                }

                return $unique;

            } catch (\Exception $e) {
                return [];
            }
        });

        return view('search', compact('articles', 'query'));
    }
}