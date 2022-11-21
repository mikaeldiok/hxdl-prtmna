<div class="text-right">
    @if(Auth::user()->hasRole("pengawas"))
        <x-buttons.show class="m-1"  route='{!!route("backend.$module_name.show", $data)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    @elseif(Auth::user()->hasRole("hsse"))        
        <x-buttons.show class="m-1"  route='{!!route("backend.$module_name.show-hsse", $data)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
    @elseif(Auth::user()->hasRole("super admin"))
        <x-buttons.show class="m-1"  route='{!!route("backend.$module_name.show", $data)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
        @if($module_name == "tankers")
            <x-buttons.edit route='{!!route("backend.$module_name.edit", $data)!!}' title="{{__('Edit')}} {{ ucwords(Str::singular($module_name)) }}" small="true" />
        @endif
    @endif
</div>
