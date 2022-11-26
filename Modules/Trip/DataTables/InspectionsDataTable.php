<?php

namespace Modules\Trip\DataTables;

use Carbon\Carbon;
use Auth;
use Illuminate\Support\HtmlString;
use Modules\Trip\Services\InspectionService;
use Modules\Trip\Entities\Inspection;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InspectionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(InspectionService $inspectionService)
    {
        $this->module_name = 'inspections';

        $this->inspectionService = $inspectionService;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('tanker.nomor_polisi', function ($data) {
                return '<a href="'.route("backend.$this->module_name.show", $data).'">'.$data->tanker->nomor_polisi.'</a>';
            })
            ->editColumn('pretrip_percentage', function ($data) {
                $true_perecentage = $data->pretrip_percentage * 100;

                if($true_perecentage == 100)
                {
                    $availability = '<p class="text-white text-center bg-success rounded">'.$true_perecentage.'% OK</p>';
                }else{
                    $availability = '<p class="text-white text-center bg-danger rounded">'.$true_perecentage.'% OK</p>';
                }

                return $availability;
            })
            ->editColumn('verify_by_pengawas', function ($data) {
                if($data->verify_by_pengawas)
                    return '<i class="fa-solid fa-check text-success"></i>';
                else
                    return '<i class="fa-solid fa-times text-danger"></i>';
            })
            ->editColumn('verify_by_hsse', function ($data) {
                if($data->verify_by_pengawas)
                    return '<i class="fa-solid fa-check text-success"></i>';
                else
                    return '<i class="fa-solid fa-times text-danger"></i>';
            })
            ->editColumn('day.date', function ($data) {

                $formated_date = Carbon::parse($data->day->date)->format('d/m/Y');

                return $formated_date;
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('LLLL');
                }
            })
            ->editColumn('created_at', function ($data) {
                $module_name = $this->module_name;

                $formated_date = Carbon::parse($data->created_at)->format('d-m-Y, H:i:s');

                return $formated_date;
            })
            ->rawColumns(['tanker.nomor_polisi', 'action','photo','available','verify_by_pengawas','verify_by_hsse','pretrip_percentage']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Inspection $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user = auth()->user();
        $data = Inspection::query()->with('tanker')->with('day');

        if($this->request()->get('date')){
            $data->whereHas('day', function($query){
                $query->where('date', 'LIKE', "%".$this->request()->get('date')."%");
            });
        }

        return $this->applyScopes($data);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $created_at = 0;
        return $this->builder()
                ->setTableId('inspections-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->dom(config('mk-datatables.mk-dom'))
                ->orderBy($created_at,'desc')
                ->buttons(
                    Button::make('export'),
                    Button::make('print'),
                    Button::make('reset')->className('rounded-right'),
                    Button::make('colvis')->text('Kolom')->className('m-2 rounded btn-info'),
                )->parameters([
                    'paging' => true,
                    'searching' => true,
                    'info' => true,
                    'responsive' => true,
                    'autoWidth' => false,
                    'searchDelay' => 350,
                ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if(Auth::user()->hasRole("hsse")){
            return [
                Column::make('id')->hidden(),
                Column::make('day.date')->data('day.date')->title("Tanggal")->hidden(),
                Column::make('tanker.nomor_polisi')->data('tanker.nomor_polisi')->title("Nomor Polisi"),
                Column::make('amt1')->title("AMT1"),
                Column::make('amt2')->title("AMT2"),
                Column::make('pretrip_percentage')->title("Hasil Pre Trip Inspection"),
                Column::make('keterangan_penyelesaian')->title("Keterangan"),
                Column::make('estimasi_penyelesaian')->title("Due Date"),
                Column::make('verify_by_pengawas')->title("Check"),
                Column::make('verify_by_hsse')->title("Gate In Approval"),
                Column::make('created_at')->hidden(),
                Column::make('updated_at')->hidden(),
            ];
        }else{
            return [
                Column::make('id')->hidden(),
                Column::make('day.date')->data('day.date')->title("Tanggal")->hidden(),
                Column::make('tanker.nomor_polisi')->data('tanker.nomor_polisi')->title("Nomor Polisi"),
                Column::make('amt1')->title("AMT1"),
                Column::make('amt2')->title("AMT2"),
                Column::make('pretrip_percentage')->title("Hasil Pre Trip Inspection"),
                Column::make('keterangan_penyelesaian')->title("Keterangan"),
                Column::make('estimasi_penyelesaian')->title("Due Date"),
                Column::make('verify_by_pengawas')->title("Check"),
                Column::make('created_at')->hidden(),
                Column::make('updated_at')->hidden(),
            ];
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Inspections_' . date('YmdHis');
    }
}