<?php

namespace Modules\Trip\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Auth;
use Modules\Trip\Services\DayService;
use Spatie\Activitylog\Models\Activity;

class DaysController extends Controller
{
    protected $dayService;

    public function __construct(DayService $dayService)
    {
        // Page Title
        $this->module_title = trans('menu.trip.days');

        // module name
        $this->module_name = 'days';

        // directory path of the module
        $this->module_path = 'days';

        // module icon
        $this->module_icon = 'fas fa-user-tie';

        // module model name, path
        $this->module_model = "Modules\Day\Entities\Day";

        $this->dayService = $dayService;
    }

    /**
     * Go to day homepage
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $days = $this->dayService->getAllDays()->data;

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "days",'driver')
        );
    }


    /**
     * Go to day catalog
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function indexPaginated(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $days = $this->dayService->getPaginatedDays(20,$request)->data;
        
        if ($request->ajax()) {
            return view("trip::frontend.$module_name.days-card-loader", ['days' => $days])->render();  
        }
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "days",'driver')
        );
    }

    /**
     * Go to day catalog
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function filterDays(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $days = $this->dayService->filterDays(20,$request)->data;
        
        if ($request->ajax()) {
            return view("trip::frontend.$module_name.days-card-loader", ['days' => $days])->render();  
        }
        
    }


    /**
     * Show day details
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function show($id,$dayId)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $day = $this->dayService->show($id)->data;
        
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "day",'driver')
        );
    }
}
