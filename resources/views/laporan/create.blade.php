<x-sipadi-layout title="Buat Laporan Baru">

<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h2 class="card-title">Pilih Musim Tanam</h2>
    </div>

    <form method="GET" action="{{ route('laporan.create') }}" style="display: flex; gap: 10px; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Musim Tanam (berdasarkan data bagi hasil)</label>
            <select name="musim_tanam" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Musim --</option>
                @foreach($listMusim as $m)
                    <option value="{{ $m }}" {{ $musim_tanam == $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="padding: 10px 20px; background: var(--color-primary); color: black; border: 1; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">Cek Kesiapan Data</button>
    </form>
</div>

@if($musim_tanam && !$laporanDraft)
<div style="background: #FEF0EF; color: var(--color-danger); border: 1px solid #F5B7B1; padding: 16px; border-radius: var(--radius-md); display: flex; gap: 10px;">
    <i class="ph-bold ph-warning-circle" style="font-size: 24px;"></i>
    <div style="font-size: 14px; font-weight: 500;">
        <strong>Data Belum Lengkap:</strong><br>
        Laporan tidak dapat dibuat karena data Panen atau Bagi Hasil untuk musim {{ $musim_tanam }} belum tersedia.
    </div>
</div>
@endif

@if($laporanDraft)
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid var(--color-border); padding-bottom: 16px; margin-bottom: 16px;">
        <h2 class="card-title">Pratinjau Integrasi Laporan: {{ $musim_tanam }}</h2>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
        <div style="background: var(--color-bg); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
            <div style="font-size: 12px; color: var(--color-muted); font-weight: 600; margin-bottom: 4px;">Total Hasil Panen</div>
            <div style="font-size: 20px; font-weight: 800; color: var(--color-text);">{{ number_format($laporanDraft['total_panen'], 1, ',', '.') }} kg</div>
        </div>
        <div style="background: var(--color-bg); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
            <div style="font-size: 12px; color: var(--color-muted); font-weight: 600; margin-bottom: 4px;">Jumlah Anggota Petani</div>
            <div style="font-size: 20px; font-weight: 800; color: var(--color-text);">{{ $laporanDraft['jumlah_petani'] }} Orang</div>
        </div>
        <div style="background: var(--color-bg); padding: 16px; border-radius: var(--radius-md); border: 1px solid var(--color-border);">
            <div style="font-size: 12px; color: var(--color-muted); font-weight: 600; margin-bottom: 4px;">Total Keuntungan Kelompok</div>
            <div style="font-size: 20px; font-weight: 800; color: var(--color-primary);">Rp {{ number_format($laporanDraft['total_keuntungan'], 0, ',', '.') }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('laporan.store') }}" style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid var(--color-border);">
        @csrf
        <input type="hidden" name="musim_tanam" value="{{ $musim_tanam }}">
        
        <a href="{{ route('laporan.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
        <button type="submit" style="padding: 10px 20px; background: var(--color-primary); color: black; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">
            Buat Laporan Draft
        </button>
    </form>
</div>
@endif

</x-sipadi-layout>
