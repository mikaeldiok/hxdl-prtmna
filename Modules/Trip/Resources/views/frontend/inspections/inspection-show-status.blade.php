
@include('trip::backend.inspections.inspection-show-header')
@if($inspection->pretrip_percentage < 1)
    @include('trip::backend.inspections.inspection-show-verification')
    @include ("trip::backend.$module_name.form-hsse-approval")
@endif
