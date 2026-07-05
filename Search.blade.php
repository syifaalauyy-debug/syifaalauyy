<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">

<x-app-layout>
    <x-slot name="header">
        <div class="bg-white" style="border-bottom:1px solid #ffd6e7;">

            {{-- Top bar --}}
            <div style="background: linear-gradient(90deg, #FB5802 0%, #FD016B 100%);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between">
                    <span style="font-size:11px;color:rgba(255,255,255,0.8);font-family:'Source Sans 3',sans-serif;">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <a href="{{ route('dashboard') }}"
                       style="font-size:11px;color:rgba(255,255,255,0.8);font-family:'Source Sans 3',sans-serif;text-decoration:none;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- Masthead --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 text-center" style="border-bottom:1px solid #ffd6e7;">
                <h1 style="font-family:'Cormorant Garamond',Georgia,serif;font-size:3rem;font-weight:700;letter-spacing:-1px;background:linear-gradient(135deg,#FB5802 0%,#FD016B 60%,#FF69A8 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    BeritaTerkini
                </h1>
                <div style="margin-top:4px;display:flex;align-items:center;justify-content:center;gap:12px;">
                    <div style="height:1px;width:56px;background:linear-gradient(90deg,#FB5802,#FD016B);"></div>
                    <span style="font-family:'Source Sans 3',sans-serif;font-size:10px;text-transform:uppercase;letter-spacing:0.25em;color:#FB5802;font-weight:600;opacity:0.8;">Informasi Terpercaya</span>
                    <div style="height:1px;width:56px;background:linear-gradient(90deg,#FD016B,#FF69A8);"></div>
                </div>
            </div>

            {{-- Search bar --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <form action="{{ route('search') }}" method="GET"
                      style="display:flex;align-items:center;gap:10px;max-width:640px;margin:0 auto;">
                    <div style="flex:1;position:relative;">
                        <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#FB5802;font-size:16px;">🔍</span>
                        <input type="text" name="q" value="{{ $query }}"
                               placeholder="Cari berita..."
                               style="width:100%;padding:10px 16px 10px 40px;font-size:13px;font-family:'Source Sans 3',sans-serif;border:2px solid #FD016B;border-radius:24px;outline:none;background:#fff5f8;color:#333;"
                               required>
                    </div>
                    <button type="submit"
                            style="padding:10px 22px;background:linear-gradient(90deg,#FB5802,#FD016B);color:white;font-size:12px;font-weight:700;font-family:'Source Sans 3',sans-serif;text-transform:uppercase;letter-spacing:0.08em;border:none;border-radius:24px;cursor:pointer;white-space:nowrap;box-shadow:0 2px 10px rgba(253,1,107,0.3);">
                        Cari
                    </button>
                </form>
            </div>

        </div>
    </x-slot>

    <div style="background:linear-gradient(180deg,#fff5f8 0%,#fff0f5 100%);min-height:100vh;padding:2rem 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Hasil pencarian header --}}
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:1.5rem;">
                <div style="width:20px;height:3px;background:linear-gradient(90deg,#FB5802,#FD016B);border-radius:2px;flex-shrink:0;"></div>
                <span style="font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:0.15em;background:linear-gradient(90deg,#FB5802,#FD016B);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-family:'Source Sans 3',sans-serif;">
                    Hasil pencarian: "{{ $query }}"
                </span>
                <div style="flex:1;height:1px;background:#ffd6e7;"></div>
                <span style="font-size:11px;color:#FF69A8;font-family:'Source Sans 3',sans-serif;">
                    {{ count($articles) }} berita ditemukan
                </span>
            </div>

            @if(count($articles) > 0)
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;">
                    @foreach($articles as $berita)
                    <div style="background:white;border:1px solid #ffd6e7;border-radius:10px;overflow:hidden;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(253,1,107,0.08);">

                        {{-- Thumbnail --}}
                        <a href="{{ $berita['url'] }}" target="_blank"
                           style="display:block;width:100%;height:180px;overflow:hidden;position:relative;background:#fff0f5;flex-shrink:0;">
                            @if(!empty($berita['urlToImage']))
                                <img src="{{ $berita['urlToImage'] }}" alt="{{ $berita['title'] }}"
                                     style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s;"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'"
                                     onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#ffb3d0;\'><span style=\'font-size:2rem;\'>📰</span><span style=\'font-size:0.7rem;margin-top:4px;\'>Gambar tidak tersedia</span></div>'">
                            @else
                                <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#ffb3d0;">
                                    <span style="font-size:2rem;">📰</span>
                                    <span style="font-size:0.7rem;margin-top:4px;">Gambar tidak tersedia</span>
                                </div>
                            @endif
                        </a>

                        {{-- Konten --}}
                        <div style="padding:1rem;display:flex;flex-direction:column;flex:1;">
                            <p style="font-size:10px;font-weight:700;font-family:'Source Sans 3',sans-serif;color:#FD016B;text-transform:uppercase;letter-spacing:0.12em;margin-bottom:6px;border-left:3px solid #FB5802;padding-left:6px;">
                                {{ $berita['source']['name'] ?? 'Sumber Tidak Diketahui' }}
                            </p>
                            <h3 style="font-family:'Cormorant Garamond',Georgia,serif;font-weight:700;font-size:1.05rem;color:#2a0a0a;line-height:1.4;margin-bottom:8px;flex:1;
                                       display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                <a href="{{ $berita['url'] }}" target="_blank" style="color:inherit;text-decoration:none;"
                                   onmouseover="this.style.color='#FD016B'" onmouseout="this.style.color='inherit'">
                                    {{ $berita['title'] }}
                                </a>
                            </h3>
                            <div style="height:1px;background:linear-gradient(90deg,#FB5802,#FF69A8);margin-bottom:8px;opacity:0.2;"></div>
                            <p style="font-family:'Cormorant Garamond',Georgia,serif;font-size:13px;color:#7a3a50;line-height:1.7;margin-bottom:10px;
                                      display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $berita['description'] ?? '' }}
                            </p>

                            <div style="display:flex;align-items:center;justify-content:space-between;padding-top:8px;border-top:1px solid #ffd6e7;">
                                <span style="font-size:10px;color:#FF69A8;font-style:italic;font-family:'Source Sans 3',sans-serif;">
                                    {{ isset($berita['publishedAt']) ? \Carbon\Carbon::parse($berita['publishedAt'])->diffForHumans() : '' }}
                                </span>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <a href="{{ $berita['url'] }}" target="_blank"
                                       style="font-size:11px;font-weight:700;font-family:'Source Sans 3',sans-serif;color:#FB5802;text-transform:uppercase;letter-spacing:0.05em;text-decoration:none;"
                                       onmouseover="this.style.color='#FD016B'" onmouseout="this.style.color='#FB5802'">
                                        Baca →
                                    </a>
                                    <form action="{{ route('bookmark.store') }}" method="POST" style="margin:0;">
                                        @csrf
                                        <input type="hidden" name="news_title" value="{{ $berita['title'] }}">
                                        <input type="hidden" name="news_url" value="{{ $berita['url'] }}">
                                        <input type="hidden" name="image_url" value="{{ $berita['urlToImage'] ?? '' }}">
                                        <button type="submit" title="Simpan ke Favorit"
                                                style="background:none;border:none;cursor:pointer;font-size:15px;color:#FB5802;">⭐</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            @else
                <div style="text-align:center;padding:5rem 1rem;background:white;border:1px solid #ffd6e7;border-radius:12px;">
                    <p style="font-size:3rem;margin-bottom:12px;">🔍</p>
                    <p style="font-family:'Cormorant Garamond',Georgia,serif;font-size:1.2rem;font-weight:700;color:#FB5802;margin-bottom:6px;">
                        Tidak ada berita untuk "{{ $query }}"
                    </p>
                    <p style="font-size:0.875rem;color:#FF69A8;font-family:'Source Sans 3',sans-serif;">
                        Coba kata kunci yang berbeda.
                    </p>
                </div>
            @endif

        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns:repeat(3"] { grid-template-columns: 1fr !important; }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            div[style*="grid-template-columns:repeat(3"] { grid-template-columns: repeat(2,1fr) !important; }
        }
    </style>
</x-app-layout>