<x-toko-layout title="Pesanan Saya">

<section style="min-height: calc(100vh - 72px); padding: 60px 40px; background: var(--bg);">
    <div class="container" style="max-width: 900px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 28px; font-weight: 800;">Pesanan Saya</h1>
                <p style="font-size: 14px; color: var(--muted); margin-top: 4px;">Riwayat pesanan Anda pada toko SIPADI.</p>
            </div>
            <a href="{{ route('toko') }}" class="btn-outline">
                <i class="ph-bold ph-storefront"></i> Kembali ke Toko
            </a>
        </div>

        @if($transaksis->isEmpty())
            <div style="background: #fff; border-radius: var(--rl); border: 1px solid var(--border); padding: 60px; text-align: center;">
                <i class="ph-bold ph-package" style="font-size: 48px; color: var(--muted); opacity: .4; display: block; margin-bottom: 16px;"></i>
                <p style="font-size: 16px; font-weight: 500; color: var(--muted);">Anda belum memiliki pesanan.</p>
                <a href="{{ route('toko') }}#produk" style="color: var(--primary); font-weight: 600; margin-top: 8px; display: inline-block;">Mulai Belanja →</a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($transaksis as $trx)
                <div style="background: #fff; border-radius: var(--rl); border: 1px solid var(--border); overflow: hidden;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid var(--border); background: var(--bg);">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <span style="font-size: 13px; color: var(--muted);">Pesanan #{{ $trx->id }}</span>
                            <span style="font-size: 13px; color: var(--muted);">{{ \Carbon\Carbon::parse($trx->tanggal_pesanan)->format('d M Y') }}</span>
                        </div>
                        <div>
                            @if($trx->status_pesanan === 'Menunggu')
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #FEF9EE; color: var(--warning); border: 1px solid #FAD7A1;">
                                    <i class="ph-bold ph-clock"></i> Menunggu Konfirmasi
                                </span>
                            @elseif($trx->status_pesanan === 'Selesai')
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #E8F5EE; color: var(--primary); border: 1px solid #A8D5B5;">
                                    <i class="ph-bold ph-check-circle"></i> Selesai
                                </span>
                            @else
                                <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #FEF0EF; color: var(--danger); border: 1px solid #F5B7B1;">
                                    <i class="ph-bold ph-x-circle"></i> Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>
                    <div style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 15px; font-weight: 700;">{{ $trx->jenis_beras }}</div>
                            <div style="font-size: 13px; color: var(--muted); margin-top: 4px;">{{ $trx->jumlah_pesanan }} kg × Rp {{ number_format($trx->harga_satuan, 0, ',', '.') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 18px; font-weight: 800; color: var(--primary);">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

</x-toko-layout>
