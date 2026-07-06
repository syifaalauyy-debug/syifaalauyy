<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    private function callGroq(string $prompt): string
    {
        $key = config('services.groq.key');

        $response = Http::timeout(20)
            ->withHeaders([
                'Authorization' => "Bearer {$key}",
                'Content-Type'  => 'application/json',
            ])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => 'llama-3.1-8b-instant',
                'max_tokens'  => 512,
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah asisten berita Indonesia yang bernama Aksara AI. Selalu jawab dalam Bahasa Indonesia yang baik dan sopan.'
                    ],
                    [
                        'role'    => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);

        if (!$response->successful()) {
            return 'Maaf, AI tidak dapat merespons saat ini. Error: ' . $response->status();
        }

        return $response->json('choices.0.message.content')
            ?? 'Maaf, tidak ada respons dari AI.';
    }

    // 1. Ringkasan berita
    public function summarize(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'nullable|string',
        ]);

        $prompt = "Buat ringkasan singkat (2-3 kalimat) dari berita berikut:\n\n"
            . "Judul: {$request->title}\n"
            . "Deskripsi: {$request->description}\n\n"
            . "Tulis ringkasan dalam Bahasa Indonesia yang jelas dan mudah dipahami.";

        return response()->json(['summary' => $this->callGroq($prompt)]);
    }

    // 2. Chatbot
    public function chat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $prompt = "Pengguna bertanya: {$request->message}\n\n"
            . "Jawab dengan singkat, informatif, dan dalam Bahasa Indonesia.";

        return response()->json(['reply' => $this->callGroq($prompt)]);
    }

    // 3. Rekomendasi
    public function recommend(Request $request)
    {
        $request->validate(['category' => 'required|string']);

        $prompt = "Berikan 3 rekomendasi topik berita menarik yang relevan dengan kategori '{$request->category}' di Indonesia. "
            . "Format: daftar bernomor 1, 2, 3. Setiap topik 1 kalimat singkat saja.";

        return response()->json(['recommendations' => $this->callGroq($prompt)]);
    }
}