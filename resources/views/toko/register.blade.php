<x-toko-layout title="Daftar Akun">

<section style="min-height: calc(100vh - 72px); display: flex; align-items: center; justify-content: center; padding: 40px; background: linear-gradient(135deg, #f0f7f4 0%, #e8f5ee 100%);">
    <div style="background: #fff; width: 100%; max-width: 480px; padding: 40px; border-radius: 16px; box-shadow: var(--shadow-lg);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 48px; margin-bottom: 12px;">📝</div>
            <h1 style="font-size: 24px; font-weight: 800;">Buat Akun Baru</h1>
            <p style="font-size: 14px; color: var(--muted); margin-top: 6px;">Daftar untuk mulai berbelanja beras berkualitas.</p>
        </div>

        @if($errors->any())
            <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 16px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pelanggan.register.post') }}">
            @csrf

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap Anda"
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none;"
                       onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none;"
                       onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                           style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none;"
                           onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                           style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none;"
                           onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                </div>
            </div>

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Nomor Telepon</label>
                <input type="text" name="kontak" value="{{ old('kontak') }}" required placeholder="0812-xxxx-xxxx"
                       style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none;"
                       onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" required placeholder="Alamat pengiriman"
                          style="width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14px; font-family: inherit; outline: none; resize: vertical;"
                          onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">{{ old('alamat') }}</textarea>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                <i class="ph-bold ph-user-plus"></i> Daftar Sekarang
            </button>
        </form>

        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: var(--muted);">
            Sudah punya akun? <a href="{{ route('pelanggan.login') }}" style="color: var(--primary); font-weight: 600;">Masuk di sini</a>
        </div>
    </div>
</section>

</x-toko-layout>
