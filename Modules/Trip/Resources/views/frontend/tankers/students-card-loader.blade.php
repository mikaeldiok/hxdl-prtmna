
<div class="d-flex justify-content-between mb-1">
    <div id="tankers-count">
        Menampilkan {{$tankers->count()}} dari {{ $tankers->total() > 100 ? "100+" : $tankers->total()}} Siswa
    </div>
    <div id="tankers-loader">
        {{$tankers->links()}}
    </div>
</div>
<div class="row">
@foreach($tankers as $tanker)
    <div class="col-3 pb-3 card-padding" style="margin-right: 0px;">
        @include('vehicle::frontend.tankers.tanker-card-big')
    </div>

@endforeach
</div>
<div class="d-flex justify-content-end">
    {{$tankers->links()}}
</div>

@push('after-scripts')
    @include("vehicle::frontend.tankers.dynamic-scripts")
@endpush
