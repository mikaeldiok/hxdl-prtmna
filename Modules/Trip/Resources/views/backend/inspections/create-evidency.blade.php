@if(($inspection->pretrip_percentage < 1) && ($inspection->verify_evidence == 0))

    <div class="row mt-4">
        <div class="col">
            {{ html()->form('PATCH', route("backend.$module_name.update",$inspection))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}

            <hr>
            <h4>Upload Evidence</h4>

            @include ("trip::backend.$module_name.form-pengawas-evidency")

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        {{ html()->button($text = "<i class='fas fa-plus'></i> Submit Evidence" , $type = 'submit')->class('btn btn-success') }}
                    </div>
                </div>
            </div>

            {{ html()->form()->close() }}

        </div>
    </div>

@endif