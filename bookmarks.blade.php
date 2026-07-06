<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorit — Jurnal Aksara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { box-sizing:border-box; } body { margin:0;padding:0;background:#F2F5E2;font-family:'Source Sans 3',sans-serif; } a { text-decoration:none; }</style>
</head>
<body>
{{-- ===== NAVBAR ===== --}}
<nav style="background:#290024;border-bottom:3px solid #D4954D;position:sticky;top:0;z-index:100;box-shadow:0 2px 16px rgba(41,0,36,0.4);">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:58px;">
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;">
            <div style="display:flex;flex-direction:column;align-items:flex-start;line-height:1;">
                <span style="font-family:'Source Sans 3',sans-serif;font-size:9px;font-weight:700;letter-spacing:0.25em;text-transform:uppercase;color:#D4954D;margin-bottom:1px;">Jurnal</span>
                <span style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;color:#F2F5E2;letter-spacing:0.05em;line-height:1;">AKSARA</span>
            </div>
        </a>
        <form action="{{ route('search') }}" method="GET" style="flex:1;max-width:380px;margin:0 1.5rem;display:flex;align-items:center;gap:6px;">
            <div style="flex:1;position:relative;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#775533;font-size:13px;">🔍</span>
                <input type="text" name="q" placeholder="Cari berita..." style="width:100%;padding:7px 14px 7px 34px;font-size:12px;border:1px solid #775533;border-radius:4px;outline:none;background:#F2F5E2;color:#290024;" required>
            </div>
            <button type="submit" style="padding:7px 14px;background:#D4954D;color:#290024;font-size:11px;font-weight:700;border:none;border-radius:4px;cursor:pointer;white-space:nowrap;text-transform:uppercase;letter-spacing:0.05em;">Cari</button>
        </form>
        <div style="display:flex;align-items:center;gap:4px;">
            <a href="{{ route('dashboard') }}" style="color:#E3DEA4;font-size:11px;font-weight:700;padding:6px 12px;border-radius:3px;border:1px solid rgba(227,222,164,0.3);text-transform:uppercase;letter-spacing:0.05em;" onmouseover="this.style.background='rgba(212,149,77,0.2)'" onmouseout="this.style.background='transparent'">Beranda</a>
            <a href="{{ route('bookmark.index') }}" style="color:#E3DEA4;font-size:11px;font-weight:700;padding:6px 12px;border-radius:3px;border:1px solid rgba(227,222,164,0.3);text-transform:uppercase;letter-spacing:0.05em;" onmouseover="this.style.background='rgba(212,149,77,0.2)'" onmouseout="this.style.background='transparent'">⭐ Favorit</a>
            @if(Auth::user()->is_admin)
            <a href="{{ route('admin.index') }}" style="color:#E3DEA4;font-size:11px;font-weight:700;padding:6px 12px;border-radius:3px;border:1px solid rgba(227,222,164,0.3);text-transform:uppercase;letter-spacing:0.05em;" onmouseover="this.style.background='rgba(212,149,77,0.2)'" onmouseout="this.style.background='transparent'">🛡 Admin</a>
            @endif
            <div style="position:relative;" x-data="{ open: false }">
                <button @click="open = !open" style="display:flex;align-items:center;gap:6px;color:#F2F5E2;font-size:11px;font-weight:700;padding:6px 12px;border-radius:3px;border:1px solid rgba(212,149,77,0.5);background:rgba(212,149,77,0.15);cursor:pointer;text-transform:uppercase;">{{ Auth::user()->name }} ▾</button>
                <div x-show="open" @click.away="open = false" style="position:absolute;right:0;top:calc(100% + 8px);background:#F2F5E2;border:1px solid #D4954D;border-radius:4px;box-shadow:0 4px 20px rgba(41,0,36,0.2);min-width:160px;overflow:hidden;z-index:200;">
                    <a href="{{ route('profile.edit') }}" style="display:block;padding:10px 16px;font-size:12px;color:#290024;font-weight:600;border-bottom:1px solid #E3DEA4;" onmouseover="this.style.background='#E3DEA4'" onmouseout="this.style.background='transparent'">👤 Profil</a>
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">@csrf<button type="submit" style="width:100%;text-align:left;padding:10px 16px;font-size:12px;color:#775533;font-weight:600;background:none;border:none;cursor:pointer;" onmouseover="this.style.background='#E3DEA4'" onmouseout="this.style.background='transparent'">→ Keluar</button></form>
                </div>
            </div>
        </div>
    </div>
</nav>
<div style="background:#F2F5E2;border-bottom:2px solid #D4954D;">
    <div style="max-width:1280px;margin:0 auto;padding:1.25rem 1.5rem;text-align:center;">
        <p style="font-family:'Source Sans 3',sans-serif;font-size:9px;font-weight:700;letter-spacing:0.35em;text-transform:uppercase;color:#775533;margin:0 0 4px 0;">Jurnal</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:3.5rem;font-weight:900;color:#290024;letter-spacing:0.08em;margin:0;line-height:1;">AKSARA</h1>
        <div style="display:flex;align-items:center;justify-content:center;gap:12px;margin-top:6px;">
            <div style="height:1px;width:60px;background:#D4954D;"></div>
            <span style="font-family:'Cormorant Garamond',serif;font-size:11px;color:#775533;font-style:italic;letter-spacing:0.15em;">Portal Berita Indonesia Terpercaya</span>
            <div style="height:1px;width:60px;background:#D4954D;"></div>
        </div>
    </div>
</div>
<div style="max-width:1280px;margin:0 auto;padding:1.5rem;">
    @if(session('success'))
        <div style="margin-bottom:1rem;padding:10px 16px;background:#E3DEA4;border:1px solid #D4954D;border-radius:4px;color:#290024;font-size:13px;font-weight:600;">✓ {{ session('success') }}</div>
    @endif
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
        <div style="display:flex;align-items:center;gap:8px;">
            <div style="width:4px;height:18px;background:#D4954D;border-radius:1px;"></div>
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#290024;">⭐ Berita Favorit Saya</span>
        </div>
        <span style="font-size:11px;color:#775533;background:#E3DEA4;padding:4px 14px;border-radius:3px;border:1px solid #D4954D;font-weight:600;">{{ $bookmarks->count() }} tersimpan</span>
    </div>
    @if($bookmarks->isEmpty())
        <div style="text-align:center;padding:5rem 1rem;background:#fff;border:1px solid #E3DEA4;border-radius:4px;">
            <p style="font-size:3.5rem;margin-bottom:12px;">⭐</p>
            <p style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:#290024;margin-bottom:8px;">Belum ada berita favorit</p>
            <p style="font-size:13px;color:#775533;margin-bottom:1.5rem;">Simpan berita menarik dengan menekan tombol ⭐ di halaman utama.</p>
            <a href="{{ route('dashboard') }}" style="display:inline-block;padding:10px 24px;background:#290024;color:#F2F5E2;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;border-radius:3px;border:1px solid #D4954D;">Jelajahi Berita →</a>
        </div>
    @else
        <div style="display:grid;grid-template-columns:1fr 280px;gap:2rem;">
            <div style="background:#F2F5E2;border:1px solid #E3DEA4;border-radius:4px;overflow:hidden;box-shadow:0 1px 6px rgba(119,85,51,0.1);">
                @foreach($bookmarks as $bookmark)
                <div style="display:flex;gap:14px;padding:14px 16px;{{ !$loop->last ? 'border-bottom:1px solid #E3DEA4;' : '' }}align-items:flex-start;background:{{ $loop->even ? '#fff' : '#F2F5E2' }};">
                    <a href="{{ $bookmark->news_url }}" target="_blank" style="flex-shrink:0;width:115px;height:78px;overflow:hidden;border-radius:3px;background:#E3DEA4;display:block;border:1px solid #D4954D;position:relative;">
                        @if(!empty($bookmark->image_url))
                            <img src="{{ $bookmark->image_url }}" alt="{{ $bookmark->news_title }}" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#775533;font-size:1.5rem;\'>📰</div>'">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#775533;font-size:1.5rem;">📰</div>
                        @endif
                        <span style="position:absolute;top:3px;left:3px;background:#D4954D;color:#fff;font-size:9px;font-weight:700;padding:1px 6px;border-radius:2px;">⭐</span>
                    </a>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:10px;color:#775533;font-style:italic;margin:0 0 4px 0;font-family:'Cormorant Garamond',serif;">Disimpan {{ $bookmark->created_at->diffForHumans() }}</p>
                        <h3 style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#290024;line-height:1.4;margin:0 0 8px 0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            <a href="{{ $bookmark->news_url }}" target="_blank" style="color:inherit;" onmouseover="this.style.color='#D4954D'" onmouseout="this.style.color='#290024'">{{ $bookmark->news_title }}</a>
                        </h3>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:8px;border-top:1px solid #E3DEA4;">
                            <a href="{{ $bookmark->news_url }}" target="_blank" style="font-size:11px;font-weight:700;color:#775533;text-transform:uppercase;letter-spacing:0.05em;" onmouseover="this.style.color='#D4954D'" onmouseout="this.style.color='#775533'">Baca →</a>
                            <form action="{{ route('bookmark.destroy', $bookmark->id) }}" method="POST" onsubmit="return confirm('Hapus dari favorit?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;font-size:12px;color:#775533;font-weight:600;" onmouseover="this.style.color='#290024'" onmouseout="this.style.color='#775533'">🗑 Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div>
                <div style="background:#290024;border-radius:4px;overflow:hidden;margin-bottom:1rem;">
                    <div style="background:#290024;padding:10px 14px;border-bottom:2px solid #D4954D;">
                        <span style="font-family:'Playfair Display',serif;font-size:0.9rem;font-weight:700;color:#F2F5E2;">📊 Statistik Saya</span>
                    </div>
                    <div style="padding:16px;">
                        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding-bottom:12px;border-bottom:1px solid #775533;">
                            <span style="font-size:24px;">⭐</span>
                            <div>
                                <p style="font-size:10px;color:#D4954D;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin:0 0 2px 0;">Total Favorit</p>
                                <p style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:#F2F5E2;margin:0;line-height:1;">{{ $bookmarks->count() }}</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <span style="font-size:24px;">📅</span>
                            <div>
                                <p style="font-size:10px;color:#D4954D;text-transform:uppercase;letter-spacing:0.1em;font-weight:600;margin:0 0 2px 0;">Terakhir Disimpan</p>
                                <p style="font-size:12px;font-weight:600;color:#E3DEA4;margin:0;">{{ $bookmarks->first() ? $bookmarks->first()->created_at->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background:#fff;border:1px solid #E3DEA4;border-radius:4px;padding:16px;text-align:center;">
                    <p style="font-size:12px;color:#775533;margin:0 0 10px 0;font-family:'Cormorant Garamond',serif;font-style:italic;">Ingin membaca berita lainnya?</p>
                    <a href="{{ route('dashboard') }}" style="display:inline-block;padding:8px 20px;background:#290024;color:#F2F5E2;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;border-radius:3px;border:1px solid #D4954D;">Jelajahi →</a>
                </div>
            </div>
        </div>
    @endif
</div>
<footer style="background:#290024;border-top:2px solid #D4954D;margin-top:3rem;padding:1.5rem;text-align:center;">
    <p style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:#F2F5E2;letter-spacing:0.1em;margin:0 0 4px 0;">JURNAL AKSARA</p>
    <p style="font-size:10px;color:#775533;margin:0;">Portal Berita Indonesia Terpercaya · {{ now()->year }}</p>
</footer>
</body>
</html>