<x-sipadi-layout title="Tambah Pengguna Baru">

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Form Data Pengguna</h2>
    </div>

    <form method="POST" action="{{ route('pengguna.store') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Contoh: andi_produksi"
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            @error('username') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi</label>
            <input type="password" name="password" required minlength="6"
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            <span style="color: var(--color-muted); font-size: 11px; margin-top: 4px; display: block;">Minimal 6 karakter.</span>
            @error('password') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Role (Peran)</label>
            <select name="role" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Role --</option>
                <option value="ketua" {{ old('role') == 'ketua' ? 'selected' : '' }}>Ketua Kelompok Tani</option>
                <option value="staf_produksi" {{ old('role') == 'staf_produksi' ? 'selected' : '' }}>Staf Produksi</option>
                <option value="staf_penjualan" {{ old('role') == 'staf_penjualan' ? 'selected' : '' }}>Staf Penjualan</option>
                <option value="staf_keuangan" {{ old('role') == 'staf_keuangan' ? 'selected' : '' }}>Staf Keuangan</option>
            </select>
            @error('role') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('pengguna.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
            <button type="submit" style="padding: 10px 16px; background: var(--color-primary); color: black; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">Simpan Pengguna</button>
        </div>
    </form>
</div>

</x-sipadi-layout>
