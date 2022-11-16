@extends('vehicle::frontend.layouts.app')

@section('title') {{ __("Donatur") }} @endsection

@section('content')

<div class=" container z-2">
    <div class="row">
        <div class="col mb-5">
            <button class="btn btn-sm btn-warning my-2" onclick="history.back()"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
            <div class="card bg-white border-light shadow-soft no-gutters p-4">
                <div class="row">
                    <div class="col-3">
                        <img src="{{$tanker->photo ? asset($tanker->photo) : asset('img/default-avatar.jpg') }}" class="img-thumbnail img-fluid" alt="Tanker image">
                    </div>
                    <div class="col-9">
                        <h2 class="display-5 mt-2" style="font-size:45px"> {{$tanker->name}} </h2>
                        @php
                            $birthdate = Carbon\Carbon::createFromFormat('Y-m-d', $tanker->birth_date);
                            $age = $birthdate->diffInYears(Carbon\Carbon::now());
                        @endphp
                        <h3 class="display-6 mt-2"> {{$age}} Tahun</h3>
                        <h4 class="display-6 mt-2"> {{$tanker->major}} - {{$tanker->year_class}} </h4>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Gender </td>
                                    <td>: {{$tanker->gender}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Agama </td>
                                    <td>: {{$tanker->religion}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">TB/BB </td>
                                    <td>: {{$tanker->height}} cm / {{$tanker->weight}} kg</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Keahlian </td>
                                    <td>: {{$tanker->skills}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Sertifikasi </td>
                                    <td>: {{$tanker->certificate}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="my-3">
                            @if($tanker->available)
                                @if($tanker->checkBookedBy(auth()->user()->corporation->id ?? 0))
                                    <button class="btn btn-lg btn-danger choose-tanker" data-id="{{$tanker->id}}" id="choose-tanker-{{$tanker->id}}">BATAL</button>
                                @else
                                    <button class="btn btn-lg btn-success choose-tanker" data-id="{{$tanker->id}}" id="choose-tanker-{{$tanker->id}}">PILIH</button>
                                @endif
                            @else
                                <div class="btn-lg btn-secondary-o disabled" id="">Currently Not Available</div>
                                @if($tanker->checkBookedBy(auth()->user()->corporation->id ?? 0))
                                    <button class="btn btn-lg btn-danger choose-tanker with-warning" data-id="{{$tanker->id}}" id="choose-tanker-{{$tanker->id}}">BATAL</button>
                                @else
                                    <!--  -->
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push ('after-styles')
@endpush

@push ('after-scripts')

@include("vehicle::frontend.tankers.dynamic-scripts")

@endpush