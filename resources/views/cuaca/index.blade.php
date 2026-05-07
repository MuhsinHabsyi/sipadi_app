<x-sipadi-layout title="Informasi Cuaca">

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <h2 class="card-title">Pemantauan Cuaca Lahan Tani</h2>
        <a href="{{ route('cuaca.index') }}" style="background: var(--color-bg); color: var(--color-text); border: 1px solid var(--color-border); padding: 8px 16px; border-radius: var(--radius-md); text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <i class="ph-bold ph-arrows-clockwise"></i> Muat Ulang
        </a>
    </div>

    @if(isset($error_api))
        <div style="background: #FEF0EF; color: var(--color-danger); border: 1px solid #F5B7B1; padding: 16px; border-radius: var(--radius-md); text-align: center; margin-top: 20px;">
            <i class="ph-bold ph-warning-circle" style="font-size: 32px; display: block; margin-bottom: 8px;"></i>
            <strong>Gagal Memuat Cuaca</strong><br>
            {{ $error_api }}
        </div>
    @elseif(isset($weatherData))
        @php
            $current = $weatherData['current_weather'];
            $daily = $weatherData['daily'];
            
            // Map weathercode (WMO) to string/icon
            function mapWeather($code) {
                if ($code == 0) return ['Cerah', 'ph-sun', '#D4A017'];
                if ($code >= 1 && $code <= 3) return ['Cerah Berawan', 'ph-cloud-sun', '#D4A017'];
                if ($code >= 45 && $code <= 48) return ['Berkabut', 'ph-cloud-fog', '#6B7A8D'];
                if ($code >= 51 && $code <= 67) return ['Hujan Ringan', 'ph-cloud-rain', '#2471A3'];
                if ($code >= 71 && $code <= 77) return ['Salju', 'ph-snowflake', '#2471A3'];
                if ($code >= 80 && $code <= 82) return ['Hujan Lebat', 'ph-cloud-showers', '#1A5276'];
                if ($code >= 95 && $code <= 99) return ['Badai Petir', 'ph-cloud-lightning', '#5B2C6F'];
                return ['Tidak Diketahui', 'ph-cloud', '#6B7A8D'];
            }
            
            $currentMapped = mapWeather($current['weathercode']);
        @endphp

        <div style="background: linear-gradient(135deg, var(--color-accent), var(--color-primary)); border-radius: var(--radius-lg); padding: 40px; color: black; text-align: center; margin-top: 20px;">
            <i class="ph-fill {{ $currentMapped[1] }}" style="font-size: 80px; margin-bottom: 10px;"></i>
            <div style="font-size: 48px; font-weight: 800; letter-spacing: -2px; margin-bottom: 5px;">{{ $current['temperature'] }}&deg;C</div>
            <div style="font-size: 18px; font-weight: 500; opacity: 0.9;">{{ $currentMapped[0] }}</div>
            <div style="font-size: 14px; opacity: 0.7; margin-top: 8px;">
                <i class="ph-bold ph-wind"></i> Angin: {{ $current['windspeed'] }} km/h
            </div>
        </div>

        <div style="margin-top: 30px;">
            <h3 style="font-size: 16px; font-weight: 600; color: var(--color-text); margin-bottom: 15px;">Prakiraan 7 Hari Ke Depan</h3>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @for($i = 1; $i < 7; $i++)
                    @php
                        $dayMapped = mapWeather($daily['weathercode'][$i]);
                        $date = \Carbon\Carbon::parse($daily['time'][$i])->format('d M Y');
                    @endphp
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px; border-radius: var(--radius-md); background: var(--color-bg);">
                        <div style="width: 100px; font-weight: 600; color: var(--color-text); font-size: 14px;">{{ $date }}</div>
                        <div style="display: flex; align-items: center; gap: 10px; flex: 1;">
                            <i class="ph-fill {{ $dayMapped[1] }}" style="font-size: 24px; color: {{ $dayMapped[2] }};"></i>
                            <span style="font-size: 14px; color: var(--color-muted);">{{ $dayMapped[0] }}</span>
                        </div>
                        <div style="font-size: 14px; font-weight: 600; color: var(--color-text);">
                            {{ $daily['temperature_2m_max'][$i] }}&deg; <span style="color: var(--color-muted); font-weight: 400;">/ {{ $daily['temperature_2m_min'][$i] }}&deg;</span>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    @endif
</div>

</x-sipadi-layout>
