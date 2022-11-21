<?php

namespace Modules\Trip\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Modules\Trip\Services\InspectionService;
use Modules\Trip\DataTables\InspectionsDataTable;
use Modules\Trip\Http\Requests\Backend\InspectionsRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class InspectionsController extends Controller
{
    use Authorizable;

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
        $this->module_icon = 'fas fa-graduation-cap';

        // module model name, path
        $this->module_model = "Modules\Trip\Entities\Inspection";

        $this->inspectionService = $inspectionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(InspectionsDataTable $dataTable)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::paginate();

        return $dataTable->render("trip::backend.$module_path.index",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Select Options for Select 2 Request/ Response.
     *
     * @return Response
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = [];

        $$module_name = $this->inspectionService->getIndexList($request);

        return response()->json($$module_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        $options = $this->inspectionService->create()->data;

        return view(
            "trip::backend.$module_name.create",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular','options')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(InspectionsRequest $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $inspections = $this->inspectionService->store($request,1);

        $$module_name_singular = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Added Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $inspections = $this->inspectionService->show($id);

        $$module_name_singular = $inspections->data;
        $tanker = $inspections->data->tanker;

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $activities = Activity::where('subject_type', '=', $module_model)
            ->where('log_name', '=', $module_name)
            ->where('subject_id', '=', $id)
            ->latest()
            ->paginate();

        return view(
            "trip::backend.$module_name.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular",'activities','driver','tanker')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function showHsse($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $inspections = $this->inspectionService->show($id);

        $$module_name_singular = $inspections->data;
        $tanker = $inspections->data->tanker;

        //determine connections
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $activities = Activity::where('subject_type', '=', $module_model)
            ->where('log_name', '=', $module_name)
            ->where('subject_id', '=', $id)
            ->latest()
            ->paginate();

        return view(
            "trip::backend.$module_name.show-hsse",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular",'activities','driver','tanker')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $inspections = $this->inspectionService->edit($id);

        $$module_name_singular = $inspections->data;
        
        return view(
            "trip::backend.$module_name.edit",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(InspectionsRequest $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $inspections = $this->inspectionService->update($request,$id);

        $$module_name_singular = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Updated Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'destroy';

        $inspections = $this->inspectionService->destroy($id);

        $$module_name_singular = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Deleted Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function purge($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'purge';

        $inspections = $this->inspectionService->purge($id);

        $$module_name_singular = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Deleted Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }

        return redirect("admin/$module_name/trashed");
    }

    /**
     * List of trashed ertries
     * works if the softdelete is enabled.
     *
     * @return Response
     */
    public function trashed()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Trash List';

        $inspections = $this->inspectionService->trashed();

        $$module_name = $inspections->data;

        return view(
            "trip::backend.$module_name.trash",
            compact('module_title', 'module_name', "$module_name", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Restore a soft deleted entry.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function restore($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Restore';

        $inspections = $this->inspectionService->restore($id);

        $$module_name_singular = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Restored Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }
        
        return redirect("admin/$module_name");
    }

    /**
     * Restore a soft deleted entry.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function import(Request $request)
    {

        $this->validate($request,[
            'data_file' => 'mimes:csv,xls,xlsx',
            'photo_file' => 'mimes:zip,rar,7z'
         ]);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Import';
        
        $inspections = $this->inspectionService->import($request);

        $import = $inspections->data;

        if(!$inspections->error){
            Flash::success('<i class="fas fa-check"></i> '.label_case($module_name_singular).' Data Restored Successfully!')->important();
        }else{
            Flash::error("<i class='fas fa-times-circle'></i> Error When ".$module_action." '".Str::singular($module_title)."'")->important();
        }
        
        return redirect("admin/$module_name");
    }

    /**
     * FOr getting inspection data via ajax
     *
     * @return Response
     */
    public function get_inspection(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $response = $this->inspectionService->get_inspection($request);

        return response()->json($response);
    }
}
