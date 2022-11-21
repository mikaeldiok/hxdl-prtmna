<?php

namespace Modules\Vehicle\Services;

use Modules\Vehicle\Entities\Core;
use Modules\Vehicle\Entities\Tanker;
use Modules\Recruiter\Entities\Booking;

use Exception;
use Carbon\Carbon;
use Auth;

use ConsoleTVs\Charts\Classes\Echarts\Chart;
use App\Charts\TankerPerStatus;
use App\Exceptions\GeneralException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


use Modules\Vehicle\Imports\TankersImport;
use Modules\Vehicle\Events\TankerRegistered;

use App\Events\Backend\UserCreated;
use App\Events\Backend\UserUpdated;

use App\Models\User;
use App\Models\Userprofile;

class TankerService{

    public function __construct()
        {        
        $this->module_title = Str::plural(class_basename(Tanker::class));
        $this->module_name = Str::lower($this->module_title);
        
        }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        $tanker =Tanker::query()->orderBy('id','desc')->get();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }
    
    public function getAllTankers(){

        $tanker =Tanker::query()->available()->orderBy('id','desc')->get();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }

    public function getPopularTanker(){

        $tanker =DB::table('bookings')
                    ->select('bookings.tanker_id','name','', DB::raw('count(*) as total'))
                    ->join('tankers', 'bookings.tanker_id', '=', 'tankers.id')
                    ->groupBy('bookings.tanker_id')
                    ->orderBy('total','desc')
                    ->get();
                
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }

    public function filterTankers($pagination,$request){

        $tanker =Tanker::query()->available();

        if(count($request->all()) > 0){
            if($request->has('major')){
                $tanker->whereIn('major', $request->input('major'));
            }

            if($request->has('year_class')){
                $tanker->whereIn('year_class', $request->input('year_class'));
            }

            if($request->has('height')){
                $tanker->where('height', ">=", (float)$request->input('height'));
            }

            if($request->has('weight')){
                $tanker->where('weight', ">=", (float)$request->input('weight'));
            }

            if($request->has('skills')){
                $tanker->where(function ($query) use ($request){
                    $checkSkills = $request->input('skills');
                    foreach($checkSkills as $skill){
                        if($request->input('must_have_all_skills')){
                            $query->where('skills', 'like','%'.$skill.'%');
                        }else{
                            $query->orWhere('skills', 'like','%'.$skill.'%');
                        }
                    }
                });
            }

            if($request->has('certificate')){
                $tanker->where(function ($query) use ($request){
                    $checkCerts = $request->input('certificate');
                    foreach($checkCerts as $cert){
                        if($request->input('must_have_all_certificate')){
                            $query->where('certificate', 'like','%'.$cert.'%');
                        }else{
                            $query->orWhere('certificate', 'like','%'.$cert.'%');
                        }
                    }
                });
            }
        }

        $tanker = $tanker->paginate($pagination);
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }

    public function getPaginatedTankers($pagination,$request){

        $tanker =Tanker::query()->available();

        if(count($request->all()) > 0){

        }

        $tanker = $tanker->paginate($pagination);
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }
    
    public function get_tanker($id){

        $tanker =Tanker::findOrFail($id);
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'noExpired' => $this->checkNoExpired($tanker),
            'data'=> $tanker,
        );
    }

    public function checkNoExpired($tanker){
        $attributes = ["exp_stnk","exp_keur","exp_tera","exp_kip","exp_kip","end_date_mt"];

        foreach($attributes as $attribute){
            

            $the_date = Carbon::parse($tanker->$attribute);
            $today = Carbon::today();
            $diff = $today->diffInDays($the_date);
            
            if($the_date < $today){
                return false;
            }
        }

        return true;
    }

    public function getList(){

        $tanker =Tanker::query()->orderBy('order','asc')->get();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }


    public function create(){

       Log::info(label_case($this->module_title.' '.__function__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? '0').')');
        
        $createOptions = [];

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $createOptions,
        );
    }

    public function store(Request $request){

        $data = $request->all();
        DB::beginTransaction();

        try {
            
            $tankerObject = new Tanker;
            $tankerObject->fill($data);

            if($tankerObject->tahun_registrasi){
                $tankerObject->tahun_registrasi = convert_slash_to_basic_date($tankerObject->tahun_registrasi);
            }
            if($tankerObject->exp_stnk){
                $tankerObject->exp_stnk = convert_slash_to_basic_date($tankerObject->exp_stnk);
            }
            if($tankerObject->exp_keur){
                $tankerObject->exp_keur = convert_slash_to_basic_date($tankerObject->exp_keur);
            }
            if($tankerObject->exp_tera){
                $tankerObject->exp_tera = convert_slash_to_basic_date($tankerObject->exp_tera);
            }
            if($tankerObject->exp_kip){
                $tankerObject->exp_kip = convert_slash_to_basic_date($tankerObject->exp_kip);
            }
            if($tankerObject->end_date_mt){
                $tankerObject->end_date_mt = convert_slash_to_basic_date($tankerObject->end_date_mt);
            }

            $tankerObjectArray = $tankerObject->toArray();

            $tanker = Tanker::create($tankerObjectArray);
            
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' ON LINE '.__LINE__.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__function__)." | '".$tanker->name.'(ID:'.$tanker->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }

    public function show($id, $tankerId = null){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> Tanker::findOrFail($id),
        );
    }

    public function edit($id){

        $tanker = Tanker::findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$tanker->name.'(ID:'.$tanker->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tanker,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{

            $tankerObject = new Tanker;
            $tankerObject->fill($data);
            
            if($tankerObject->tahun_registrasi){
                $tankerObject->tahun_registrasi = convert_slash_to_basic_date($tankerObject->tahun_registrasi);
            }
            if($tankerObject->exp_stnk){
                $tankerObject->exp_stnk = convert_slash_to_basic_date($tankerObject->exp_stnk);
            }
            if($tankerObject->exp_keur){
                $tankerObject->exp_keur = convert_slash_to_basic_date($tankerObject->exp_keur);
            }
            if($tankerObject->exp_tera){
                $tankerObject->exp_tera = convert_slash_to_basic_date($tankerObject->exp_tera);
            }
            if($tankerObject->exp_kip){
                $tankerObject->exp_kip = convert_slash_to_basic_date($tankerObject->exp_kip);
            }
            if($tankerObject->end_date_mt){
                $tankerObject->end_date_mt = convert_slash_to_basic_date($tankerObject->end_date_mt);
            }
            
            $updating = Tanker::findOrFail($id)->update($tankerObject->toArray());

            $updated_tanker = Tanker::findOrFail($id);


        }catch (Exception $e){
            DB::rollBack();
            report($e);
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_tanker->name.'(ID:'.$updated_tanker->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_tanker,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $tankers = Tanker::findOrFail($id);
    
            $deleted = $tankers->delete();
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$tankers->name.', ID:'.$tankers->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tankers,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> Tanker::bookingonlyTrashed()->get(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $restoring =  Tanker::bookingwithTrashed()->where('id',$id)->restore();
            $tankers = Tanker::findOrFail($id);
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$tankers->name.", ID:".$tankers->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tankers,
        );
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $tankers = Tanker::bookingwithTrashed()->findOrFail($id);
    
            $deleted = $tankers->forceDelete();
        }catch (Exception $e){
            DB::rollBack();
            Log::critical(label_case($this->module_title.' AT '.Carbon::now().' | Function:'.__FUNCTION__).' | Msg: '.$e->getMessage());
            return (object) array(
                'error'=> true,
                'message'=> $e->getMessage(),
                'data'=> null,
            );
        }

        DB::commit();

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$tankers->name.', ID:'.$tankers->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $tankers,
        );
    }

    public function import(Request $request){
        $import = Excel::import(new TankersImport($request), $request->file('data_file'));
    
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $import,
        );
    }

    public static function prepareStatusFilter(){
        
        $raw_status = Core::getRawData('recruitment_status');
        $status = [];
        foreach($raw_status as $key => $value){
            $status += [$value => $value];
        }

        return $status;
    }

    public static function prepareOptions(){
        
        $raw_majors = Core::getRawData('major');
        $majors = [];
        foreach($raw_majors as $key => $value){
            $majors += [$value => $value];
        }

        $skills_raw = Core::getRawData('skills');
        $skills = [];
        foreach($skills_raw as $value){
            $skills += [$value => $value];
        }

        $certificate_raw= Core::getRawData('certificate');
        $certificate = [];
        foreach($certificate_raw as $value){
            $certificate += [$value => $value];
        }

        $options = array(
            'majors'         => $majors,
            'skills'              => $skills,
            'certificate'         => $certificate,
        );

        return $options;
    }

    public static function prepareFilter(){
        
        $options = self::prepareOptions();

        $year_class_raw = DB::table('tankers')
                        ->select('year_class', DB::raw('count(*) as total'))
                        ->groupBy('year_class')
                        ->orderBy('year_class','desc')
                        ->get();
        $year_class = [];
            foreach($year_class_raw as $item){
                $year_class += [$item->year_class => $item->year_class];
                // $year_class += [$item->year_class => $item->year_class." (".$item->total.")"];
            }


        $filterOp = array(
            'year_class'          => $year_class,
        );

        return array_merge($options,$filterOp);
    }

    public function getTankerPerStatusChart(){

        $chart = new Chart;

        $raw_status_order = Core::getRawData('recruitment_status');
        $status_order = [];
        foreach($raw_status_order as $key => $value){
            $status_order += [$value => 0];
        }

        $last_key = array_key_last($status_order);
        $remove_last_status = array_pop($status_order);

        $raw_majors = Core::getRawData('major');
        $majors = [];

        foreach($raw_majors as $key => $value){
            $majors[] = $value;
        }

        foreach($majors as $major){

            $status_raw = DB::table('bookings')
                        ->select('status', DB::raw('count(*) as total'))
                        ->join('tankers', 'bookings.tanker_id', '=', 'tankers.id')
                        ->where('tankers.major',$major)
                        ->where('tankers.available',1)
                        ->where('status',"<>",$last_key)
                        ->groupBy('status')
                        ->orderBy('status','desc')
                        ->get();
            $status = [];

            foreach($status_raw as $item){
                $status += [$item->status => $item->total];
            }

            $status = array_merge($status_order, $status);

            [$keys, $values] = Arr::divide($status);

            $chart->labels($keys);

            $chart->dataset($major, 'bar',$values);
        }

        $chart->options([
            "xAxis" => [
                "axisLabel" => [
                    "interval" => 0,
                    "overflow" => "truncate",
                ],
            ],
            "yAxis" => [
                "minInterval" => 1
            ],
        ]);

        return $chart;
    }

    public function getDoneTankersChart(){

        $chart = new Chart;

        $raw_status_order = Core::getRawData('recruitment_status');
        $status_order = [];
        foreach($raw_status_order as $key => $value){
            $status_order += [$value => 0];
        }

        $last_key = array_key_last($status_order);
        $remove_last_status = array_pop($status_order);

        $raw_majors = Core::getRawData('major');
        $majors = [];

        foreach($raw_majors as $key => $value){
            $majors[] = $value;
        }

        $year_class_list_raw = DB::table('tankers')
                                ->select('year_class')
                                ->groupBy('year_class')
                                ->orderBy('year_class','asc')
                                ->limit(8)
                                ->get();
        
        $year_class_list= [];


        foreach($year_class_list_raw as $item){
            $year_class_list += [$item->year_class => 0];
        }                    

        foreach($majors as $major){

            $year_class_raw = DB::table('bookings')
                        ->select('tankers.year_class', DB::raw('count(*) as total'))
                        ->join('tankers', 'bookings.tanker_id', '=', 'tankers.id')
                        ->distinct()
                        ->where('tankers.major',$major)
                        ->where('status',"=",$last_key)
                        ->groupBy('tankers.year_class')
                        ->orderBy('tankers.year_class','asc')
                        ->get();

            $year_class = [];

            foreach($year_class_raw as $item){
                $year_class += [$item->year_class => $item->total];
            }

            $year_class =  $year_class + $year_class_list;

            ksort($year_class);

            [$keys, $values] = Arr::divide($year_class);

            $chart->labels($keys);

            $chart->dataset($major, 'bar',$values);
        }

        $chart->options([
            "xAxis" => [
                "axisLabel" => [
                    "interval" => 0,
                    "overflow" => "truncate",
                ],
            ],
            "yAxis" => [
                "minInterval" => 1
            ],
        ]);

        return $chart;
    }

    public function getTankerPerYearClassChart(){

        $chart = new Chart;

        $tankers_active = DB::table('tankers')
                            ->select('year_class', DB::raw('count(*) as total'))
                            ->where('available',1)
                            ->groupBy('year_class')
                            ->orderBy('year_class','asc')
                            ->get();

        $tankers=[];
        foreach($tankers_active as $item){
            $tankers += [$item->year_class => $item->total];
        }

        [$keys, $values] = Arr::divide($tankers);

        $chart->labels($keys);

        $chart->dataset("Jumlah Siswa", 'bar',$values);
        
        $chart->options([
            "xAxis" => [
                "axisLabel" => [
                    "interval" => 0,
                    "overflow" => "truncate",
                ],
            ],
            "yAxis" => [
                "minInterval" => 1
            ],
        ]);

        return $chart;
    }

    public static function prepareInsight(){

        $countAllTankers = Tanker::all()->count();

        $raw_status= Core::getRawData('recruitment_status');
        $status = [];

        foreach($raw_status as $key => $value){
            $status[] = $value;
        }

        $countDoneTankers = Booking::where('status',end($status))->get()->count();
        
        $stats = (object) array(
            'status'                    => $status,
            'countAllTankers'          => $countAllTankers,
            'countDoneTankers'         => $countDoneTankers,
        );

        return $stats;
    }

}