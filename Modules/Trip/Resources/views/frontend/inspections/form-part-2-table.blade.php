
<!-- Perlengkapan -->
@php
    $list = collect(config("array-form"));
    $sectionB= $list->filter(function ($value, $key) {
                    return str_contains($value['code'],"B") ;
                })->all();
@endphp

<input id="id" name="id" type="hidden" value="{{$id}}">
<hr>
<h4>Perlengkapan AMT</h4>

<table>
    <tbody>
        @foreach($sectionB as $line)
        <tr>
        <?php
            $field_name = $line['name'];
            $field_lable = $line['name'];
            $field_placeholder = __("Select an option");
            $required = "required";

            ?>
            <td>{{$line['no']}}. {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} @if($line["mandatory"])<span class="font-weight-bold">(M)</span>@else<span>(A)</span> @endif</td>
            <td>
                <fieldset id="array_value_{{$line['code']}}">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mr-1" type="radio" id="{{$line['code']}}_yes" name="array_value_{{$line['code']}}" value="1">
                        <label class="form-check-label mr-2" for="{{$line['code']}}_yes">ada/baik</label><br>
                        <input class="form-check-input mr-1" type="radio" id="{{$line['code']}}_no" name="array_value_{{$line['code']}}" value="0">
                        <label class="form-check-label mr-2" for="{{$line['code']}}_no">tidak</label><br> 
                    </div>
                </fieldset>
            </td>
            @if($line["mandatory"])
                <td>
                @if(!in_array($line["no"],[4,5,6,7]))
                <input type="file"
                    id="array_photo_{{$line['code']}}" name="array_photo_{{$line['code']}}" required>
                @else
                    *foto termasuk di nomor 3
                @endif
                </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

<hr>
<h4>Odo meter</h4>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'odometer';
            $field_lable = 'awal';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
        </div>
    </div>
</div>
<input class="mt-1" type="file"
                        id="photo_odometer" name="photo_odometer" required>

<hr>
<h4>Tambahan</h4>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <?php
            $field_name = 'tambahan';
            $field_lable = 'tambahan';
            $field_placeholder = '';
            $required = "";
            ?>
            {{ html()->textArea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required", 'aria-label'=>'Image']) }}
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
</script>
@endpush
