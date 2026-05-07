<x-sipadi-layout title="Hak Akses Pengguna">

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Akun Sistem</h2>
        <a href="{{ route('pengguna.create') }}" style="background: var(--color-primary); color: black; padding: 8px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="ph-bold ph-plus"></i> Tambah Pengguna
        </a>
    </div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr style="border-bottom: 2px solid var(--color-border);">
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Username</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Role (Peran)</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Terdaftar Sejak</th>
                <th style="padding: 12px; text-align: right; font-size: 13px; color: var(--color-muted);">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penggunas as $pengguna)
            <tr style="border-bottom: 1px solid var(--color-border); transition: background .2s;">
                <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--color-bg); display: flex; align-items: center; justify-content: center; font-size: 12px; color: var(--color-primary);">
                            {{ strtoupper(substr($pengguna->username, 0, 1)) }}
                        </div>
                        {{ $pengguna->username }}
                        @if($pengguna->id == session('pengguna_id'))
                            <span style="font-size: 10px; background: #E8F5EE; color: var(--color-primary); padding: 2px 6px; border-radius: 4px; margin-left: 5px;">Anda</span>
                        @endif
                    </div>
                </td>
                <td style="padding: 12px; font-size: 14px;">
                    @php
                        $roleColors = [
                            'ketua' => ['#FEF0EF', 'var(--color-danger)'],
                            'staf_produksi' => ['#E8F5EE', 'var(--color-primary)'],
                            'staf_penjualan' => ['#EBF5FB', 'var(--color-info)'],
                            'staf_keuangan' => ['#FEF9EE', 'var(--color-warning)'],
                        ];
                        $color = $roleColors[$pengguna->role] ?? ['#F4F6F9', '#6B7A8D'];
                    @endphp
                    <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; background: {{ $color[0] }}; color: {{ $color[1] }};">
                        {{ ucwords(str_replace('_', ' ', $pengguna->role)) }}
                    </span>
                </td>
                <td style="padding: 12px; font-size: 13px; color: var(--color-muted);">{{ \Carbon\Carbon::parse($pengguna->created_at)->format('d M Y') }}</td>
                <td style="padding: 12px; text-align: right;">
                    <div style="display: flex; gap: 6px; justify-content: flex-end;">
                        <a href="{{ route('pengguna.edit', $pengguna) }}" title="Edit" style="width: 32px; height: 32px; border-radius: 8px; background: var(--color-bg); color: var(--color-text); display: flex; align-items: center; justify-content: center; text-decoration: none;">
                            <i class="ph-bold ph-pencil-simple"></i>
                        </a>
                        @if($pengguna->id != session('pengguna_id'))
                        <form method="POST" action="{{ route('pengguna.destroy', $pengguna) }}">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus" style="width: 32px; height: 32px; border-radius: 8px; border: none; background: #FEF0EF; color: var(--color-danger); cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-sipadi-layout>
