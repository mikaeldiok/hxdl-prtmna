
@php
    $list = collect(config("array-form"));
    $sectionA = $list->filter(function ($value, $key) {
                    return str_contains($value['code'],"A") ;
                })->all();
    $array_inspection = json_decode($inspection->inspection_array,true);
@endphp

<hr>
<h4>Perlengkapan Mobil Tangki</h4>
    <table>
        <tbody>
         @foreach($sectionA as $line)
            <tr>
            <?php
                $field_name = $line['name'];
                $field_lable = $line['name'];
                $field_placeholder = __("Select an option");
                $required = "required";

                ?>
                <td>{{$line['no']}}. {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!} @if($line["mandatory"])<span class="font-weight-bold">(M)</span>@else<span>(A)</span> @endif</td>
                <td>
                @if(array_key_exists( ('array_value_'.$line['code']),$array_inspection) )
                        : @if($array_inspection[('array_value_'.$line['code'])])
                        <span class="text-success">ADA/BAIK</span>
                    @else
                        <span class="text-danger">TIDAK</span>
                    @endif
                @else
                    <span class="text-warning">---</span>
                @endif
                </td>
                <td>
                @if(array_key_exists( ('array_note_'.$line['code']),$array_inspection) && isset($array_inspection[('array_note_'.$line['code'])]) )
                    <span class="font-weight-bold">Keterangan:</span> {{$array_inspection[('array_note_'.$line['code'])]}}
                @endif
                </td>
            </tr>
            @if($line["mandatory"])
                <tr>
                    <td>
                        @if(array_key_exists( ('array_photo_'.$line['code']),$array_inspection) )
                            <a href="{{$array_inspection[('array_photo_'.$line['code'])]}}">
                                <img src="{{$array_inspection[('array_photo_'.$line['code'])]}}" alt="{{$line['name']}}_photo" width="100" height="100"> 
                            </a>
                        @else
                            <span class="text-warning">---</span>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

<!-- Perlengkapan -->
@php
    $list = collect(config("array-form"));
    $sectionB= $list->filter(function ($value, $key) {
                    return str_contains($value['code'],"B") ;
                })->all();
@endphp

<hr>
<h4>Perlengkapan AMT</h4><table>
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
                @if(array_key_exists( ('array_value_'.$line['code']),$array_inspection) )
                        : @if($array_inspection[('array_value_'.$line['code'])])
                        <span class="text-success">ADA/BAIK</span>
                    @else
                        <span class="text-danger">TIDAK</span>
                    @endif
                @else
                    <span class="text-warning">---</span>
                @endif
                </td>
                <td>
                @if(array_key_exists( ('array_note_'.$line['code']),$array_inspection) && isset($array_inspection[('array_note_'.$line['code'])]) )
                    <span class="font-weight-bold">Keterangan:</span> {{$array_inspection[('array_note_'.$line['code'])]}}
                @endif
                </td>
            </tr>

            @if($line["mandatory"])
                <tr>
                     <td>
                     @if(array_key_exists( ('array_photo_'.$line['code']),$array_inspection) )
                        @if(!in_array($line["no"],[4,5,6,7]))
                            <a href="{{$array_inspection[('array_photo_'.$line['code'])]}}">
                                <img src="{{$array_inspection[('array_photo_'.$line['code'])]}}" alt="{{$line['name']}}_photo" width="100" height="100"> 
                            </a>                    
                        @else
                            *foto termasuk di nomor 3
                        @endif
                    @else
                        <span class="text-warning">---</span>
                    @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
<hr>

<h4>Odo meter</h4>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <table>
                <tbody>
                    <tr>
                        <?php
                        $field_name = 'odometer';
                        $field_lable = 'awal';
                        $field_placeholder = '';
                        ?>
                        <td>
                            {{ html()->label($field_lable, $field_name) }} {!! fielf_required($required) !!}
                        </td>
                        <td >
                            <span class="mx-3">
                                {{$inspection->odometer}}
                            </span>
                        </td>
                        <td>
                            <img src="{{$inspection->photo_odometer}}" alt="photo_odometer" width="300" height="200">    
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
            <br>
            <a href="{{$inspection->$field_name}}">
                    <img src="{{$inspection->$field_name}}" alt="{{$field_name}}" width="200" height="200"> 
                </a> 
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
            <br>
            <a href="{{$inspection->$field_name}}">
                    <img src="{{$inspection->$field_name}}" alt="{{$field_name}}" width="200" height="200"> 
                </a> 
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
            <br>
            <a href="{{$inspection->$field_name}}">
                    <img src="{{$inspection->$field_name}}" alt="{{$field_name}}" width="200" height="200"> 
                </a> 
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
            <br>
            <a href="{{$inspection->$field_name}}">
                    <img src="{{$inspection->$field_name}}" alt="{{$field_name}}" width="200" height="200"> 
                </a> 
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
            <div class="border p3">
                {{$inspection->tambahan}}
            </div>
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
