<?php

namespace Modules\Vehicle\DataTables;

use Carbon\Carbon;
use Illuminate\Support\HtmlString;
use Modules\Vehicle\Services\TankerService;
use Modules\Vehicle\Entities\Tanker;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TankersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function __construct(TankerService $tankerService)
    {
        $this->module_name = 'tankers';

        $this->tankerService = $tankerService;
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
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
            ->editColumn('tahun_registrasi', function ($data) {

                $formated_date = Carbon::parse($data->tahun_registrasi)->format('d-m-Y');

                return $formated_date;
            })
            ->editColumn('exp_stnk', function ($data) {

                $formated_date = Carbon::parse($data->exp_stnk)->format('d-m-Y');

                return $formated_date;
            })
            ->editColumn('exp_keur', function ($data) {

                $formated_date = Carbon::parse($data->exp_keur)->format('d-m-Y');

                return $formated_date;
            })
            ->editColumn('exp_tera', function ($data) {

                $formated_date = Carbon::parse($data->exp_tera)->format('d-m-Y');

                return $formated_date;
            })
            ->editColumn('exp_kip', function ($data) {

                $formated_date = Carbon::parse($data->exp_kip)->format('d-m-Y');

                return $formated_date;
            })
            ->editColumn('end_date_mt', function ($data) {

                $formated_date = Carbon::parse($data->end_date_mt)->format('d-m-Y');

                return $formated_date;
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
     * @param \App\Tanker $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user = auth()->user();
        $data = Tanker::query();

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
                ->setTableId('tankers-table')
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->addClass('text-center'),
            Column::make('id')->hidden(),
            Column::make('nomor_polisi')->title("nomor_polisi"),
            Column::make('produk')->title("produk"),
            Column::make('nama_perusahaan_transportir')->title("nama_perusahaan_transportir"),
            Column::make('kategori_pengelola_mt')->title("kategori_pengelola_mt")->hidden(),
            Column::make('tahun_registrasi')->title("tahun_registrasi")->hidden(),
            Column::make('merk_kepala')->title("merk_kepala")->hidden(),
            Column::make('type')->title("type"),
            Column::make('nomor_mesin')->title("nomor_mesin")->hidden(),
            Column::make('nomor_chassiss')->title("nomor_chassiss")->hidden(),
            Column::make('konfigurasi_sumbu_roda')->title("konfigurasi_sumbu_roda")->hidden(),
            Column::make('kategori')->title("kategori")->hidden(),
            Column::make('status_sewa_tarif')->title("status_sewa_tarif")->hidden(),
            Column::make('tujuan_angkutan')->title("tujuan_angkutan")->hidden(),
            Column::make('kap')->title("kap")->hidden(),
            Column::make('no_reg')->title("no_reg")->hidden(),

            Column::make('exp_stnk')->title("exp_stnk")->hidden(),
            Column::make('exp_keur')->title("exp_keur")->hidden(),
            Column::make('exp_tera')->title("exp_tera")->hidden(),
            Column::make('exp_kip')->title("exp_kip")->hidden(),

            Column::make('end_date_mt')->title("end_date_mt")->hidden(),
            Column::make('keterangan_kip')->title("keterangan_kip")->hidden(),
            Column::make('keterangan_mt')->title("keterangan_mt")->hidden(),

            Column::make('data_tm_k1_t1')->title("data_tm_k1_t1")->hidden(),
            Column::make('data_tm_k1_t1')->title("data_tm_k1_t1")->hidden(),
            Column::make('data_tm_k1_t1')->title("data_tm_k1_t1")->hidden(),

            Column::make('data_tm_k2_t1')->title("data_tm_k2_t1")->hidden(),
            Column::make('data_tm_k2_t1')->title("data_tm_k2_t1")->hidden(),
            Column::make('data_tm_k2_t1')->title("data_tm_k2_t1")->hidden(),

            Column::make('data_tm_k3_t1')->title("data_tm_k3_t1")->hidden(),
            Column::make('data_tm_k3_t1')->title("data_tm_k3_t1")->hidden(),
            Column::make('data_tm_k3_t1')->title("data_tm_k3_t1")->hidden(),

            Column::make('nomor_surat_tera')->title("nomor_surat_tera")->hidden(),
            Column::make('keterangan')->title("keterangan")->hidden(),
            Column::make('created_at'),
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
        return 'Tankers_' . date('YmdHis');
    }
}