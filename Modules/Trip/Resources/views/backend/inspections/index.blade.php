@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ $module_title }} @stop

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ $module_title }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i> {{ $module_title }} {{request()->get('date') ? "at ".convert_basic_to_slash_date(request()->get('date')) : ''}} <small class="text-muted">{{ __($module_action) }}</small>
                </h4>
            </div>
            <!--/.col-->
            <div class="col-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pickDateModal">
                    Choose Date  <i class="fa fa-calendar ml-2"></i>
                </button>

                <div class="float-right">
                    @can('add_'.$module_name)
                        <x-buttons.create route='{{ route("backend.$module_name.create") }}' title="{{__('Create')}} {{ ucwords(Str::singular($module_name)) }}"/>
                    @endcan

                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <div class="btn-group" role="group">
                            <button id="btnGroupToolbar" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupToolbar">
                                @can('delete_'.$module_name)
                                    <a class="dropdown-item" href="{{ route("backend.$module_name.trashed") }}">
                                        <i class="fas fa-eye-slash"></i> View trash
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        {{ $dataTable->table() }}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">

                </div>
            </div>
            <div class="col-5">
                <div class="float-right">

                </div>
            </div>
        </div>
    </div>
</div>
@stop

<div class="modal fade" id="pickDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Choose Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ html()->form('POST', route("backend.$module_name.store"))->class('form')->attributes(['enctype'=>"multipart/form-data"])->open() }}
            <div class="form-group">
                <?php
                $field_name = 'date';
                $field_lable = 'Date';
                $field_placeholder = "DD/MM/YYYY";
                $required = "";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                <div class="input-group date datetime" id="{{$field_name}}" name="{{$field_name}}" data-target-input="nearest">
                    {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                    <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <div class="form-group">
                            <a href={{route('backend.inspections.index',('date='.date("Y-m-d")))}} id="searcher" class="btn btn-xs btn-info pull-right"><i class="fa fa-search"></i> Search</a>
                        </div>
                    </div>
                </div>
            </div>

        {{ html()->form()->close() }}
      </div>
    </div>
  </div>
</div>

<x-library.datetime-picker />

@push ('after-styles')
<!-- DataTables Trip and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Trip and Extensions -->
{!! $dataTable->scripts()  !!}


<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
$(function() {
    $('#date').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        }
    });
});

$('#date').on("change.datetimepicker", function(e){
    var theDate = $("#date").datetimepicker('viewDate').format("YYYY-MM-DD");
    $("#searcher").attr('href', '{{route("backend.inspections.index")}}'+'?date='+theDate);
});

</script>
@endpush
