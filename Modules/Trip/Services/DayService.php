<?php

namespace Modules\Trip\Services;

use Modules\Trip\Entities\Core;
use Modules\Trip\Entities\Day;
use Exception;
use Carbon\Carbon;
use Auth;

use App\Exceptions\GeneralException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Events\Backend\UserCreated;
use App\Events\Backend\UserUpdated;


class DayService{

    public function __construct()
        {        
        $this->module_title = Str::plural(class_basename(Day::class));
        $this->module_name = Str::lower($this->module_title);
        
        }

    public function list(){

        Log::info(label_case($this->module_title.' '.__FUNCTION__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        $day =Day::query()->orderBy('id','desc')->get();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }
    
    public function getAllDays(){

        $day =Day::query()->available()->orderBy('id','desc')->get();
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }

    public function getPaginatedDays($pagination,$request){

        $day =Day::query()->available();

        if(count($request->all()) > 0){

        }

        $day = $day->paginate($pagination);
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }
    
    public function get_day($request){

        $id = $request["id"];

        $day =Day::findOrFail($id);
        
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }

    public function getList(){

        $day =Day::query()->orderBy('order','asc')->get();

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
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
            $day = Day::where('date',Carbon::today()->format('Y-m-d'))->first();

            if($day){
                $day->fill($data);
                $day->save();
            }else{
                $dayObject = new Day;
                $dayObject->fill($data);
    
                $dayObject->date = Carbon::today()->format('Y-m-d');
    
                $dayObjectArray = $dayObject->toArray();
    
                $day = Day::create($dayObjectArray);
            }
            
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$day->name.'(ID:'.$day->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }

    public function show($id, $dayId = null){

        Log::info(label_case($this->module_title.' '.__function__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> Day::findOrFail($id),
        );
    }

    public function edit($id){

        $day = Day::findOrFail($id);

        Log::info(label_case($this->module_title.' '.__function__)." | '".$day->name.'(ID:'.$day->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $day,
        );
    }

    public function proccessName(Request $request){
        $data = $request->all();

        DB::beginTransaction();

        try {
            $today = Day::where('date',Carbon::today()->format('Y-m-d'))->first();

            if($today){
                $today->pengawas = $data['pengawas'];
                $today->save();

            }else{
                $todayObject = new Day;
                $todayObject->date = Carbon::today()->format('Y-m-d');
                $todayObject->pengawas = $data['pengawas'];

                $todayArray = $todayObject->toArray();

                $today = Day::create($todayArray);
            }

            
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$day->name.'(ID:'.$day->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $today,
        );
    }

    public function proccessNameHss(Request $request){
        $data = $request->all();

        DB::beginTransaction();

        try {
            $today = Day::where('date',Carbon::today()->format('Y-m-d'))->first();

            if($today){
                $today->hsse = $data['hsse'];
                $today->save();

            }else{
                $todayObject = new Day;
                $todayObject->date = Carbon::today()->format('Y-m-d');
                $todayObject->hsse = $data['hsse'];

                $todayArray = $todayObject->toArray();

                $today = Day::create($todayArray);
            }

            
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

        Log::info(label_case($this->module_title.' '.__function__)." | '".$today->name.'(ID:'.$today->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $today,
        );
    }

    public function update(Request $request,$id){

        $data = $request->all();

        DB::beginTransaction();

        try{

            $dayObject = new Day;
            $dayObject->fill($data);
            
            $updating = Day::findOrFail($id)->update($dayObject->toArray());

            $updated_day = Day::findOrFail($id);


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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$updated_day->name.'(ID:'.$updated_day->id.") ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $updated_day,
        );
    }

    public function destroy($id){

        DB::beginTransaction();

        try{
            $days = Day::findOrFail($id);
    
            $deleted = $days->delete();
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$days->name.', ID:'.$days->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $days,
        );
    }

    public function trashed(){

        Log::info(label_case($this->module_title.' View'.__FUNCTION__).' | User:'.(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> Day::bookingonlyTrashed()->get(),
        );
    }

    public function restore($id){

        DB::beginTransaction();

        try{
            $restoring =  Day::bookingwithTrashed()->where('id',$id)->restore();
            $days = Day::findOrFail($id);
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

        Log::info(label_case(__FUNCTION__)." ".$this->module_title.": ".$days->name.", ID:".$days->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $days,
        );
    }

    public function purge($id){
        DB::beginTransaction();

        try{
            $days = Day::bookingwithTrashed()->findOrFail($id);
    
            $deleted = $days->forceDelete();
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

        Log::info(label_case($this->module_title.' '.__FUNCTION__)." | '".$days->name.', ID:'.$days->id." ' by User:".(Auth::user()->name ?? 'unknown').'(ID:'.(Auth::user()->id ?? "0").')');

        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $days,
        );
    }

    public function import(Request $request){
        $import = Excel::import(new DaysImport($request), $request->file('data_file'));
    
        return (object) array(
            'error'=> false,            
            'message'=> '',
            'data'=> $import,
        );
    }


}