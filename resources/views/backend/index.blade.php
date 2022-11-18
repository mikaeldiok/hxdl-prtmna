@extends('backend.layouts.app')

@section('title') @lang("Dashboard") @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs/>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title mb-0">@lang("Welcome to", ['name'=>config('app.name')])</h4>
                <div class="small text-muted">{{ date_today() }}</div>
            </div>
        </div>
        <hr>

        <!-- Dashboard Content Area -->
        @php
            $day = get_today();
        @endphp
        <div class="row">
            <div class="col-sm-8">
                Pengawas: {{$day->pengawas ?? "Pengawas belum memasukkan nama, jika anda pengawas silakan klik link berikut untuk mengisi nama: "}} 
                @if(!$day->pengawas)
                    <a href='{{route("backend.days.pengawasLogin")}}'>ISI NAMA PENGAWAS</a>
                @endif
            </div>
        </div>
        <!-- / Dashboard Content Area -->

    </div>
</div>
@endsection
