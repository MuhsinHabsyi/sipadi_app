<x-sipadi-layout title="Manajemen Transaksi">

<div style="display: grid; grid-template-columns: 1fr 3fr; gap: 20px;">
    
    <!-- Left panel for stock -->
    <div class="card" style="height: fit-content;">
        <div class="card-header" style="margin-bottom: 0;">
            <h3 class="card-title">Ketersediaan Stok Beras</h3>
        </div>
        <div style="text-align: center; padding: 30px 10px;">
            <i class="ph-fill ph-warehouse" style="font-size: 64px; color: var(--color-primary-lt); margin-bottom: 10px;"></i>
            <div style="font-size: 36px; font-weight: 800; color: var(--color-text); letter-spacing: -1px;">
                {{ number_format($stok->ketersediaan_stok ?? 0, 1, ',', '.') }}
            </div>
            <div style="font-size: 14px; color: var(--color-muted); font-weight: 500;">Kilogram (kg)</div>
        </div>
    </div>

    <!-- Right panel for transactions list -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Daftar Pesanan & Transaksi</h2>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--color-border);">
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">ID</th>
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Pelanggan</th>
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Produk</th>
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Tanggal</th>
                    <th style="padding: 12px; text-align: left; font-size: 13px; color: var(--color-muted);">Jumlah</th>
                    <th style="padding: 12px; text-align: right; font-size: 13px; color: var(--color-muted);">Total</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; color: var(--color-muted);">Bukti</th>
                    <th style="padding: 12px; text-align: center; font-size: 13px; color: var(--color-muted);">Status</th>
                    <th style="padding: 12px; text-align: right; font-size: 13px; color: var(--color-muted);">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr style="border-bottom: 1px solid var(--color-border); transition: background .2s;">
                    <td style="padding: 12px; font-size: 14px; color: var(--color-text);">#{{ $t->id }}</td>
                    <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">{{ $t->pelanggan->nama ?? 'Tidak diketahui' }}</td>
                    <td style="padding: 12px; font-size: 13px; color: var(--color-text);">{{ $t->jenis_beras ?? '-' }}</td>
                    <td style="padding: 12px; font-size: 14px; color: var(--color-text);">{{ \Carbon\Carbon::parse($t->tanggal_pesanan)->format('d M Y') }}</td>
                    <td style="padding: 12px; font-size: 14px; font-weight: 600; color: var(--color-text);">{{ number_format($t->jumlah_pesanan, 0, ',', '.') }} kg</td>
                    <td style="padding: 12px; text-align: right; font-size: 14px; font-weight: 600; color: var(--color-primary);">Rp {{ number_format($t->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px; text-align: center;">
                        @if($t->bukti_transfer)
                            <a href="{{ asset('storage/' . $t->bukti_transfer) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #EBF5FB; color: #2980B9; text-decoration: none;" title="Lihat Bukti Transfer">
                                <i class="ph-bold ph-image"></i>
                            </a>
                        @else
                            <span style="color: var(--color-muted); font-size: 12px;">-</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @if($t->status_pesanan === 'Selesai')
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; background: #E8F5EE; color: var(--color-primary);">Selesai</span>
                        @elseif($t->status_pesanan === 'Menunggu')
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; background: #FEF9EE; color: var(--color-warning);">Menunggu</span>
                        @else
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; background: #FEF0EF; color: var(--color-danger);">Dibatalkan</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        @if($t->status_pesanan === 'Menunggu')
                            <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                <form method="POST" action="{{ route('transaksi.konfirmasi', $t) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Konfirmasi" style="width: 32px; height: 32px; border-radius: 8px; border: none; background: #E8F5EE; color: var(--color-primary); cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <i class="ph-bold ph-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('transaksi.batalkan', $t) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Batalkan" style="width: 32px; height: 32px; border-radius: 8px; border: none; background: #FEF0EF; color: var(--color-danger); cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                                        <i class="ph-bold ph-x"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <span style="color: var(--color-muted); font-size: 12px; font-style: italic;">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: var(--color-muted);">
                        <i class="ph-bold ph-shopping-cart" style="font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</x-sipadi-layout>
