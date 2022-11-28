
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
@foreach($sectionB as $line)
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group  class="mt-2">
                <?php
                $field_name = $line['name'];
                $field_lable = $line['name'];
                $field_placeholder = __("Select an option");
                $required = "required";
                ?>
                {{$line['no']}}. {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} @if($line["mandatory"])<span class="font-weight-bold">(M)</span>@else<span>(A)</span> @endif
                <fieldset id="array_value_{{$line['code']}}">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input mr-1" type="radio" id="{{$line['code']}}_yes" name="array_value_{{$line['code']}}" value="1">
                        <label class="form-check-label mr-2" for="{{$line['code']}}_yes">ada/baik</label><br>
                        <input class="form-check-input mr-1" type="radio" id="{{$line['code']}}_no" name="array_value_{{$line['code']}}" value="0">
                        <label class="form-check-label mr-2" for="{{$line['code']}}_no">tidak</label><br> 
                    </div>
                </fieldset>
                @if($line["mandatory"])
                    @if(!in_array($line["no"],[4,5,6,7]))
                    <input type="file"
                        id="array_photo_{{$line['code']}}" name="array_photo_{{$line['code']}}" required>
                    @else
                        *foto termasuk di nomor 3
                    @endif
                @endif
            </div>
        </div>
    </div>
@endforeach

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
<h4>Foto Mobil Tanker</h4>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <?php
            $field_name = 'photo_front';
            $field_lable = 'Tampak depan';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <input class="mt-1" type="file"
                        id="{{$field_name}}" name="{{$field_name}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <?php
            $field_name = 'photo_left';
            $field_lable = 'Tampak Samping Kiri';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <input class="mt-1" type="file"
                        id="{{$field_name}}" name="{{$field_name}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <?php
            $field_name = 'photo_left';
            $field_lable = 'Tampak Samping Kanan';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <input class="mt-1" type="file"
                        id="{{$field_name}}" name="{{$field_name}}" required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <?php
            $field_name = 'photo_behind';
            $field_lable = 'Tampak Belakang';
            $field_placeholder = '';
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
            <input class="mt-1" type="file"
                        id="{{$field_name}}" name="{{$field_name}}" required>
        </div>
    </div>
</div>

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
