

    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <?php
                $field_name = 'evidence';
                $field_lable = '(PDF)';
                $field_placeholder = '';
                $required = "required";
                ?><input type="file"
                        id="{{$field_name}}" name="{{$field_name}}" required>
                
            </div>
        </div>
        @if($inspection->evidence)
            <div class="col-6">
                <a href="{{$inspection->evidence}}"> <i class="fas fa-download"></i> Download Evidence</a>
                <br>
                <small>Last Update at: {{\Carbon\Carbon::parse($inspection->evidence_upload_at)->format('d/m/Y H:i')}}</small>
            </div>
        @endif
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