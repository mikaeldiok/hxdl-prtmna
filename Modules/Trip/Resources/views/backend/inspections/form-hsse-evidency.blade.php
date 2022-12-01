<input id="verify_evidence" name="verify_evidence" type="hidden" value="1">
<input id="status" name="status" type="hidden" value="ON">

<div class="row my-4">
    @if($inspection->evidence)
        <div class="col-6">
            <a href="{{$inspection->evidence}}"> <i class="fas fa-download"></i> Download Evidence</a>
            <br>
            <small>Last Update at: {{\Carbon\Carbon::parse($inspection->evidence_upload_at)->format('d/m/Y H:i')}}</small>
        </div>
    @else
        <div class="col-6">
            <i class="fas fa-times p-1"></i><small>Evidence not available</small>
        </div>
    @endif
</div>