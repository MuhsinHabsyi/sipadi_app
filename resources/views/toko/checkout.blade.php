<x-toko-layout title="Checkout">

<section style="min-height: calc(100vh - 72px); padding: 60px 40px; background: var(--bg);">
    <div class="container" style="max-width: 800px;">

        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="font-size: 28px; font-weight: 800;">Checkout Pesanan</h1>
            <p style="font-size: 14px; color: var(--muted); margin-top: 6px;">Pastikan pesanan Anda sudah benar, lalu unggah bukti transfer.</p>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div style="background: #fff; border-radius: var(--rl); border: 1px solid var(--border); overflow: hidden; margin-bottom: 28px;">
            <div style="padding: 18px 20px; font-size: 15px; font-weight: 700; border-bottom: 1px solid var(--border); background: var(--bg);">
                <i class="ph-bold ph-receipt" style="color: var(--primary);"></i> Ringkasan Pesanan
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border);">
                        <th style="padding: 12px 16px; text-align: left; font-size: 13px; color: var(--muted);">Produk</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 13px; color: var(--muted);">Harga/kg</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 13px; color: var(--muted);">Jumlah</th>
                        <th style="padding: 12px 16px; text-align: right; font-size: 13px; color: var(--muted);">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 12px 16px; font-size: 14px; font-weight: 600;">{{ $item['nama'] }}</td>
                        <td style="padding: 12px 16px; text-align: center; font-size: 14px;">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td style="padding: 12px 16px; text-align: center; font-size: 14px;">{{ $item['jumlah'] }} kg</td>
                        <td style="padding: 12px 16px; text-align: right; font-size: 14px; font-weight: 600;">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #E8F5EE;">
                        <td colspan="3" style="padding: 14px 16px; font-size: 16px; font-weight: 700; text-align: right;">Total Pembayaran:</td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 20px; font-weight: 800; color: var(--primary);">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Info Transfer --}}
        <div style="background: #fff; border-radius: var(--rl); border: 1px solid var(--border); padding: 24px; margin-bottom: 28px;">
            <div style="font-size: 15px; font-weight: 700; margin-bottom: 16px;">
                <i class="ph-bold ph-bank" style="color: var(--primary);"></i> Informasi Rekening Transfer
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div style="padding: 16px; background: var(--bg); border-radius: var(--r); border: 1px solid var(--border);">
                    <div style="font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Bank BRI</div>
                    <div style="font-size: 18px; font-weight: 700; font-family: monospace;">1234-5678-9012-3456</div>
                    <div style="font-size: 13px; color: var(--muted); margin-top: 4px;">a.n. Kelompok Tani SIPADI</div>
                </div>
                <div style="padding: 16px; background: var(--bg); border-radius: var(--r); border: 1px solid var(--border);">
                    <div style="font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Bank BCA</div>
                    <div style="font-size: 18px; font-weight: 700; font-family: monospace;">9876-5432-1098-7654</div>
                    <div style="font-size: 13px; color: var(--muted); margin-top: 4px;">a.n. Kelompok Tani SIPADI</div>
                </div>
            </div>
        </div>

        {{-- Upload Bukti Transfer --}}
        <div style="background: #fff; border-radius: var(--rl); border: 1px solid var(--border); padding: 24px;">
            <div style="font-size: 15px; font-weight: 700; margin-bottom: 16px;">
                <i class="ph-bold ph-upload-simple" style="color: var(--primary);"></i> Unggah Bukti Transfer
            </div>

            @if($errors->any())
                <div style="background: #FEF2F2; color: #991B1B; border: 1px solid #FCA5A5; padding: 12px; border-radius: 10px; font-size: 13px; margin-bottom: 16px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('toko.checkout.process') }}" enctype="multipart/form-data">
                @csrf
                <div style="border: 2px dashed var(--border); border-radius: var(--r); padding: 40px; text-align: center; margin-bottom: 20px; transition: all .2s; cursor: pointer;" id="drop-area"
                     onclick="document.getElementById('bukti-input').click()">
                    <i class="ph-bold ph-image" style="font-size: 40px; color: var(--muted); display: block; margin-bottom: 10px;"></i>
                    <div style="font-size: 14px; font-weight: 600; margin-bottom: 4px;" id="file-label">Klik untuk memilih foto bukti transfer</div>
                    <div style="font-size: 12px; color: var(--muted);">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                    <input type="file" name="bukti_transfer" id="bukti-input" accept="image/jpg,image/jpeg,image/png" required
                           style="display: none;" onchange="previewFile(this)">
                </div>
                <div id="preview-img" style="display: none; text-align: center; margin-bottom: 20px;">
                    <img id="preview-src" src="" alt="Preview" style="max-height: 200px; border-radius: var(--r); border: 1px solid var(--border);">
                </div>

                <div style="display: flex; gap: 12px; justify-content: flex-end;">
                    <a href="{{ route('toko') }}#keranjang" class="btn-outline" style="padding: 12px 20px;">
                        <i class="ph-bold ph-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-primary" style="padding: 12px 28px; font-size: 15px;">
                        <i class="ph-bold ph-check-circle"></i> Konfirmasi & Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>

@push('scripts')
<script>
    function previewFile(input) {
        const label = document.getElementById('file-label');
        const preview = document.getElementById('preview-img');
        const img = document.getElementById('preview-src');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            const reader = new FileReader();
            reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush

</x-toko-layout>
