<?php

namespace Modules\Vehicle\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Auth;
use Modules\Vehicle\Services\TankerService;
use Spatie\Activitylog\Models\Activity;

class TankersController extends Controller
{
    protected $tankerService;

    public function __construct(TankerService $tankerService)
    {
        // Page Title
        $this->module_title = trans('menu.vehicle.tankers');

        // module name
        $this->module_name = 'tankers';

        // directory path of the module
        $this->module_path = 'tankers';

        // module icon
        $this->module_icon = 'fas fa-user-tie';

        // module model name, path
        $this->module_model = "Modules\Tanker\Entities\Tanker";

        $this->tankerService = $tankerService;
    }

    /**
     * Go to tanker homepage
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

        $tankers = $this->tankerService->getAllTankers()->data;

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "vehicle::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "tankers",'driver')
        );
    }


    /**
     * Go to tanker catalog
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

        $tankers = $this->tankerService->getPaginatedTankers(20,$request)->data;
        
        if ($request->ajax()) {
            return view("vehicle::frontend.$module_name.tankers-card-loader", ['tankers' => $tankers])->render();  
        }
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "vehicle::frontend.$module_name.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "tankers",'driver')
        );
    }

    /**
     * Go to tanker catalog
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function filterTankers(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $tankers = $this->tankerService->filterTankers(20,$request)->data;
        
        if ($request->ajax()) {
            return view("vehicle::frontend.$module_name.tankers-card-loader", ['tankers' => $tankers])->render();  
        }
        
    }

    /**
     * Show tanker details
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function getTanker(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $tanker = $this->tankerService->get_tanker($request->input('id'))->data;
       
        return view(
            "vehicle::frontend.$module_name.tanker-show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "tanker")
        );
    }

    /**
     * Show tanker details
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function checkNoExpired(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $noExpired = $this->tankerService->get_tanker($request->input('id'))->noExpired;
       
        return $noExpired;
    }

    /**
     * Show tanker details
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function show($id,$tankerId)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Index';

        $tanker = $this->tankerService->show($id)->data;
        
        
        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
       
        return view(
            "vehicle::frontend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "tanker",'driver')
        );
    }
}
