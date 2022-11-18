@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<div class="site-section border-top bg-dark">
    <div class="container">
      
    </div>
  </div> <!-- .site-section -->

  <div class="mx-2">
        <div class="card">
            <div class="card-body bg-light">

                <hr>

                <div class="row mt-4">
                    <div class="col">
                        {{ html()->form('POST', route("frontend.$module_name.store-part-1"))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}

                        @include ("trip::frontend.$module_name.form-part-1")
                        
                        <div id="show-tanker">

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-plus-circle'></i> " . ucfirst($module_action) . "", $type = 'submit')->class('btn btn-success') }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-warning" onclick="history.back(-1)"><i class="fas fa-reply"></i> Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{ html()->form()->close() }}

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push ('after-styles')
@endpush

@push ('after-scripts')


@endpush
