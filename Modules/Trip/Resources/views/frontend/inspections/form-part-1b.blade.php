
<!-- Perlengkapan -->
@php
    $list = collect(config("array-form"));
    $sectionA = $list->filter(function ($value, $key) {
                    return str_contains($value['code'],"A") ;
                })->all();
@endphp

<hr>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'amt1';
            $field_lable = 'nama amt 1';
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
            $field_name = 'amt2';
            $field_lable = 'nama amt 2';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<hr>
<h4>Perlengkapan Mobil Tangki</h4>
@foreach($sectionA as $line)
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group  class="mt-2">
                <?php
                $field_name = $line['name'];
                $field_lable = $line['name'];
                $select_options = $options["tankers"];
                $field_placeholder = __("Select an option");
                $required = "required";
                ?>
                {{$line['no']}}. {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} @if($line["mandatory"])<span class="font-weight-bold">(M)</span>@else<span>(A)</span> @endif
                <fieldset id="array_value_{{$line['code']}}" class="inspection-quiz" line-code="{{$line['code']}}" required="required">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mr-1"  line-code="{{$line['code']}}" type="radio" id="{{$line['code']}}_yes" name="array_value_{{$line['code']}}" value="1" required="required">
                        <label class="form-check-label mr-2" for="{{$line['code']}}_yes">ada/baik</label><br>
                        <input class="form-check-input mr-1" line-code="{{$line['code']}}" type="radio" id="{{$line['code']}}_no" name="array_value_{{$line['code']}}" value="0">
                        <label class="form-check-label mr-2"  for="{{$line['code']}}_no">tidak</label><br> 
                    </div>
                </fieldset>

                <input type="text" class="my-2"
                    id="array_note_{{$line['code']}}" placeholder="keterangan" name="array_note_{{$line['code']}}" style="display: none;">        
                @if($line["mandatory"])
                    <input type="file"
                        id="array_photo_{{$line['code']}}" name="array_photo_{{$line['code']}}" required>
                @endif
            </div>
        </div>
    </div>
@endforeach


<!-- Select2 Library -->
<x-library.select2 />
<x-library.datetime-picker />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush

@push ('after-scripts')
<script>
    $(document).on("change", ".inspection-quiz input:radio", function(){
        var ele = $(this);  
        var textline = "#array_note_"+ele.attr("line-code");
        console.log(textline);

        if(ele.val() == "1"){
            $(textline).removeAttr('required');
            $(textline).hide();
        }else{
            $(textline).attr('required', ''); 
            $(textline).show();
        }
    });
</script>
@endpush
