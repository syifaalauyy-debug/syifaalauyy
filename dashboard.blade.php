<x-app-layout>
    <x-slot name="header">
        <div class="np-header">

            {{-- Ticker Bar --}}
            <div class="np-ticker-bar">
                <div class="np-ticker-inner">
                    <span class="np-ticker-label">TERKINI</span>
                    <div class="np-ticker-track-wrap">
                        <div class="np-ticker-track">
                            <span>Portal Berita Indonesia &nbsp;·&nbsp; Informasi Terpercaya &nbsp;·&nbsp; Berita Hari Ini &nbsp;·&nbsp; Update Terbaru &nbsp;·&nbsp; Politik · Bisnis · Teknologi · Sains · Kesehatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <span aria-hidden="true">Portal Berita Indonesia &nbsp;·&nbsp; Informasi Terpercaya &nbsp;·&nbsp; Berita Hari Ini &nbsp;·&nbsp; Update Terbaru &nbsp;·&nbsp; Politik · Bisnis · Teknologi · Sains · Kesehatan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </div>
                    </div>
                    <span class="np-ticker-date">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            {{-- Masthead --}}
            <div class="np-masthead-wrap">
                <div class="np-masthead">
                    <div class="np-masthead-rule"></div>
                    <div class="np-masthead-center">
                        <h1 class="np-brand">
                            <span class="np-brand-b">Berita</span><span class="np-brand-t">Terkini</span>
                        </h1>
                        <p class="np-tagline">Informasi Terpercaya untuk Indonesia</p>
                    </div>
                    <div class="np-masthead-rule"></div>
                </div>
            </div>

            {{-- Category Nav --}}
            <div class="np-nav-wrap">
                <div class="np-nav">
                    @php
                        $menuKategori = [
                            'indonesia' => 'Semua',
                            'politics'  => 'Politik',
                            'national'  => 'Nasional',
                            'business'  => 'Bisnis',
                            'tech'      => 'Teknologi',
                            'science'   => 'Sains',
                            'health'    => 'Kesehatan',
                        ];
                        $kategoriAktif = request()->query('category', 'indonesia');
                    @endphp

                    @foreach($menuKategori as $query => $namaMenu)
                        <a href="{{ route('dashboard', ['category' => $query]) }}"
                           class="np-navlink {{ $kategoriAktif === $query ? 'np-navlink--active' : '' }}">
                            {{ $namaMenu }}
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </x-slot>

    <div class="np-body">
        <div class="np-container">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="np-flash np-flash--success np-appear" role="alert">
                    <span class="np-flash-icon">✓</span>
                    <span class="np-flash-text">{{ session('success') }}</span>
                    <button class="np-flash-close" onclick="this.parentElement.remove()" aria-label="Tutup">✕</button>
                </div>
            @endif

            @if(session('info'))
                <div class="np-flash np-flash--info np-appear" role="alert">
                    <span class="np-flash-icon">ℹ</span>
                    <span class="np-flash-text">{{ session('info') }}</span>
                    <button class="np-flash-close" onclick="this.parentElement.remove()" aria-label="Tutup">✕</button>
                </div>
            @endif

            @if(isset($articles) && count($articles) > 0)

                {{-- Hero Article --}}
                @php $hero = collect($articles)->first(fn($a) => !empty($a['title'])); @endphp

                @if($hero)
                <section class="np-hero np-appear">
                    <div class="np-hero-inner">

                        {{-- Image --}}
                        <div class="np-hero-img-col">
                            @if(!empty($hero['urlToImage']))
                                <img src="{{ $hero['urlToImage'] }}"
                                     alt="{{ $hero['title'] }}"
                                     class="np-hero-img"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="np-img-fallback" style="display:none;">
                                    <span>📰</span><small>Gambar tidak tersedia</small>
                                </div>
                            @else
                                <div class="np-img-fallback">
                                    <span>📰</span><small>Gambar tidak tersedia</small>
                                </div>
                            @endif
                            <div class="np-hero-overlay"></div>
                            <div class="np-hero-badge">Berita Utama</div>
                        </div>

                        {{-- Content --}}
                        <div class="np-hero-content">
                            <div class="np-hero-meta">
                                <span class="np-source-chip">{{ $hero['source']['name'] ?? 'Berita' }}</span>
                            </div>

                            <h2 class="np-hero-title">{{ $hero['title'] }}</h2>

                            <div class="np-rule-thin"></div>

                            <p class="np-hero-desc">
                                {{ str($hero['description'] ?? 'Tidak ada deskripsi.')->limit(220) }}
                            </p>

                            <div class="np-hero-actions">
                                <div class="np-action-row">
                                    <a href="{{ $hero['url'] }}" target="_blank" class="np-btn np-btn--primary">
                                        Baca Selengkapnya
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                    </a>
                                    <form action="{{ route('bookmark.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="news_title" value="{{ $hero['title'] }}">
                                        <input type="hidden" name="news_url" value="{{ $hero['url'] }}">
                                        <input type="hidden" name="image_url" value="{{ $hero['urlToImage'] ?? '' }}">
                                        <button type="submit" class="np-btn np-btn--save">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                            Simpan
                                        </button>
                                    </form>
                                </div>

                                {{-- Comment --}}
                                <div class="np-comment-box">
                                    <p class="np-comment-heading">Komentar</p>
                                    <form action="{{ route('comment.store') }}" method="POST" class="np-comment-form">
                                        @csrf
                                        <input type="hidden" name="news_url" value="{{ $hero['url'] }}">
                                        <input type="text" name="comment_text" placeholder="Tulis komentar…" class="np-comment-input" required>
                                        <button type="submit" class="np-btn-send">Kirim</button>
                                    </form>
                                    @php $heroComments = isset($comments) ? $comments->where('news_url', $hero['url']) : collect(); @endphp
                                    @if($heroComments->isNotEmpty())
                                        <div class="np-comment-list">
                                            @foreach($heroComments as $item)
                                                <div class="np-comment-item">
                                                    <span class="np-comment-author">{{ $item->user->name ?? 'Anonim' }}</span>
                                                    {{ $item->comment_text }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="np-comment-empty">Belum ada komentar.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                @endif

                {{-- Section Divider --}}
                <div class="np-section-divider">
                    <span class="np-section-label">Berita Lainnya</span>
                    <div class="np-section-rule"></div>
                </div>

                {{-- Article Grid --}}
                <div class="np-grid">
                    @foreach(collect($articles)->skip(1) as $idx => $berita)
                        @if(!empty($berita['title']))
                        <article class="np-card np-appear" style="animation-delay:{{ ($idx % 6) * 70 }}ms">

                            {{-- Thumbnail --}}
                            <a href="{{ $berita['url'] }}" target="_blank" class="np-card-img-wrap">
                                @if(!empty($berita['urlToImage']))
                                    <img src="{{ $berita['urlToImage'] }}" alt="{{ $berita['title'] }}"
                                         class="np-card-img"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="np-img-fallback np-img-fallback--sm" style="display:none;">
                                        <span>📰</span>
                                    </div>
                                @else
                                    <div class="np-img-fallback np-img-fallback--sm">
                                        <span>📰</span>
                                    </div>
                                @endif
                                <div class="np-card-img-shade"></div>
                            </a>

                            {{-- Content --}}
                            <div class="np-card-body">
                                <span class="np-source-chip np-source-chip--sm">{{ $berita['source']['name'] ?? 'Sumber Tidak Diketahui' }}</span>
                                <h3 class="np-card-title">
                                    <a href="{{ $berita['url'] }}" target="_blank" class="np-card-title-link">
                                        {{ $berita['title'] }}
                                    </a>
                                </h3>
                                <div class="np-rule-thin np-rule-thin--card"></div>
                                <p class="np-card-desc">
                                    {{ $berita['description'] ?? 'Tidak ada deskripsi untuk berita ini.' }}
                                </p>

                                {{-- Footer --}}
                                <div class="np-card-footer">
                                    <span class="np-card-time">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ isset($berita['publishedAt']) ? \Carbon\Carbon::parse($berita['publishedAt'])->diffForHumans() : '' }}
                                    </span>
                                    <div class="np-card-actions">
                                        <a href="{{ $berita['url'] }}" target="_blank" class="np-link-read">Baca →</a>
                                        <form action="{{ route('bookmark.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="news_title" value="{{ $berita['title'] }}">
                                            <input type="hidden" name="news_url" value="{{ $berita['url'] }}">
                                            <input type="hidden" name="image_url" value="{{ $berita['urlToImage'] ?? '' }}">
                                            <button type="submit" class="np-link-save" title="Simpan">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Comment --}}
                                <div class="np-card-comment">
                                    <form action="{{ route('comment.store') }}" method="POST" class="np-comment-form">
                                        @csrf
                                        <input type="hidden" name="news_url" value="{{ $berita['url'] }}">
                                        <input type="text" name="comment_text" placeholder="Tulis komentar…" class="np-comment-input" required>
                                        <button type="submit" class="np-btn-send np-btn-send--sm">Kirim</button>
                                    </form>
                                    @php $beritaComments = isset($comments) ? $comments->where('news_url', $berita['url']) : collect(); @endphp
                                    @if($beritaComments->isNotEmpty())
                                        <div class="np-comment-list np-comment-list--sm">
                                            @foreach($beritaComments as $item)
                                                <div class="np-comment-item">
                                                    <span class="np-comment-author">{{ $item->user->name ?? 'Anonim' }}</span>
                                                    {{ $item->comment_text }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="np-comment-empty">Belum ada komentar.</p>
                                    @endif
                                </div>
                            </div>
                        </article>
                        @endif
                    @endforeach
                </div>

            @else
                <div class="np-empty">
                    <span class="np-empty-icon">📰</span>
                    <p class="np-empty-title">Tidak ada berita untuk kategori ini.</p>
                    <p class="np-empty-sub">Coba pilih kategori lain di atas.</p>
                </div>
            @endif

        </div>
    </div>

<style>
/* ═══════════════════════════════════════════════
   DESIGN TOKENS
═══════════════════════════════════════════════ */
:root {
    /* Palette */
    --ink:        #0F2240;   /* deep navy — dominant text & header */
    --ink-mid:    #3D5478;   /* mid navy — secondary text */
    --ink-soft:   #7A8FAD;   /* muted navy — captions, meta */
    --vermilion:  #C8442A;   /* burnt vermilion — source labels, badge ONLY */
    --paper:      #FAF9F6;   /* warm off-white — page bg */
    --surface:    #FFFFFF;   /* card surface */
    --rule:       #DFD9CE;   /* warm hairline rule */
    --rule-soft:  #EEE9E1;   /* very light rule */
    --ticker-bg:  #0F2240;

    /* Type */
    --font-display: Georgia, 'Times New Roman', 'Noto Serif', serif;
    --font-ui:      'Inter', system-ui, -apple-system, sans-serif;

    /* Shape */
    --radius-card: 4px;
    --radius-pill: 99px;

    /* Shadow */
    --shadow-card:  0 1px 4px rgba(15,34,64,.06), 0 0 0 1px rgba(15,34,64,.06);
    --shadow-hover: 0 8px 28px rgba(15,34,64,.12), 0 1px 4px rgba(15,34,64,.08);
    --shadow-hero:  0 4px 24px rgba(15,34,64,.10);

    --ease: cubic-bezier(.4,0,.2,1);
}

/* ═══════════════════════════════════════════════
   HEADER
═══════════════════════════════════════════════ */
.np-header {
    background: var(--surface);
    border-bottom: 1.5px solid var(--rule);
    position: sticky;
    top: 0;
    z-index: 50;
}

/* Ticker */
.np-ticker-bar {
    background: var(--ticker-bg);
    overflow: hidden;
}
.np-ticker-inner {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    align-items: center;
    height: 32px;
    gap: 0;
}
.np-ticker-label {
    flex-shrink: 0;
    font-family: var(--font-ui);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--vermilion);
    background: rgba(200,68,42,.18);
    border: 1px solid rgba(200,68,42,.35);
    padding: 2px 8px;
    border-radius: 2px;
    margin-right: 12px;
    white-space: nowrap;
}
.np-ticker-date {
    flex-shrink: 0;
    font-family: var(--font-ui);
    font-size: 0.6rem;
    color: rgba(255,255,255,.45);
    margin-left: 12px;
    white-space: nowrap;
}
.np-ticker-track-wrap {
    flex: 1;
    overflow: hidden;
    position: relative;
    mask-image: linear-gradient(90deg, transparent 0%, black 4%, black 96%, transparent 100%);
    -webkit-mask-image: linear-gradient(90deg, transparent 0%, black 4%, black 96%, transparent 100%);
}
.np-ticker-track {
    display: flex;
    white-space: nowrap;
    animation: ticker-scroll 38s linear infinite;
    font-family: var(--font-ui);
    font-size: 0.65rem;
    color: rgba(255,255,255,.6);
    letter-spacing: 0.04em;
}
@keyframes ticker-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* Masthead */
.np-masthead-wrap {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
}
.np-masthead {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 16px 0 12px;
    border-bottom: 1.5px solid var(--rule);
}
.np-masthead-rule {
    flex: 1;
    height: 1.5px;
    background: linear-gradient(90deg, transparent, var(--ink) 40%, transparent);
    opacity: .18;
}
.np-masthead-center { text-align: center; }
.np-brand {
    font-family: var(--font-display);
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 900;
    letter-spacing: -0.03em;
    line-height: 1;
    margin: 0;
}
.np-brand-b { color: var(--ink); }
.np-brand-t { color: var(--vermilion); }

