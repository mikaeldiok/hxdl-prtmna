<?php

namespace Modules\Trip\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Auth;
use Modules\Trip\Services\InspectionService;
use Spatie\Activitylog\Models\Activity;

class InspectionsController extends Controller
{
    protected $inspectionService;

    public function __construct(InspectionService $inspectionService)
    {
        // Page Title
        $this->module_title = trans('menu.trip.inspections');

        // module name
        $this->module_name = 'inspections';

        // directory path of the module
        $this->module_path = 'inspections';

        // module icon
        $this->module_icon = 'fas fa-user-tie';

        // module model name, path
        $this->module_model = "Modules\Inspection\Entities\Inspection";

        $this->inspectionService = $inspectionService;
    }

    /**
     * Go to inspection homepage
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

        $inspections = $this->inspectionService->getAllInspections()->data;

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "inspections",'driver')
        );
    }


    /**
     * Go to inspection catalog
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

        $inspections = $this->inspectionService->getPaginatedInspections(20,$request)->data;
        
        if ($request->ajax()) {
            return view("trip::frontend.$module_name.inspections-card-loader", ['inspections' => $inspections])->render();  
        }
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "inspections",'driver')
        );
    }

    /**
     * Go to inspection catalog
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function filterInspections(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $inspections = $this->inspectionService->filterInspections(20,$request)->data;
        
        if ($request->ajax()) {
            return view("trip::frontend.$module_name.inspections-card-loader", ['inspections' => $inspections])->render();  
        }
        
    }


    /**
     * Show inspection details
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function show($id,$inspectionId)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $inspection = $this->inspectionService->show($id)->data;
        
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "trip::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "inspection",'driver')
        );
    }
}
