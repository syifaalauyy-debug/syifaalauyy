<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Jurnal Aksara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { box-sizing:border-box; } body { margin:0;padding:0;background:#F2F5E2;font-family:'Source Sans 3',sans-serif; } a { text-decoration:none; }</style>
</head>
<body>

{{-- NAVBAR ADMIN --}}
<nav style="background:#290024;border-bottom:3px solid #D4954D;position:sticky;top:0;z-index:100;box-shadow:0 2px 16px rgba(41,0,36,0.4);">
    <div style="max-width:1280px;margin:0 auto;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:58px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="display:flex;flex-direction:column;align-items:flex-start;line-height:1;">
                <span style="font-family:'Source Sans 3',sans-serif;font-size:9px;font-weight:700;letter-spacing:0.25em;text-transform:uppercase;color:#D4954D;margin-bottom:1px;">Jurnal</span>
                <span style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:900;color:#F2F5E2;letter-spacing:0.05em;line-height:1;">AKSARA</span>
            </div>
            <span style="background:rgba(212,149,77,0.2);color:#D4954D;font-size:10px;font-weight:700;padding:3px 10px;border-radius:3px;border:1px solid rgba(212,149,77,0.4);text-transform:uppercase;letter-spacing:0.1em;">
                Panel Admin
            </span>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('dashboard') }}"
               style="color:#E3DEA4;font-size:11px;font-weight:700;padding:6px 14px;border-radius:3px;border:1px solid rgba(227,222,164,0.3);text-transform:uppercase;letter-spacing:0.05em;"
               onmouseover="this.style.background='rgba(212,149,77,0.2)'" onmouseout="this.style.background='transparent'">
                ← Beranda
            </a>
            <span style="color:#D4954D;font-size:11px;font-weight:600;">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                        style="color:#F2F5E2;font-size:11px;font-weight:700;padding:6px 14px;border-radius:3px;border:1px solid rgba(212,149,77,0.4);background:rgba(212,149,77,0.15);cursor:pointer;text-transform:uppercase;letter-spacing:0.05em;">
                    Keluar →
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- CONTENT --}}
<div style="max-width:1280px;margin:0 auto;padding:2rem 1.5rem;">

    {{-- Page header --}}
    <div style="margin-bottom:2rem;border-bottom:1px solid #E3DEA4;padding-bottom:1rem;">
        <p style="font-family:'Cormorant Garamond',serif;font-size:11px;color:#775533;font-style:italic;letter-spacing:0.15em;margin:0 0 4px 0;">{{ now()->translatedFormat('l, d F Y') }}</p>
        <h1 style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:900;color:#290024;letter-spacing:0.05em;margin:0;">Dashboard Administrator</h1>
    </div>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;margin-bottom:2rem;">

        <div style="background:#fff;border:1px solid #E3DEA4;border-radius:4px;padding:1.5rem;box-shadow:0 1px 4px rgba(119,85,51,0.1);display:flex;align-items:center;gap:16px;">
            <div style="width:52px;height:52px;border-radius:3px;background:#290024;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;border:2px solid #D4954D;">👥</div>
            <div>
                <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#775533;margin:0 0 4px 0;">Total Pengguna</p>
                <p style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:#290024;line-height:1;margin:0;">{{ $totalUsers }}</p>
            </div>
        </div>

        <div style="background:#fff;border:1px solid #E3DEA4;border-radius:4px;padding:1.5rem;box-shadow:0 1px 4px rgba(119,85,51,0.1);display:flex;align-items:center;gap:16px;">
            <div style="width:52px;height:52px;border-radius:3px;background:#775533;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;border:2px solid #D4954D;">💬</div>
            <div>
                <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#775533;margin:0 0 4px 0;">Total Komentar</p>
                <p style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:#775533;line-height:1;margin:0;">{{ $totalKomentar }}</p>
            </div>
        </div>

        <div style="background:#fff;border:1px solid #E3DEA4;border-radius:4px;padding:1.5rem;box-shadow:0 1px 4px rgba(119,85,51,0.1);display:flex;align-items:center;gap:16px;">
            <div style="width:52px;height:52px;border-radius:3px;background:#D4954D;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;border:2px solid #775533;">⭐</div>
            <div>
                <p style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#775533;margin:0 0 4px 0;">Total Bookmark</p>
                <p style="font-family:'Playfair Display',serif;font-size:2.2rem;font-weight:700;color:#D4954D;line-height:1;margin:0;">{{ $totalBookmark }}</p>
            </div>
        </div>

    </div>

    {{-- Section title --}}
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:1rem;">
        <div style="width:4px;height:18px;background:#D4954D;border-radius:1px;"></div>
        <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#290024;">Daftar Pengguna Aktif</span>
        <div style="flex:1;height:1px;background:#E3DEA4;margin-left:4px;"></div>
    </div>

    {{-- Tabel --}}
    <div style="background:#fff;border:1px solid #E3DEA4;border-radius:4px;overflow:hidden;box-shadow:0 1px 4px rgba(119,85,51,0.1);">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#290024;border-bottom:2px solid #D4954D;">
                    <th style="padding:12px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">#</th>
                    <th style="padding:12px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">Nama</th>
                    <th style="padding:12px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">Email</th>
                    <th style="padding:12px 16px;text-align:center;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">💬 Komentar</th>
                    <th style="padding:12px 16px;text-align:center;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">⭐ Bookmark</th>
                    <th style="padding:12px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">Bergabung</th>
                    <th style="padding:12px 16px;text-align:center;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.12em;color:#D4954D;font-family:'Source Sans 3',sans-serif;">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $i => $user)
                <tr style="border-bottom:1px solid #E3DEA4;background:{{ $loop->even ? '#F2F5E2' : '#fff' }};">
                    <td style="padding:12px 16px;font-size:12px;color:#775533;font-family:'Cormorant Garamond',serif;font-style:italic;">{{ $i+1 }}</td>
                    <td style="padding:12px 16px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:3px;background:#290024;border:1px solid #D4954D;display:flex;align-items:center;justify-content:center;color:#D4954D;font-weight:700;font-size:13px;flex-shrink:0;font-family:'Playfair Display',serif;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span style="font-size:13px;font-weight:600;color:#290024;font-family:'Source Sans 3',sans-serif;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="padding:12px 16px;font-size:12px;color:#775533;font-family:'Source Sans 3',sans-serif;">{{ $user->email }}</td>
                    <td style="padding:12px 16px;text-align:center;">
                        <span style="background:#E3DEA4;border:1px solid #D4954D;border-radius:3px;padding:3px 12px;font-size:12px;font-weight:700;color:#290024;font-family:'Playfair Display',serif;">
                            {{ $user->comments_count }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;text-align:center;">
                        <span style="background:#D4954D;border-radius:3px;padding:3px 12px;font-size:12px;font-weight:700;color:#fff;font-family:'Playfair Display',serif;">
                            {{ $user->bookmarks_count }}
                        </span>
                    </td>
                    <td style="padding:12px 16px;font-size:12px;color:#775533;font-family:'Cormorant Garamond',serif;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="padding:12px 16px;text-align:center;">
                        @if($user->is_admin)
                            <span style="background:#290024;color:#D4954D;border:1px solid #D4954D;border-radius:3px;padding:3px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Admin</span>
                        @else
                            <span style="background:#E3DEA4;color:#775533;border:1px solid #D4954D;border-radius:3px;padding:3px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">User</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<footer style="background:#290024;border-top:2px solid #D4954D;margin-top:3rem;padding:1.5rem;text-align:center;">
    <p style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:#F2F5E2;letter-spacing:0.1em;margin:0 0 4px 0;">JURNAL AKSARA</p>
    <p style="font-size:10px;color:#775533;margin:0;">Portal Berita Indonesia Terpercaya · {{ now()->year }}</p>
</footer>

</body>
</html>