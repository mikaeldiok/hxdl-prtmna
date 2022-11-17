
<div class="d-flex justify-content-between mb-1">
    <div id="inspections-count">
        Menampilkan {{$inspections->count()}} dari {{ $inspections->total() > 100 ? "100+" : $inspections->total()}} Siswa
    </div>
    <div id="inspections-loader">
        {{$inspections->links()}}
    </div>
</div>
<div class="row">
@foreach($inspections as $inspection)
    <div class="col-3 pb-3 card-padding" style="margin-right: 0px;">
        @include('trip::frontend.inspections.inspection-card-big')
    </div>

@endforeach
</div>
<div class="d-flex justify-content-end">
    {{$inspections->links()}}
</div>

@push('after-scripts')
    @include("trip::frontend.inspections.dynamic-scripts")
@endpush
