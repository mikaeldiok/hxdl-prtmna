<?php

namespace Modules\Vehicle\Imports;

use App\Overrides\Zip;
use ZipArchive;
use Carbon\Carbon;
use Modules\Vehicle\Entities\Tanker;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TankersImport implements ToCollection, WithHeadingRow
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->module_title = Str::plural(class_basename(Tanker::class));
        $this->module_name = Str::lower($this->module_title);
        $this->request = $request;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            
            \Log::debug($row['tahun_registrasi']);
            if($row['tahun_registrasi']){
                $tahun_registrasi = convert_slash_to_basic_date($row['tahun_registrasi']);
            }
            if($row['exp_stnk']){
                $exp_stnk = convert_slash_to_basic_date($row['exp_stnk']);
            }
            if($row['exp_keur']){
                $exp_keur = convert_slash_to_basic_date($row['exp_keur']);
            }
            if($row['exp_tera']){
                $exp_tera = convert_slash_to_basic_date($row['exp_tera']);
            }
            if($row['exp_kip']){
                $exp_kip = convert_slash_to_basic_date($row['exp_kip']);
            }
            if($row['end_date_mt']){
                $end_date_mt = convert_slash_to_basic_date($row['end_date_mt']);
            }

            $tanker = Tanker::updateOrCreate([
                'nomor_polisi'              => $row['nomor_polisi'],
                'produk'                    => $row['produk'],
                'nama_perusahaan_transportir'                    => $row['nama_perusahaan_transportir'],
                'kategori_pengelola_mt'     => $row['kategori_pengelola_mt'],
                'tahun_registrasi'          => $tahun_registrasi,
                'merk_kepala'                => $row['merk_kepala'],
                'type'                     => $row['type'],
                'nomor_mesin'                    => $row['nomor_mesin'],
                'nomor_chassiss'                    => $row['nomor_chassiss'],
                'konfigurasi_sumbu_roda'                  => $row['konfigurasi_sumbu_roda'],
                'kategori'                  => $row['kategori'],
                'status_sewa_tarif'                  => $row['status_sewa_tarif'],
                'tujuan_angkutan'                  => $row['tujuan_angkutan'],
                'kap'                  => $row['kap'],
                'no_reg'                  => $row['no_reg'],
                'exp_stnk'                  => $exp_stnk,
                'exp_keur'                  => $exp_keur,
                'exp_tera'                  => $exp_tera,
                'exp_kip'                  => $exp_kip,
                'end_date_mt'                  => $end_date_mt,
                'keterangan_kip'                  => $row['keterangan_kip'],
                'keterangan_mt'                  => $row['keterangan_mt'],
                'data_tm_k1_t1'                  => $row['data_tm_k1_t1'],
                'data_tm_k1_t2'                  => $row['data_tm_k1_t2'],
                'data_tm_k1_t3'                  => $row['data_tm_k1_t3'],
                'data_tm_k2_t1'                  => $row['data_tm_k2_t1'],
                'data_tm_k2_t2'                  => $row['data_tm_k2_t2'],
                'data_tm_k2_t3'                  => $row['data_tm_k2_t3'],
                'data_tm_k3_t1'                  => $row['data_tm_k3_t1'],
                'data_tm_k3_t2'                  => $row['data_tm_k3_t2'],
                'data_tm_k3_t3'                  => $row['data_tm_k3_t3'],
                'nomor_surat_tera'                  => $row['nomor_surat_tera'],
                'keterengan'                  => $row['keterengan'],
            ]);
        }
    }
}