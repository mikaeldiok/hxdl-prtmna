
@if($keterangan)
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
                $required = "required";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}

                @if( Carbon\Carbon::today()->format('Y-m-d') == $inspection->day->date)
                    {{ html()->textArea($field_name, $inspection->jenis_pekerjaan_penyelesaian ?? "")->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
                @else
                    <div class="border px-2 py-1">
                        {{$inspection->jenis_pekerjaan_penyelesaian ?? ""}}
                    </div>
                @endif
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
                $required = "required";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}

                @if( Carbon\Carbon::today()->format('Y-m-d') == $inspection->day->date)
                    {{ html()->textArea($field_name, $inspection->keterangan_penyelesaian ?? $keterangan)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
                @else
                    <div class="border px-2 py-1">
                        {{$inspection->keterangan_penyelesaian ?? ""}}
                    </div>
                @endif
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
                $required = "required";
                ?>
                {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                @if( Carbon\Carbon::today()->format('Y-m-d') == $inspection->day->date)
                    <div class="input-group date datetime" id="{{$field_name}}" name="{{$field_name}}" data-target-input="nearest">
                        {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control datetimepicker-input')->attributes(["$required", 'data-target'=>"#$field_name"]) }}
                        <div class="input-group-append" data-target="#{{$field_name}}" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                    </div>
                @else
                    <div class="border px-2 py-1">
                        {{date('m/d/Y',strtotime($inspection->estimasi_penyelesaian))}}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

@push ('after-scripts')

<!-- Date Time Picker & Moment Js-->
<script type="text/javascript">
    $(function() {    
        var date = moment("{{$$module_name_singular->estimasi_penyelesaian ?? ''}}", 'YYYY-MM-DD').toDate();
        $('#estimasi_penyelesaian').datetimepicker({
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
</script>
@endpush