<?php

namespace Modules\Trip\Http\Middleware;

use Closure;

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
            $menu->add('Pre Trip Insepction', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 4,
                'permission'    => ['view_inspections'],
            ]);

            $menu->add('<i class="fas fa-graduation-cap c-sidebar-nav-icon"></i> '.trans('menu.trip.inspections'), [
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

            $menu->add('<i class="fas fa-graduation-cap c-sidebar-nav-icon"></i> '.trans('menu.trip.days'), [
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
