
<!-- filling and exp date -->
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'date';
            $field_lable = 'date';
            $field_placeholder = "DD/MM/YYYY";
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <div class="input-group date datetime" id="{{$field_name}}" name="{{$field_name}}" data-target-input="nearest">
                {{ html()->text($field_name,Carbon\Carbon::today()->format('d/m/Y'))->placeholder($field_placeholder)->class('form-control date datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="form-group">
            <?php
            $field_name = 'tanker_id';
            $field_lable = "Nomor Polisi";
            $select_options = $options["tankers"];
            $field_placeholder = __("Select an option");
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="form-group">
            {{ html()->label("Status") }}: <span id="status" class=p-2>-</span>
        </div>
    </div>
</div>

<div class="row">

</div>

<!-- Select2 Library -->
<x-library.select2 />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push ('after-scripts')
<script type="text/javascript">
$(function() {
    $('.datetime').datetimepicker({
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


$("#tanker_id").on('change', function(e) {
    // Access to full data
    data = ($(this).select2('data'))[0];

    $.ajax({
        type: "POST",
        url: '{{route("frontend.tankers.get-tanker")}}',
        data: {
            "_method":"POST",
            "_token": "{{ csrf_token() }}",
            "id": data.id
        },
        success: function (data) {
            $('#show-tanker').html(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Swal.fire("@lang('delete error')", "@lang('error')", "error");
        }
    });

    $.ajax({
        type: "POST",
        url: '{{route("frontend.tankers.checkNoExpired")}}',
        data: {
            "_method":"POST",
            "_token": "{{ csrf_token() }}",
            "id": data.id
        },
        success: function (data) {
            if(data){
                $("#status").html("ON");
                $("#status").addClass("bg-success text-white");
                $("#status").removeClass("bg-danger");
                $("#inspection_form").show();
            }else{
                $("#status").html("OFF");
                $("#status").addClass("bg-danger text-white");
                $("#status").removeClass("bg-success");
                $("#inspection_form").hide();
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            Swal.fire("@lang('delete error')", "@lang('error')", "error");
        }
    });
});
</script>
@endpush
