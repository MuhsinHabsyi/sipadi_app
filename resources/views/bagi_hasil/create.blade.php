<x-sipadi-layout title="Kalkulasi Pembagian Hasil">

<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <h2 class="card-title">Pilih Musim Tanam</h2>
    </div>

    <form method="GET" action="{{ route('bagi-hasil.create') }}" style="display: flex; gap: 10px; align-items: flex-end;">
        <div style="flex: 1;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px;">Musim Tanam (berdasarkan data panen)</label>
            <select name="musim_tanam" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--color-border); border-radius: var(--radius-md); font-family: inherit; font-size: 14px; background: #fff;">
                <option value="">-- Pilih Musim --</option>
                @foreach($listMusim as $m)
                    <option value="{{ $m }}" {{ $musim_tanam == $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="padding: 10px 20px; background: var(--color-primary); color: black; border: 1; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;"></i> Lihat Pratinjau</button>
    </form>
</div>

@if(session('error') || $errors->any())
<div style="background: #FEF0EF; color: var(--color-danger); border: 1px solid #F5B7B1; padding: 16px; border-radius: var(--radius-md); display: flex; gap: 10px; margin-bottom: 24px;">
    <i class="ph-bold ph-warning-circle" style="font-size: 24px;"></i>
    <div style="font-size: 14px; font-weight: 500;">
        <strong>Kesalahan:</strong><br>
        {{ session('error') ?? $errors->first() }}
    </div>
</div>
@endif

@if($error)
<div style="background: #FEF0EF; color: var(--color-danger); border: 1px solid #F5B7B1; padding: 16px; border-radius: var(--radius-md); display: flex; gap: 10px; margin-bottom: 24px;">
    <i class="ph-bold ph-warning-circle" style="font-size: 24px;"></i>
    <div style="font-size: 14px; font-weight: 500;">
        <strong>Tidak dapat melakukan kalkulasi:</strong><br>
        {{ $error }}
    </div>
</div>
@endif

@if($previewData)
<div class="card">
    <div class="card-header" style="border-bottom: 1px solid var(--color-border); padding-bottom: 16px; margin-bottom: 16px;">
        <h2 class="card-title">Pratinjau Pembagian Hasil: {{ $musim_tanam }}</h2>
        <div style="font-size: 14px; font-weight: 600; color: var(--color-primary); background: #E8F5EE; padding: 6px 12px; border-radius: var(--radius-md);">
            Total Keuntungan Kelompok: Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}
        </div>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid var(--color-border);">
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Nama Petani</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: var(--color-muted);">Total Panen (kg)</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: var(--color-muted);">Proporsi Panen (%)</th>
                <th style="padding: 12px; text-align: right; font-size: 13px; color: var(--color-muted);">Alokasi Keuntungan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($previewData as $row)
            <tr style="border-bottom: 1px solid var(--color-border);">
                <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">{{ $row['nama_petani'] }}</td>
                <td style="padding: 12px; font-size: 14px; text-align: center; color: var(--color-text);">{{ $row['total_panen'] }}</td>
                <td style="padding: 12px; font-size: 14px; text-align: center; color: var(--color-text);">{{ $row['proporsi_panen'] }}%</td>
                <td style="padding: 12px; font-size: 14px; text-align: right; font-weight: 600; color: var(--color-primary);">Rp {{ number_format($row['alokasi_keuntungan'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('bagi-hasil.store') }}" style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid var(--color-border);">
        @csrf
        <input type="hidden" name="musim_tanam" value="{{ $musim_tanam }}">
        <input type="hidden" name="total_keuntungan" value="{{ $totalKeuntungan }}">
        <input type="hidden" name="data" value="{{ json_encode($previewData) }}">
        
        <a href="{{ route('bagi-hasil.index') }}" style="padding: 10px 16px; background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); border-radius: var(--radius-md); font-size: 14px; font-weight: 600; text-decoration: none;">Batal</a>
        <button type="submit" style="padding: 10px 20px; background: var(--color-primary); color: black; border: none; border-radius: var(--radius-md); font-size: 14px; font-weight: 600; cursor: pointer;">
            Konfirmasi & Simpan Pembagian Hasil
        </button>
    </form>
</div>
@endif

</x-sipadi-layout>
