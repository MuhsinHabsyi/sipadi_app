<x-toko-layout title="Masuk">

<section style="min-height: calc(100vh - 72px); display: flex; align-items: center; justify-content: center; padding: 40px; background: linear-gradient(135deg, #f0f7f4 0%, #e8f5ee 100%);">
    <div style="background: #fff; width: 100%; max-width: 440px; padding: 40px; border-radius: 16px; box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 48px; margin-bottom: 12px;">🛒</div>
            <h1 style="font-size: 24px; font-weight: 800;">Masuk ke Akun Anda</h1>
            <p style="font-size: 14px; color: var(--muted); margin-top: 6px;">Masuk untuk melanjutkan pembelian beras.</p>
        </div>

        @if($errors->any())
            <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="ph-bold ph-warning-circle" style="font-size: 18px;"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('pelanggan.login.post') }}">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; transition: all .2s;"
                       onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; transition: all .2s;"
                       onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                <i class="ph-bold ph-sign-in"></i> Masuk
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: var(--muted);">
            Belum punya akun? <a href="{{ route('pelanggan.register') }}" style="color: var(--primary); font-weight: 600;">Daftar di sini</a>
        </div>
    </div>
</section>

</x-toko-layout>