.np-tagline {
    font-family: var(--font-ui);
    font-size: 0.58rem;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--ink-soft);
    margin: 5px 0 0;
}

/* Category Nav */
.np-nav-wrap {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
}
.np-nav {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0;
}
.np-navlink {
    font-family: var(--font-ui);
    font-size: 0.67rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    text-decoration: none;
    color: var(--ink-soft);
    padding: 10px 14px;
    border-bottom: 2px solid transparent;
    transition: color .18s var(--ease), border-color .18s var(--ease);
    white-space: nowrap;
}
.np-navlink:hover {
    color: var(--ink);
    border-bottom-color: var(--ink);
}
.np-navlink--active {
    color: var(--vermilion);
    border-bottom-color: var(--vermilion);
}

/* ═══════════════════════════════════════════════
   PAGE BODY
═══════════════════════════════════════════════ */
.np-body {
    background: var(--paper);
    min-height: 100vh;
    padding: 32px 0 64px;
}
.np-container {
    max-width: 88rem;
    margin: 0 auto;
    padding: 0 1rem;
}
@media (min-width: 640px)  { .np-container { padding: 0 1.5rem; } }
@media (min-width: 1024px) { .np-container { padding: 0 2rem; } }

/* Appear animation */
.np-appear {
    animation: np-fade-up .45s var(--ease) both;
}
@keyframes np-fade-up {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ═══════════════════════════════════════════════
   SHARED ELEMENTS
═══════════════════════════════════════════════ */
.np-source-chip {
    display: inline-block;
    font-family: var(--font-ui);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--vermilion);
    border-left: 2.5px solid var(--vermilion);
    padding-left: 6px;
    line-height: 1;
}
.np-source-chip--sm { font-size: 0.58rem; }

