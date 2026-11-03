<div class="report-card">
    <h3>{{ $item['id'] }} - {{ $item['lokasi'] }}</h3>
    <div class="meta">
        Pelapor: <strong>{{ $item['nama_pelapor'] }}</strong><br>
        Waktu: {{ $item['waktu'] }}<br>
        Tinggi genangan: <strong>{{ $item['tinggi_air'] }} cm</strong>
    </div>

    @if($item['tinggi_air'] < 30)
        <span class="status waspada">Waspada</span>
    @elseif($item['tinggi_air'] <= 70)
        <span class="status siaga">Siaga</span>
    @else
        <span class="status awas">Awas</span>
    @endif
</div>
