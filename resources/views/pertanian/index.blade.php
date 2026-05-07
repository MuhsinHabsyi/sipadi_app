<x-sipadi-layout title="Data Pertanian & Bibit">

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Lahan & Alokasi Bibit Petani</h2>
        <a href="{{ route('pertanian.create') }}" style="background: var(--color-primary); color: black; padding: 8px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="ph-bold ph-plus"></i> Tambah Data Baru
        </a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="border-bottom: 2px solid var(--color-border);">
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">ID</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Nama Petani</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Luas Lahan (tumbak)</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Alokasi Bibit Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petanis as $petani)
            <tr style="border-bottom: 1px solid var(--color-border); transition: background .2s;">
                <td style="padding: 12px; font-size: 14px; color: var(--color-text);">#{{ $petani->id }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">{{ $petani->nama_petani }}</td>
                <td style="padding: 12px; font-size: 14px; color: var(--color-text);">{{ $petani->luas_lahan }}</td>
                <td style="padding: 12px; font-size: 14px; color: var(--color-text);">
                    @if($petani->alokasiBibits->count() > 0)
                        @php $latestBibit = $petani->alokasiBibits->sortByDesc('created_at')->first(); @endphp
                        <span style="display: block;">{{ $latestBibit->jumlah_bibit }} pack</span>
                        <span style="font-size: 11px; color: var(--color-muted);">Musim: {{ $latestBibit->musim_tanam }}</span>
                    @else
                        <span style="color: var(--color-muted); font-style: italic;">Belum ada alokasi</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 40px; text-align: center; color: var(--color-muted);">
                    <i class="ph-bold ph-plant" style="font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                    Belum ada data petani.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

</x-sipadi-layout>