.np-rule-thin {
    height: 1px;
    background: var(--rule);
    margin: 12px 0;
}
.np-rule-thin--card { margin: 8px 0; }

.np-img-fallback {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: var(--rule-soft);
    color: var(--ink-soft);
    width: 100%;
    height: 100%;
    font-size: 2.5rem;
}
.np-img-fallback small {
    font-family: var(--font-ui);
    font-size: 0.65rem;
}
.np-img-fallback--sm { font-size: 1.8rem; }

/* Comment system */
.np-comment-box, .np-card-comment {
    border-top: 1px solid var(--rule-soft);
    padding-top: 12px;
}
.np-comment-heading {
    font-family: var(--font-ui);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--ink-soft);
    margin: 0 0 8px;
}
.np-comment-form {
    display: flex;
    gap: 6px;
    align-items: center;
    margin-bottom: 8px;
}
.np-comment-input {
    flex: 1;
    font-family: var(--font-ui);
    font-size: 0.72rem;
    color: var(--ink);
    background: var(--paper);
    border: 1px solid var(--rule);
    border-radius: 2px;
    padding: 7px 10px;
    outline: none;
    transition: border-color .16s var(--ease), box-shadow .16s var(--ease);
}
.np-comment-input::placeholder { color: var(--ink-soft); }
.np-comment-input:focus {
    border-color: var(--ink);
    box-shadow: 0 0 0 3px rgba(15,34,64,.08);
}
.np-btn-send {
    flex-shrink: 0;
    font-family: var(--font-ui);
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    background: var(--ink);
    color: white;
    border: none;
    border-radius: 2px;
    padding: 7px 14px;
    cursor: pointer;
    transition: background .15s var(--ease);
}
.np-btn-send:hover { background: #1a3a5c; }
.np-btn-send--sm { padding: 6px 12px; font-size: 0.62rem; }

.np-comment-list {
    display: flex;
    flex-direction: column;
    gap: 5px;
    max-height: 100px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--rule) transparent;
}
.np-comment-list--sm { max-height: 90px; }
.np-comment-list::-webkit-scrollbar { width: 3px; }
.np-comment-list::-webkit-scrollbar-thumb { background: var(--rule); border-radius: 3px; }

