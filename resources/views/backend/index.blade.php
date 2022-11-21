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
            $checkDay = checkToday();
        @endphp
        <div class="row">
            <div class="col-sm-8">
                @if($checkDay)
                    @php
                        $day = getToday();
                    @endphp
                    @if(!$day->pengawas && Auth::user()->hasRole('pengawas'))
                        Pengawas: {{$day->pengawas ?? "Pengawas belum memasukkan nama, jika anda pengawas silakan klik link berikut untuk mengisi nama: "}} 
                        <a href='{{route("backend.days.pengawasLogin")}}'>ISI NAMA PENGAWAS</a>
                    @else
                        Pengawas: {{$day->pengawas ?? "Pengawas belum memasukkan nama"}} 
                    @endif
                    <br>
                    @if(!$day->hsse && Auth::user()->hasRole('hsse'))
                        HSSE: {{$day->hsse ?? "HSSE belum memasukkan nama, jika anda hsse silakan klik link berikut untuk mengisi nama: "}} 
                        <a href='{{route("backend.days.hssLogin")}}'>ISI NAMA HSSE</a>
                    @else
                        HSSE: {{$day->hsse ?? "HSSE belum memasukkan nama"}} 
                    @endif
                @endif
            </div>
        </div>
        <!-- / Dashboard Content Area -->

    </div>
</div>
@endsection
