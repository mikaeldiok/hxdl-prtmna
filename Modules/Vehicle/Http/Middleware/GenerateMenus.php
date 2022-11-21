<?php

namespace Modules\Vehicle\Http\Middleware;

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
            //vehicle menu

            // Separator: Donasi
            $menu->add('Kendaraan', [
                'class' => 'c-sidebar-nav-title',
            ])
            ->data([
                'order'         => 2,
                'permission'    => ['view_tankers'],
            ]);

            $menu->add('<i class="fas fa-graduation-cap c-sidebar-nav-icon"></i> '.trans('menu.vehicle.tankers'), [
                'route' => 'backend.tankers.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order' => 3,
                'activematches' => ['admin/tankers*'],
                'permission' => ['view_tankers'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);

        })->sortBy('order');

        return $next($request);
    }
}
