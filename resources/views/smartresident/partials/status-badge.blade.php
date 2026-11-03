@if($status === 'Selesai')
    <span class="status status-selesai">Selesai</span>
@elseif($status === 'Diproses')
    <span class="status status-diproses">Diproses</span>
@else
    <span class="status status-menunggu">Menunggu</span>
@endif
