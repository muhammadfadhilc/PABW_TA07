<div class="report-mini">
    <h3>TKT-{{ str_pad((string) $report['id'], 5, '0', STR_PAD_LEFT) }} · {{ $report['tipe_fasilitas'] }}</h3>
    <p><strong>Lokasi:</strong> {{ $report['lokasi'] }}</p>
    <p><strong>Tanggal:</strong> {{ $report['tanggal_lapor'] }}</p>
    <div class="row">
        @include('smartresident.partials.status-badge', ['status' => $report['status']])
        @isset($showDetail)
            <a class="btn btn-light" style="padding:7px 10px;" href="{{ route('admin.laporan.detail', $report['id']) }}">Detail</a>
        @endisset
    </div>
</div>
