<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">

<x-app-layout>
    <x-slot name="header">
        <div class="bg-white border-b border-gray-200">

            {{-- Top bar --}}
            <div style="background: linear-gradient(90deg, #FB5802, #FD016B);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex items-center justify-between">
                    <span class="text-xs text-pink-200 tracking-wide">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <a href="{{ route('dashboard') }}"
                       class="text-xs text-pink-200 hover:text-white font-medium uppercase tracking-widest transition-colors">
                        ← Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- Masthead --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center border-b border-gray-100">
                <h1 class="text-3xl font-black text-[#FB5802]"
                    style="font-family: 'Cormorant Garamond', Georgia, serif; letter-spacing: -0.5px; font-size: 3rem; font-weight: 700; background: linear-gradient(135deg, #FFBF0E 0%, #FB5802 35%, #FD016B 70%, #FF69A8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Berita<span class="text-[#FD016B]">Terkini</span>
                </h1>
                <div class="mt-1 flex items-center justify-center gap-3">
                    <div style="height:1px;width:56px;background:linear-gradient(90deg,#FB5802,#FD016B);"></div>
                    <span class="text-[10px] uppercase tracking-[0.25em] style="color:#FF69A8;font-family:'Source Sans 3',sans-serif;" class="text-xs font-semibold tracking-widest uppercase">Informasi Terpercaya</span>
                    <div style="height:1px;width:56px;background:linear-gradient(90deg,#FB5802,#FD016B);"></div>
                </div>
            </div>

            {{-- Page title bar --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-amber-400">⭐</span>
                    <h2 class="text-sm font-black uppercase tracking-widest text-[#FB5802]">Berita Favorit Saya</h2>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full font-medium">
                    {{ $bookmarks->count() }} tersimpan
                </span>
            </div>

        </div>
    </x-slot>

    <div style="background:linear-gradient(180deg,#fff5f8 0%,#fff0f5 100%);min-height:100vh;padding:2rem 0;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="mb-5 flex items-center gap-2 px-4 py-3 text-sm" style="background:#fff5f8;border:1px solid #ffd6e7;border-radius:8px;color:#c0006b;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if($bookmarks->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 bg-white text-center px-6" style="border:1px solid #ffd6e7;border-radius:12px;box-shadow:0 4px 20px rgba(253,1,107,0.08);">
                    <div class="text-5xl mb-4">⭐</div>
                    <h3 class="text-lg font-bold text-gray-600 mb-2" style="font-family: Georgia, serif;">
                        Belum ada berita favorit
                    </h3>
                    <p class="text-sm text-gray-400 mb-6">
                        Simpan berita menarik dengan menekan tombol ⭐ Simpan di halaman utama.
                    </p>
                    <a href="{{ route('dashboard') }}"
                       style="padding:10px 24px;background:linear-gradient(90deg,#FB5802,#FD016B);color:white;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;border-radius:20px;text-decoration:none;box-shadow:0 2px 10px rgba(253,1,107,0.3);">
                        Jelajahi Berita →
                    </a>
                </div>

            @else

                {{-- Section divider --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="h-0.5 w-5 bg-[#FD016B]"></div>
                    <span class="text-xs font-black uppercase tracking-widest text-[#FB5802]">Daftar Tersimpan</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                {{-- Grid 3 kolom --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">

                    @foreach($bookmarks as $bookmark)
                    <div style="background: white; border: 1px solid #ffd6e7; border-radius: 10px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 2px 12px rgba(253,1,107,0.10);">

                        {{-- Thumbnail 180px fixed --}}
                        <a href="{{ $bookmark->news_url }}" target="_blank"
                           style="display: block; width: 100%; height: 180px; overflow: hidden; position: relative; background: #f3f4f6; flex-shrink: 0;">
                            @if(!empty($bookmark->image_url))
                                <img src="{{ $bookmark->image_url }}"
                                     alt="{{ $bookmark->news_title }}"
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#d1d5db;\'><span style=\'font-size:2rem;\'>📰</span><span style=\'font-size:0.7rem;margin-top:4px;\'>Gambar tidak tersedia</span></div>'">
                            @else
                                <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#d1d5db;">
                                    <span style="font-size:2rem;">📰</span>
                                    <span style="font-size:0.7rem;margin-top:4px;">Gambar tidak tersedia</span>
                                </div>
                            @endif
                            <span style="position:absolute;top:8px;left:8px;background:linear-gradient(90deg,#FB5802,#FD016B);color:white;font-size:10px;font-weight:700;padding:3px 10px;border-radius:12px;text-transform:uppercase;letter-spacing:0.05em;box-shadow:0 2px 6px rgba(253,1,107,0.4);">
                                ⭐ Favorit
                            </span>
                        </a>

                        {{-- Konten --}}
                        <div style="padding: 1rem; display: flex; flex-direction: column; flex: 1;">

                            <p style="font-size: 10px; color: #9ca3af; font-style: italic; margin-bottom: 8px;">
                                Disimpan {{ $bookmark->created_at->diffForHumans() }}
                            </p>

                            <h3 style="font-family: Georgia, serif; font-weight: 700; font-size: 0.9rem; color: #1a1a1a; line-height: 1.4; flex: 1; margin-bottom: 12px;
                                       display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                <a href="{{ $bookmark->news_url }}" target="_blank"
                                   style="color: inherit; text-decoration: none;"
                                   onmouseover="this.style.color='#FD016B'" onmouseout="this.style.color='inherit'">
                                    {{ $bookmark->news_title }}
                                </a>
                            </h3>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid #f3f4f6;">
                                <a href="{{ $bookmark->news_url }}" target="_blank"
                                   style="font-size: 11px; font-weight: 700; color: #FB5802; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none;"
                                   onmouseover="this.style.color='#FD016B'" onmouseout="this.style.color='#FB5802'">
                                    Baca →
                                </a>
                                <form action="{{ route('bookmark.destroy', $bookmark->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus dari favorit?')" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="font-size: 11px; color: #f87171; font-weight: 600; background: none; border: none; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#f87171'">
                                        🗑 Hapus
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>

                {{-- Responsive grid untuk mobile --}}
                <style>
                    @media (max-width: 768px) {
                        .bookmark-grid { grid-template-columns: 1fr !important; }
                    }
                    @media (min-width: 769px) and (max-width: 1024px) {
                        .bookmark-grid { grid-template-columns: repeat(2, 1fr) !important; }
                    }
                </style>

            @endif

        </div>
    </div>

</x-app-layout>