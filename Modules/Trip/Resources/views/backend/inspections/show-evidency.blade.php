@if($inspection->pretrip_percentage < 1)

<div class="row mt-4">
    <div class="col">
        {{ html()->form('PATCH', route("backend.$module_name.update",$inspection))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}

        <hr>
            <h4>Evidence</h4>

        @include ("trip::backend.$module_name.form-hsse-evidency")

        @if($inspection->verify_evidence == 0)
        
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        @if($inspection->evidence)
                            {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Approve" , $type = 'submit')->class('btn btn-success') }}
                        @else
                            {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Approve" , $type = 'button')->class('btn btn-secondary')->attributes(["disabled"]) }}
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{ html()->form()->close() }}

    </div>
</div>
@endif