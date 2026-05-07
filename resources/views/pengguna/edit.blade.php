<x-sipadi-layout title="Edit Pengguna">

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Edit Data Pengguna</h2>
    </div>

    <form method="POST" action="{{ route('pengguna.update', $pengguna) }}">
        @csrf @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Username</label>
            <input type="text" name="username" value="{{ old('username', $pengguna->username) }}" required autofocus
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            @error('username') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Kata Sandi (Opsional)</label>
            <input type="password" name="password" minlength="6"
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            <span style="color: var(--color-muted); font-size: 11px; margin-top: 4px; display: block;">Biarkan kosong jika tidak ingin mengubah kata sandi.</span>
            @error('password') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Role (Peran)</label>
            <select name="role" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="ketua" {{ old('role', $pengguna->role) == 'ketua' ? 'selected' : '' }}>Ketua Kelompok Tani</option>
                <option value="staf_produksi" {{ old('role', $pengguna->role) == 'staf_produksi' ? 'selected' : '' }}>Staf Produksi</option>
                <option value="staf_penjualan" {{ old('role', $pengguna->role) == 'staf_penjualan' ? 'selected' : '' }}>Staf Penjualan</option>
                <option value="staf_keuangan" {{ old('role', $pengguna->role) == 'staf_keuangan' ? 'selected' : '' }}>Staf Keuangan</option>
            </select>
            @error('role') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('pengguna.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
            <button type="submit" style="padding: 10px 16px; background: var(--color-primary); color: black; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">Perbarui Pengguna</button>
        </div>
    </form>
</div>

</x-sipadi-layout>
