<?php

namespace Modules\Trip\Http\Middleware;

use Closure;
use Carbon;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            //trip menu

            // Separator: Donasi
            $menu->add('Pre Trip Inspection', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 4,
                'permission'    => ['view_inspections'],
            ]);

            $menu->add('<i class="fas fa-truck c-sidebar-nav-icon"></i> '.trans('menu.trip.inspections')." Today", [
                'route' => ['backend.inspections.index',('date='.date("Y-m-d"))],
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => ['admin/inspections*'],
                'permission' => ['view_inspections'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            $menu->add('<i class="fas fa-truck c-sidebar-nav-icon"></i> '.trans('menu.trip.inspections').' History', [
                'route' => 'backend.inspections.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => ['admin/inspections*'],
                'permission' => ['view_inspections'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

            $menu->add('<i class="fas fa-calendar c-sidebar-nav-icon"></i> '.trans('menu.trip.days'), [
                'route' => 'backend.days.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 5,
                'activematches' => ['admin/days*'],
                'permission' => ['view_days'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}
