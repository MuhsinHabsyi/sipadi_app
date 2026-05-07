<x-sipadi-layout title="Catat Arus Kas">

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Form Pencatatan Transaksi Keuangan</h2>
    </div>

    <form method="POST" action="{{ route('keuangan.store') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Tanggal Transaksi</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            @error('tanggal') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Musim Tanam</label>
            <input type="text" name="musim_tanam" value="{{ old('musim_tanam', date('Y').'-Ganjil') }}" list="musim-list" required placeholder="Contoh: 2024-Ganjil"
                   style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            <datalist id="musim-list">
                @foreach($listMusim as $m)
                    <option value="{{ $m }}">
                @endforeach
            </datalist>
            @error('musim_tanam') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Jenis Transaksi</label>
            <select name="jenis_transaksi" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Jenis --</option>
                <option value="pemasukan" {{ old('jenis_transaksi') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ old('jenis_transaksi') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            @error('jenis_transaksi') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Nominal (Rp)</label>
            <div style="position: relative;">
                <span style="position: absolute; left: 14px; top: 10px; color: var(--color-muted); font-weight: 600;">Rp</span>
                <input type="number" step="1" name="nominal" value="{{ old('nominal') }}" required min="1"
                       style="width: 100%; padding: 10px 14px 10px 45px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px;">
            </div>
            @error('nominal') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Keterangan</label>
            <textarea name="keterangan" rows="3" required placeholder="Contoh: Pembelian pupuk, Pembayaran hasil penjualan..."
                      style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; resize: vertical;">{{ old('keterangan') }}</textarea>
            @error('keterangan') <span style="color: var(--color-danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('keuangan.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
            <button type="submit" style="padding: 10px 16px; background: var(--color-primary); color: black; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">Simpan Transaksi</button>
        </div>
    </form>
</div>

</x-sipadi-layout>
