<x-sipadi-layout title="Dashboard">

@push('styles')
<style>
/* ── Summary Cards ── */
.summary-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 22px;
}
.summary-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: transform .2s, box-shadow .2s;
}
.summary-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.09); }
.summary-card-top { display: flex; align-items: center; justify-content: space-between; }
.summary-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 21px;
}
.icon-green  { background: #E8F5EE; color: #2D6A4F; }
.icon-blue   { background: #EBF5FB; color: #2471A3; }
.icon-orange { background: #FEF9EE; color: #D4A017; }
.icon-red    { background: #FEF0EF; color: #C0392B; }
.summary-badge {
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 20px;
}
.badge-up   { background: #E8F5EE; color: #2D6A4F; }
.badge-down { background: #FEF0EF; color: #C0392B; }
.badge-neu  { background: #F0F4F8; color: #6B7A8D; }
.summary-value { font-size: 26px; font-weight: 800; color: #1A2332; letter-spacing: -1px; }
.summary-label { font-size: 12.5px; color: #6B7A8D; font-weight: 500; }

/* ── Middle Row ── */
.middle-row {
    display: grid;
    grid-template-columns: 65% 1fr;
    gap: 18px;
}

/* ── Activity Card ── */
.activity-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}
.card-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 18px;
}
.card-head-title { font-size: 14.5px; font-weight: 700; color: #1A2332; }
.card-head-action {
    font-size: 12.5px; font-weight: 600; color: #2D6A4F;
    text-decoration: none; padding: 5px 12px;
    border-radius: 8px; background: #E8F5EE;
    transition: background .2s;
}
.card-head-action:hover { background: #d0eddb; }

.activity-table { width: 100%; border-collapse: collapse; }
.activity-table th {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: #6B7A8D;
    padding: 0 12px 10px 12px; text-align: left;
    border-bottom: 1px solid #E8ECF0;
}
.activity-table td {
    padding: 13px 12px; font-size: 13.5px;
    border-bottom: 1px solid #F4F6F9;
    color: #1A2332;
    vertical-align: middle;
}
.activity-table tr:last-child td { border-bottom: none; }
.activity-table tr:hover td { background: #FAFCFB; }

.activity-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: #fff;
    flex-shrink: 0;
}
.av-green  { background: linear-gradient(135deg,#2D6A4F,#52B788); }
.av-blue   { background: linear-gradient(135deg,#1A5276,#2E86C1); }
.av-orange { background: linear-gradient(135deg,#9A6A00,#D4A017); }
.av-red    { background: linear-gradient(135deg,#7B241C,#C0392B); }
.av-teal   { background: linear-gradient(135deg,#0E6655,#1ABC9C); }

.person-cell { display: flex; align-items: center; gap: 10px; }
.person-name { font-size: 13.5px; font-weight: 600; color: #1A2332; }
.person-sub  { font-size: 11.5px; color: #6B7A8D; }

.status-pill {
    display: inline-block;
    padding: 3px 10px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600;
}
.pill-selesai   { background: #E8F5EE; color: #2D6A4F; }
.pill-menunggu  { background: #FEF9EE; color: #D4A017; }
.pill-batal     { background: #FEF0EF; color: #C0392B; }

/* ── Weather Card ── */
.weather-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.weather-main {
    background: linear-gradient(135deg,#1B4332,#2D6A4F);
    border-radius: 12px;
    padding: 22px;
    color: #fff;
    text-align: center;
}
.weather-icon-big { font-size: 54px; margin-bottom: 8px; display: block; }
.weather-temp { font-size: 38px; font-weight: 800; letter-spacing: -2px; }
.weather-desc { font-size: 13px; color: rgba(255,255,255,.75); margin-top: 4px; }
.weather-loc  { font-size: 11.5px; color: rgba(255,255,255,.55); margin-top: 2px; }

.weather-details {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
}
.weather-detail-item {
    background: #F4F6F9; border-radius: 10px;
    padding: 12px 14px;
    display: flex; align-items: center; gap: 10px;
}
.weather-detail-icon { font-size: 20px; color: #2D6A4F; }
.weather-detail-label { font-size: 11px; color: #6B7A8D; }
.weather-detail-value { font-size: 14px; font-weight: 700; color: #1A2332; }

.weather-forecast { margin-top: 4px; }
.forecast-title { font-size: 12px; font-weight: 700; color: #6B7A8D; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 10px; }
.forecast-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid #F4F6F9;
    font-size: 13px;
}
.forecast-row:last-child { border-bottom: none; }
.forecast-day { font-weight: 600; color: #1A2332; }
.forecast-icon { font-size: 18px; }
.forecast-temp { color: #6B7A8D; font-size: 12.5px; }

.weather-refresh {
    width: 100%;
    padding: 9px;
    border: 1.5px dashed #E0E7EE;
    border-radius: 8px;
    background: none;
    font-size: 12.5px;
    font-weight: 600;
    color: #6B7A8D;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: all .2s;
    font-family: 'Inter', sans-serif;
}
.weather-refresh:hover { border-color: #2D6A4F; color: #2D6A4F; background: #F0F7F4; }

/* ── Page header ── */
.page-header { margin-bottom: 22px; }
.page-greeting { font-size: 20px; font-weight: 800; color: #1A2332; letter-spacing: -.4px; }
.page-sub      { font-size: 13.5px; color: #6B7A8D; margin-top: 3px; }
</style>
@endpush

<div class="page-header">
    <div class="page-greeting">
        Selamat datang, {{ ucfirst(session('pengguna_username', 'Pengguna')) }} 👋
    </div>
    <div class="page-sub">Berikut ringkasan data operasional hari ini.</div>
</div>

<!-- ── 4 Summary Cards ── -->
<div class="summary-row">
    <div class="summary-card">
        <div class="summary-card-top">
            <div class="summary-icon icon-green"><i class="ph-bold ph-plant"></i></div>
            <span class="summary-badge badge-up">+3 musim</span>
        </div>
        <div class="summary-value">{{ $totalPetani ?? 0 }}</div>
        <div class="summary-label">Anggota Petani Aktif</div>
    </div>
    <div class="summary-card">
        <div class="summary-card-top">
            <div class="summary-icon icon-blue"><i class="ph-bold ph-warehouse"></i></div>
            <span class="summary-badge badge-neu">kg</span>
        </div>
        <div class="summary-value">{{ number_format($stokBeras ?? 0, 0, ',', '.') }}</div>
        <div class="summary-label">Stok Beras Tersedia</div>
    </div>
    <div class="summary-card">
        <div class="summary-card-top">
            <div class="summary-icon icon-orange"><i class="ph-bold ph-shopping-cart"></i></div>
            <span class="summary-badge badge-neu">{{ $transaksiMenunggu ?? 0 }} pending</span>
        </div>
        <div class="summary-value">{{ $totalTransaksi ?? 0 }}</div>
        <div class="summary-label">Total Transaksi</div>
    </div>
    <div class="summary-card">
        <div class="summary-card-top">
            <div class="summary-icon icon-red"><i class="ph-bold ph-currency-circle-dollar"></i></div>
            <span class="summary-badge badge-up">+Kas</span>
        </div>
        <div class="summary-value">Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</div>
        <div class="summary-label">Saldo Arus Kas</div>
    </div>
</div>

<!-- ── Middle Row: Activity 65% | Weather 35% ── -->
<div class="middle-row">

    <!-- Activity List -->
    <div class="activity-card">
        <div class="card-head">
            <span class="card-head-title">Aktivitas Transaksi Terbaru</span>
            <a href="{{ route('transaksi.index') }}" class="card-head-action">Lihat Semua</a>
        </div>
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru ?? [] as $t)
                <tr>
                    <td>
                        <div class="person-cell">
                            <div class="activity-avatar av-green">
                                {{ strtoupper(substr($t->pelanggan->nama ?? 'P', 0, 1)) }}
                            </div>
                            <div>
                                <div class="person-name">{{ $t->pelanggan->nama ?? '-' }}</div>
                                <div class="person-sub">ID #{{ $t->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_pesanan)->format('d M Y') }}</td>
                    <td>{{ number_format($t->jumlah_pesanan, 0, ',', '.') }} kg</td>
                    <td>
                        @if($t->status_pesanan === 'Selesai')
                            <span class="status-pill pill-selesai">Selesai</span>
                        @elseif($t->status_pesanan === 'Menunggu')
                            <span class="status-pill pill-menunggu">Menunggu</span>
                        @else
                            <span class="status-pill pill-batal">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:30px; color:#6B7A8D;">
                        <i class="ph-bold ph-inbox" style="font-size:28px; display:block; margin-bottom:8px; opacity:.4;"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse

                {{-- Demo rows when no data --}}
                @if(($transaksiTerbaru ?? collect())->isEmpty())
                @php
                $demos = [
                    ['name'=>'Budi Santoso','id'=>'001','tgl'=>'07 Mei 2026','qty'=>'250','status'=>'Selesai','av'=>'av-green'],
                    ['name'=>'Siti Rahayu','id'=>'002','tgl'=>'07 Mei 2026','qty'=>'500','status'=>'Menunggu','av'=>'av-blue'],
                    ['name'=>'Ahmad Fauzi','id'=>'003','tgl'=>'06 Mei 2026','qty'=>'100','status'=>'Selesai','av'=>'av-orange'],
                    ['name'=>'Dewi Lestari','id'=>'004','tgl'=>'06 Mei 2026','qty'=>'300','status'=>'Dibatalkan','av'=>'av-red'],
                    ['name'=>'Hendra Jaya','id'=>'005','tgl'=>'05 Mei 2026','qty'=>'150','status'=>'Selesai','av'=>'av-teal'],
                ];
                @endphp
                @foreach($demos as $d)
                <tr>
                    <td>
                        <div class="person-cell">
                            <div class="activity-avatar {{ $d['av'] }}">{{ substr($d['name'],0,1) }}</div>
                            <div>
                                <div class="person-name">{{ $d['name'] }}</div>
                                <div class="person-sub">ID #{{ $d['id'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $d['tgl'] }}</td>
                    <td>{{ $d['qty'] }} kg</td>
                    <td>
                        @if($d['status']==='Selesai') <span class="status-pill pill-selesai">Selesai</span>
                        @elseif($d['status']==='Menunggu') <span class="status-pill pill-menunggu">Menunggu</span>
                        @else <span class="status-pill pill-batal">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Weather Widget -->
    <div class="weather-card">
        <div class="card-head">
            <span class="card-head-title">Informasi Cuaca</span>
        </div>

        <div class="weather-main" id="weather-main">
            <i class="ph-bold ph-sun weather-icon-big" id="weather-icon"></i>
            <div class="weather-temp" id="weather-temp">28°C</div>
            <div class="weather-desc" id="weather-desc">Cerah Berawan</div>
            <div class="weather-loc"><i class="ph-bold ph-map-pin"></i> Lokasi Lahan, Jawa Barat</div>
        </div>

        <div class="weather-details">
            <div class="weather-detail-item">
                <i class="ph-bold ph-drop-half weather-detail-icon"></i>
                <div>
                    <div class="weather-detail-label">Kelembaban</div>
                    <div class="weather-detail-value" id="weather-humidity">75%</div>
                </div>
            </div>
            <div class="weather-detail-item">
                <i class="ph-bold ph-wind weather-detail-icon"></i>
                <div>
                    <div class="weather-detail-label">Angin</div>
                    <div class="weather-detail-value" id="weather-wind">12 km/j</div>
                </div>
            </div>
            <div class="weather-detail-item">
                <i class="ph-bold ph-cloud-rain weather-detail-icon"></i>
                <div>
                    <div class="weather-detail-label">Curah Hujan</div>
                    <div class="weather-detail-value" id="weather-rain">2 mm</div>
                </div>
            </div>
            <div class="weather-detail-item">
                <i class="ph-bold ph-eye weather-detail-icon"></i>
                <div>
                    <div class="weather-detail-label">Visibilitas</div>
                    <div class="weather-detail-value" id="weather-vis">10 km</div>
                </div>
            </div>
        </div>

        <div class="weather-forecast">
            <div class="forecast-title">Prakiraan 3 Hari</div>
            <div class="forecast-row">
                <span class="forecast-day">Besok</span>
                <i class="ph-bold ph-cloud-sun forecast-icon" style="color:#D4A017"></i>
                <span class="forecast-temp">26° / 31°</span>
            </div>
            <div class="forecast-row">
                <span class="forecast-day">Lusa</span>
                <i class="ph-bold ph-cloud-rain forecast-icon" style="color:#2471A3"></i>
                <span class="forecast-temp">24° / 29°</span>
            </div>
            <div class="forecast-row">
                <span class="forecast-day">3 Hari</span>
                <i class="ph-bold ph-sun forecast-icon" style="color:#D4A017"></i>
                <span class="forecast-temp">27° / 32°</span>
            </div>
        </div>

        <button class="weather-refresh" onclick="window.location.reload()">
            <i class="ph-bold ph-arrows-clockwise"></i>
            Muat Ulang Data Cuaca
        </button>
    </div>

</div>

@push('scripts')
<script>
// Auto-dismiss flash messages
setTimeout(() => {
    document.querySelectorAll('.flash-message').forEach(el => {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);
</script>
@endpush

</x-sipadi-layout>
