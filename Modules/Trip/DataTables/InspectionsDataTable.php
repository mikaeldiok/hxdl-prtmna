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
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('pretrip_percentage', function ($data) {
                return ($data->pretrip_percentage * 100)."% OK";
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
            ->rawColumns(['name', 'action','photo','available']);
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
        $created_at = 1;
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
                Column::computed('action')
                      ->exportable(false)
                      ->printable(false)
                      ->addClass('text-center'),
                Column::make('id')->hidden(),
                Column::make('tanker.nomor_polisi')->title("Nomor Polisi"),
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
                Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->addClass('text-center'),
                Column::make('id')->hidden(),
                Column::make('tanker.nomor_polisi')->title("Nomor Polisi"),
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