.np-comment-item {
    font-family: var(--font-ui);
    font-size: 0.68rem;
    color: var(--ink-mid);
    line-height: 1.5;
    padding-bottom: 5px;
    border-bottom: 1px solid var(--rule-soft);
}
.np-comment-item:last-child { border-bottom: none; padding-bottom: 0; }
.np-comment-author {
    font-weight: 700;
    color: var(--ink);
    margin-right: 4px;
}
.np-comment-author::after { content: ":"; }
.np-comment-empty {
    font-family: var(--font-ui);
    font-size: 0.65rem;
    color: var(--ink-soft);
    font-style: italic;
    margin: 0;
}

/* ═══════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════ */
.np-hero {
    margin-bottom: 36px;
}
.np-hero-inner {
    display: flex;
    flex-direction: column;
    background: var(--surface);
    border: 1px solid var(--rule);
    border-radius: var(--radius-card);
    overflow: hidden;
    box-shadow: var(--shadow-hero);
    transition: box-shadow .22s var(--ease), transform .22s var(--ease);
}
.np-hero-inner:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-2px);
}
@media (min-width: 768px) {
    .np-hero-inner { flex-direction: row; }
}

.np-hero-img-col {
    position: relative;
    overflow: hidden;
    min-height: 260px;
    background: var(--rule-soft);
    display: flex;
    align-items: center;
    justify-content: center;
}
@media (min-width: 768px) {
    .np-hero-img-col { width: 58%; min-height: 360px; }
}

