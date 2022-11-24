<?php

namespace Modules\Trip\DataTables;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Modules\Trip\Services\DayService;
use Modules\Trip\Entities\Day;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DaysDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(DayService $dayService)
    {
        $this->module_name = 'days';

        $this->dayService = $dayService;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('date', function ($data) {
                return '<a href="'.route("backend.$this->module_name.show", $data).'">'.$data->date.'</a>';
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
            ->rawColumns(['date', 'action','photo','available']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Day $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user = auth()->user();
        $data = Day::query();

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
                ->setTableId('days-table')
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
        return [
            Column::make('id')->hidden(),
            Column::make('date')->title("Tanggal"),
            Column::make('pengawas')->title("Pengawas"),

            Column::make('created_at')->hidden(),
            Column::make('updated_at')->hidden(),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Days_' . date('YmdHis');
    }
}