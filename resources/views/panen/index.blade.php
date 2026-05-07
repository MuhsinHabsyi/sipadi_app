<x-sipadi-layout title="Data Panen">

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Hasil Panen Petani</h2>
        <a href="{{ route('panen.create') }}" style="background: var(--color-primary); color: black; padding: 8px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="ph-bold ph-plus"></i> Tambah Data Panen
        </a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="border-bottom: 2px solid var(--color-border);">
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">ID Panen</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Nama Petani</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Musim Tanam</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Total Panen (kg)</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Waktu Catat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($panens as $panen)
            <tr style="border-bottom: 1px solid var(--color-border); transition: background .2s;">
                <td style="padding: 12px; font-size: 14px; color: var(--color-text);">#{{ $panen->id }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">{{ $panen->petani->nama_petani ?? 'Tidak diketahui' }}</td>
                <td style="padding: 12px; font-size: 14px; color: var(--color-text);">{{ $panen->musim_tanam }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 700; color: var(--color-primary);">{{ number_format($panen->total_panen, 1, ',', '.') }} kg</td>
                <td style="padding: 12px; font-size: 13px; color: var(--color-muted);">{{ \Carbon\Carbon::parse($panen->created_at)->format('d M Y H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 40px; text-align: center; color: var(--color-muted);">
                    <i class="ph-bold ph-basket" style="font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                    Belum ada data panen yang dicatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-sipadi-layout>