.np-hero-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .55s var(--ease);
}
.np-hero-inner:hover .np-hero-img { transform: scale(1.04); }

.np-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,34,64,.35) 0%, transparent 55%);
    pointer-events: none;
}

.np-hero-badge {
    position: absolute;
    top: 0;
    left: 0;
    background: var(--vermilion);
    color: white;
    font-family: var(--font-ui);
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    padding: 5px 14px;
    border-bottom-right-radius: 4px;
}

.np-hero-content {
    padding: 28px 28px 24px;
    display: flex;
    flex-direction: column;
    gap: 0;
    flex: 1;
}
@media (min-width: 768px) { .np-hero-content { width: 42%; } }

.np-hero-meta { margin-bottom: 10px; }

.np-hero-title {
    font-family: var(--font-display);
    font-size: clamp(1.2rem, 2.4vw, 1.55rem);
    font-weight: 900;
    color: var(--ink);
    line-height: 1.3;
    letter-spacing: -0.02em;
    margin: 0 0 4px;
}

.np-hero-desc {
    font-family: var(--font-display);
    font-size: 0.82rem;
    color: var(--ink-mid);
    line-height: 1.7;
    margin: 0;
}

.np-hero-actions {
    margin-top: auto;
    padding-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.np-action-row {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.np-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: var(--font-ui);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: background .16s var(--ease), transform .14s var(--ease), box-shadow .16s var(--ease);
    white-space: nowrap;
}
.np-btn--primary {
    background: var(--ink);
    color: white;
    padding: 9px 18px;
    box-shadow: 0 2px 8px rgba(15,34,64,.2);
}
.np-btn--primary:hover {
    background: #1a3a5c;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(15,34,64,.28);
}
.np-btn--save {
    background: transparent;
    color: var(--ink-mid);
    padding: 8px 14px;
    border: 1.5px solid var(--rule);
}
.np-btn--save:hover {
    background: var(--paper);
    color: var(--ink);
    border-color: var(--ink);
}

/* ═══════════════════════════════════════════════
   SECTION DIVIDER
═══════════════════════════════════════════════ */
.np-section-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}
.np-section-label {
    font-family: var(--font-ui);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--ink);
    white-space: nowrap;
}
.np-section-rule {
    flex: 1;
    height: 1.5px;
    background: var(--ink);
    opacity: .15;
}

