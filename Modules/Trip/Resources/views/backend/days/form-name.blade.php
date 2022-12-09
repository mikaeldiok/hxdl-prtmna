
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'pengawas';
            $field_lable = 'nama pengawas';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'korlap';
            $field_lable = 'nama korlap';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'mekanik';
            $field_lable = 'nama mekanik';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>

<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push ('after-scripts')

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
$(function() {
    var date = moment("{{$$module_name_singular->tahun_registrasi ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#tahun_registrasi').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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
    var date = moment("{{$$module_name_singular->exp_stnk ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#exp_stnk').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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
    var date = moment("{{$$module_name_singular->exp_keur ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#exp_keur').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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
    var date = moment("{{$$module_name_singular->exp_tera ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#exp_tera').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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
    var date = moment("{{$$module_name_singular->exp_kip ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#exp_kip').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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
    var date = moment("{{$$module_name_singular->end_date_mt ?? ''}}", 'YYYY-MM-DD').toDate();
    $('#end_date_mt').datetimepicker({
        format: 'DD/MM/YYYY',
        date: date,
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

$(document).ready(function() {
        $('#skills').multiselect({
                enableFiltering: true,
            });

        $('#certificate').multiselect({
                enableFiltering: true,
            });
    });

</script>

@endpush
