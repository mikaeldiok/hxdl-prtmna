<hr>
<h4>Penyelesaian</h4>

<input id="verify_by_pengawas" name="verify_by_pengawas" type="hidden" value="1">
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'jenis_pekerjaan_penyelesaian';
            $field_lable = 'jenis_pekerjaan_penyelesaian';
            $field_placeholder = '';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textArea($field_name, $inspection->jenis_pekerjaan_penyelesaian ?? "")->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'keterangan_penyelesaian';
            $field_lable = 'keterangan_penyelesaian';
            $field_placeholder = '';
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->textArea($field_name, $inspection->jenis_pekerjaan_penyelesaian ?? "")->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'estimasi_penyelesaian';
            $field_lable = 'estimasi_penyelesaian';
            $field_placeholder = "DD/MM/YYYY";
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <input type="date" value="{{$inspection->estimasi_penyelesaian ?? ''}}" placeholder="dd/mm/yyyy" id="estimasi_penyelesaian" name="estimasi_penyelesaian">    
            <span>format: mm/dd/yyyy</span> 
        </div>
    </div>
</div>

@push ('after-scripts')

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
    $(function() {
        $('#estimasi_penyelesaian').datetimepicker({
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
</script>
@endpush