/* ═══════════════════════════════════════════════
   ARTICLE GRID
═══════════════════════════════════════════════ */
.np-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 18px;
}
@media (min-width: 640px)  { .np-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .np-grid { grid-template-columns: repeat(3, 1fr); } }

/* ═══════════════════════════════════════════════
   CARD
═══════════════════════════════════════════════ */
.np-card {
    background: var(--surface);
    border: 1px solid var(--rule);
    border-radius: var(--radius-card);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-card);
    transition: box-shadow .2s var(--ease), transform .2s var(--ease);
}
.np-card:hover {
    box-shadow: var(--shadow-hover);
    transform: translateY(-3px);
}

.np-card-img-wrap {
    display: block;
    position: relative;
    overflow: hidden;
    height: 172px;
    background: var(--rule-soft);
}
.np-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .45s var(--ease);
}
.np-card:hover .np-card-img { transform: scale(1.06); }

.np-card-img-shade {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(15,34,64,.18) 0%, transparent 50%);
    pointer-events: none;
}

.np-card-body {
    padding: 14px 16px 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.np-card-title {
    font-family: var(--font-display);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.38;
    letter-spacing: -0.01em;
    margin: 6px 0 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.np-card-title-link {
    text-decoration: none;
    color: inherit;
    transition: color .15s var(--ease);
}
.np-card-title-link:hover { color: var(--vermilion); }

.np-card-desc {
    font-family: var(--font-display);
    font-size: 0.72rem;
    color: var(--ink-mid);
    line-height: 1.65;
    flex: 1;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.np-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px solid var(--rule-soft);
}
.np-card-time {
    font-family: var(--font-ui);
    font-size: 0.62rem;
    color: var(--ink-soft);
    font-style: italic;
    display: flex;
    align-items: center;
    gap: 4px;
}
.np-card-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.np-link-read {
    font-family: var(--font-ui);
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--ink);
    text-decoration: none;
    transition: color .14s var(--ease);
}
.np-link-read:hover { color: var(--vermilion); }

.np-link-save {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    color: var(--ink-soft);
    cursor: pointer;
    padding: 2px;
    transition: color .14s var(--ease), transform .14s var(--ease);
}
.np-link-save:hover {
    color: var(--ink);
    transform: scale(1.15);
}

.np-card-comment {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid var(--rule-soft);
}

/* ═══════════════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════════════ */
.np-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 24px;
    text-align: center;
    background: var(--surface);
    border: 1px solid var(--rule);
    border-radius: var(--radius-card);
    gap: 8px;
}
.np-empty-icon {
    font-size: 2.8rem;
    margin-bottom: 8px;
    opacity: .6;
}
.np-empty-title {
    font-family: var(--font-display);
    font-size: 1rem;
    font-weight: 700;
    color: var(--ink);
    margin: 0;
}
.np-empty-sub {
    font-family: var(--font-ui);
    font-size: 0.78rem;
    color: var(--ink-soft);
    margin: 0;
}

/* ═══════════════════════════════════════════════
   FLASH MESSAGES
═══════════════════════════════════════════════ */
.np-flash {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 16px;
    border-radius: var(--radius-card);
    border-left: 3px solid transparent;
    font-family: var(--font-ui);
    font-size: 0.78rem;
    font-weight: 500;
    margin-bottom: 20px;
    animation: np-flash-in .3s var(--ease) both;
}
@keyframes np-flash-in {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.np-flash--success {
    background: #F0FAF4;
    color: #1A5C35;
    border-left-color: #2E9E5B;
}
.np-flash--info {
    background: #FDF8EC;
    color: #7A5A10;
    border-left-color: #D4A017;
}
.np-flash-icon {
    font-size: 0.85rem;
    flex-shrink: 0;
    opacity: .85;
}
.np-flash-text { flex: 1; line-height: 1.5; }
.np-flash-close {
    flex-shrink: 0;
    background: none;
    border: none;
    font-size: 0.7rem;
    cursor: pointer;
    opacity: .45;
    padding: 0 2px;
    transition: opacity .15s var(--ease);
    line-height: 1;
    color: inherit;
}
.np-flash-close:hover { opacity: 1; }

@media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
</x-app-layout>