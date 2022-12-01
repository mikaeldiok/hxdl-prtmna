@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')


  <div class="mx-2">
        <div class="card">
            <div class="card-body bg-light">

                <hr>

                <div class="row mt-4">
                    <div class="col">
                    {{ html()->form('POST', route("frontend.$module_name.store-inspection"))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}

                        @include ("trip::frontend.$module_name.form-part-1")
                        
                        <div id="show-tanker">

                        </div>
          
                        <div id="inspection_status">
                         </div>

                        <div id="inspection_form">
                            @include ("trip::frontend.$module_name.form-part-1b")
                        </div>


                        <div class="row" id="submit-buttons">
                            <div class="col-6">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-plus-circle'></i> " . ucfirst("Submit") . "", $type = 'submit')->class('btn btn-success') }}
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

<script type="text/javascript">
    $("#inspection_form").hide();
    $(document).ready(function(){

    });
</script>
@endpush
