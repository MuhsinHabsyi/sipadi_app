<x-sipadi-layout title="Buat Pesanan Baru">

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Form Simulasi Pemesanan (Pelanggan)</h2>
    </div>

    <div style="background: #F0F7F4; border: 1px dashed var(--color-primary-lt); padding: 16px; border-radius: var(--radius-md); margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="font-size: 12px; font-weight: 700; color: var(--color-primary); text-transform: uppercase;">Stok Tersedia Saat Ini</div>
            <div style="font-size: 24px; font-weight: 800; color: var(--color-text);">{{ number_format($stok->ketersediaan_stok ?? 0, 1, ',', '.') }} kg</div>
        </div>
        <i class="ph-fill ph-warehouse" style="font-size: 40px; color: var(--color-primary-lt); opacity: 0.5;"></i>
    </div>

    <form method="POST" action="{{ route('transaksi.store') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Pilih Pelanggan</label>
            <select name="id_pelanggan" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}" {{ old('id_pelanggan') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }} (Kontak: {{ $p->kontak }})
                    </option>
                @endforeach
            </select>
            @error('id_pelanggan') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
            <div style="font-size: 12px; color: var(--color-muted); margin-top: 6px;">
                <em>Catatan: Di sistem nyata, pelanggan login melalui front-end publik.</em>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Jumlah Pesanan (kg)</label>
            <input type="number" step="1" name="jumlah_pesanan" value="{{ old('jumlah_pesanan') }}" required
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            @error('jumlah_pesanan') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('transaksi.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
            <button type="submit" style="padding: 10px 16px; background: var(--color-primary); color: white; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">Buat Pesanan</button>
        </div>
    </form>
</div>

</x-sipadi-layout>
