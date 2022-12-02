<div class="row mt-4">
    <div class="col">
        {{ html()->form('PATCH', route("backend.$module_name.update",$inspection))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}

        @include ("trip::backend.$module_name.form-hsse-approval")

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    @if($inspection->verify_by_pengawas != true)
                        {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Approve Gate In" , $type = 'button')->class('btn btn-secondary')->attribute('disabled') }}
                        <small class="text-danger">Belum ada approval dari pengawas</small>
                    @elseif($fm && ($inspection->verify_evidence != true))
                        {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Approve Gate In" , $type = 'button')->class('btn btn-secondary')->attribute('disabled') }}
                        <small class="text-danger">Ada persayaratan mandatory yang belum terpenuhi</small>
                    @else
                        {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Approve Gate In" , $type = 'submit')->class('btn btn-success') }}
                    @endif
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