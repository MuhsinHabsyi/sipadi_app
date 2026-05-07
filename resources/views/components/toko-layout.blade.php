@props(['title' => 'Toko Beras SIPADI'])
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — SIPADI</title>
    <meta name="description" content="Beras berkualitas langsung dari petani kelompok tani SIPADI">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #2D6A4F; --primary-lt: #52B788; --accent: #1B4332;
            --bg: #FAFBFC; --white: #FFFFFF; --border: #E8ECF0;
            --text: #1A2332; --muted: #6B7A8D;
            --danger: #C0392B; --warning: #D4A017;
            --r: 12px; --rl: 16px;
            --shadow: 0 4px 20px rgba(0,0,0,.06);
            --shadow-lg: 0 8px 40px rgba(0,0,0,.1);
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* NAVBAR */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,.92); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 40px; height: 72px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; }
        .nav-brand-ico {
            width: 40px; height: 40px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-lt));
            display: flex; align-items: center; justify-content: center;
        }
        .nav-brand-ico i { color: #fff; font-size: 20px; }
        .nav-brand-txt { font-size: 18px; font-weight: 800; color: var(--accent); letter-spacing: -.3px; }
        .nav-links { display: flex; gap: 32px; align-items: center; }
        .nav-links a {
            font-size: 14px; font-weight: 500; color: var(--muted);
            transition: color .2s; position: relative;
        }
        .nav-links a:hover { color: var(--primary); }
        .nav-right { display: flex; gap: 12px; align-items: center; }
        .nav-cart {
            position: relative; display: flex; align-items: center; gap: 6px;
            padding: 8px 16px; border-radius: 10px;
            background: #E8F5EE; color: var(--primary);
            font-size: 14px; font-weight: 600; cursor: pointer;
            border: none; font-family: inherit; transition: all .2s;
        }
        .nav-cart:hover { background: #d4ede0; }
        .nav-cart-badge {
            position: absolute; top: -4px; right: -4px;
            width: 20px; height: 20px; border-radius: 50%;
            background: var(--danger); color: #fff;
            font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-primary {
            padding: 10px 20px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-lt));
            color: #fff; font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; font-family: inherit; transition: all .2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: var(--shadow-lg); }
        .btn-outline {
            padding: 10px 20px; border-radius: 10px;
            background: transparent; color: var(--primary);
            font-size: 14px; font-weight: 600;
            border: 1.5px solid var(--primary); cursor: pointer;
            font-family: inherit; transition: all .2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-outline:hover { background: #E8F5EE; }

        /* FLASH MESSAGES */
        .flash-toko {
            position: fixed; top: 80px; right: 20px; z-index: 200;
            padding: 14px 20px; border-radius: var(--r);
            font-size: 14px; font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            animation: slideIn .3s ease;
            max-width: 400px;
        }
        .flash-toko.success { background: #E8F5EE; color: var(--primary); border: 1px solid #A8D5B5; }
        .flash-toko.error { background: #FEF0EF; color: var(--danger); border: 1px solid #F5B7B1; }
        @keyframes slideIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }

        /* SECTIONS */
        .section { padding: 100px 60px; }
        .section-title { font-size: 36px; font-weight: 800; text-align: center; margin-bottom: 12px; color: var(--text); }
        .section-subtitle { font-size: 16px; color: var(--muted); text-align: center; margin-bottom: 50px; max-width: 600px; margin-left: auto; margin-right: auto; }

        /* CONTAINER */
        .container { max-width: 1200px; margin: 0 auto; }

        /* FOOTER */
        .footer {
            background: var(--accent); color: rgba(255,255,255,.7);
            padding: 50px 60px; text-align: center; font-size: 14px;
        }
        .footer strong { color: #fff; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="{{ route('toko') }}" class="nav-brand">
        <div class="nav-brand-ico"><i class="ph-bold ph-plant"></i></div>
        <span class="nav-brand-txt">SIPADI</span>
    </a>

    <div class="nav-links">
        <a href="{{ route('toko') }}#home">Beranda</a>
        <a href="{{ route('toko') }}#produk">Produk</a>
        <a href="{{ route('toko') }}#tentang">Tentang Kami</a>
        <a href="{{ route('toko') }}#kontak">Kontak</a>
    </div>

    <div class="nav-right">
        @php $cartCount = count(session('cart', [])); @endphp
        <a href="{{ route('toko') }}#keranjang" class="nav-cart">
            <i class="ph-bold ph-shopping-cart" style="font-size: 18px;"></i> Keranjang
            @if($cartCount > 0)
                <span class="nav-cart-badge">{{ $cartCount }}</span>
            @endif
        </a>

        @if(session()->has('pelanggan_id'))
            <a href="{{ route('toko.pesanan') }}" class="btn-outline" style="padding: 8px 14px; font-size: 13px;">
                <i class="ph-bold ph-package"></i> Pesanan Saya
            </a>
            <form method="POST" action="{{ route('pelanggan.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-outline" style="padding: 8px 14px; font-size: 13px; color: var(--danger); border-color: var(--danger);">
                    <i class="ph-bold ph-sign-out"></i> Keluar
                </button>
            </form>
        @else
            <a href="{{ route('pelanggan.login') }}" class="btn-outline" style="padding: 8px 14px; font-size: 13px;">
                <i class="ph-bold ph-sign-in"></i> Masuk
            </a>
            <a href="{{ route('pelanggan.register') }}" class="btn-primary" style="padding: 8px 14px; font-size: 13px;">
                <i class="ph-bold ph-user-plus"></i> Daftar
            </a>
        @endif
    </div>
</nav>

<!-- FLASH -->
@if(session('success'))
<div class="flash-toko success" id="flash-toko">
    <i class="ph-bold ph-check-circle"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="flash-toko error" id="flash-toko-err">
    <i class="ph-bold ph-x-circle"></i> {{ session('error') }}
</div>
@endif

<div style="margin-top: 72px;">
    {{ $slot }}
</div>

<!-- FOOTER -->
<footer class="footer" id="kontak">
    <div style="margin-bottom: 16px;">
        <i class="ph-bold ph-plant" style="font-size: 32px; color: var(--primary-lt);"></i>
    </div>
    <div style="font-size: 18px; font-weight: 700; color: #fff; margin-bottom: 8px;">Kelompok Tani SIPADI</div>
    <div style="margin-bottom: 16px;">Jl. Persawahan No. 1, Desa Padi Sejahtera</div>
    <div style="display: flex; gap: 24px; justify-content: center; margin-bottom: 20px;">
        <span><i class="ph-bold ph-phone"></i> 0812-3456-7890</span>
        <span><i class="ph-bold ph-envelope-simple"></i> info@sipadi.co.id</span>
        <span><i class="ph-bold ph-map-pin"></i> Kabupaten Tangerang</span>
    </div>
    <div style="border-top: 1px solid rgba(255,255,255,.15); padding-top: 20px; font-size: 13px;">
        &copy; {{ date('Y') }} <strong>SIPADI</strong> — Sistem Informasi Produksi Padi dan Penjualan. All rights reserved.
    </div>
</footer>

<script>
    // Auto dismiss flash messages
    setTimeout(() => {
        ['flash-toko', 'flash-toko-err'].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.style.transition='opacity .4s'; el.style.opacity='0'; setTimeout(()=>el.remove(),400); }
        });
    }, 4000);

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href*="#"]').forEach(a => {
        a.addEventListener('click', function(e) {
            const hash = this.getAttribute('href').split('#')[1];
            if (hash) {
                const target = document.getElementById(hash);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
</script>
@stack('scripts')
</body>
</html>
