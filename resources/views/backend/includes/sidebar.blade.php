<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand"> <a href="{{route("backend.dashboard")}}"><img class="c-sidebar-brand-full" src="{{asset("img/Pertamina.png")}}" height="40" alt="{{ app_name() }}"><img class="c-sidebar-brand-minimized" src="{{asset("img/backend-logo-square.jpg")}}" height="40" alt="{{ app_name() }}"></a><h2 class="mx-3">OPTRIM</h2></div>

    {!! $admin_sidebar->asUl( ['class' => 'c-sidebar-nav'], ['class' => 'c-sidebar-nav-dropdown-items'] ) !!}

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>
