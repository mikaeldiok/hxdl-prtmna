
<div class="row">
    <div class="col-lg-3">
        <h4 class="my-3">Masa Berlaku</h4>
        @php
        function checkDiff($date){
            $the_date = Carbon\Carbon::parse($date);
            $today = Carbon\Carbon::today();
            $diff = $today->diffInDays($the_date);
            
            if($the_date < $today){
                return "bg-black";
            }else{
                if($diff <= 3){
                    return "bg-danger";
                }else if($diff <= 7){
                    return "bg-orange";
                }else if($diff <= 30){
                    return "bg-yellow";
                }else{
                    return "bg-success";
                }
            }
            return $diff;
        }
        @endphp

        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">STNK </td>
                    <td>: {{convert_basic_to_slash_date($tanker->exp_stnk)}} </td>
                    <td> <span class="{{checkDiff($tanker->exp_stnk)}}">-----</span></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">KEUR </td>
                    <td>: {{convert_basic_to_slash_date($tanker->exp_keur)}}</td>
                    <td> <span class="{{checkDiff($tanker->exp_keur)}}">-----</span></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">TERA </td>
                    <td>: {{convert_basic_to_slash_date($tanker->exp_tera)}}</td>
                    <td> <span class="{{checkDiff($tanker->exp_tera)}}">-----</span></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">KIP </td>
                    <td>: {{convert_basic_to_slash_date($tanker->exp_kip)}}</td>
                    <td> <span class="{{checkDiff($tanker->exp_kip)}}">-----</span></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">MT </td>
                    <td>: {{convert_basic_to_slash_date($tanker->end_date_mt)}}</td>
                    <td> <span class="{{checkDiff($tanker->end_date_mt)}}">-----</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4">
        <h4 class="my-3">Detail Mobil Tangki</h4>
        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">Produk </td>
                    <td>: {{$tanker->produk ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Pemilik Mobil </td>
                    <td>: {{$tanker->nama_perusahaan_transportir ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Pengelola Mobil </td>
                    <td>: {{$tanker->kategori_pengelola_mt ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Tanggal Registrasi </td>
                    <td>: {{convert_basic_to_slash_date($tanker->tahun_registrasi) ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Merk (kepala) </td>
                    <td>: {{$tanker->merk_kepala ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Type </td>
                    <td>: {{$tanker->type ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Tujuan Angkutan </td>
                    <td>: {{$tanker->tujuan_angkutan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Kapasitas (KL) </td>
                    <td>: {{$tanker->kap ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">No. Reg</td>
                    <td>: {{$tanker->no_reg ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Nomor Mesin</td>
                    <td>: {{$tanker->nomor_mesin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Nomor Chassiss</td>
                    <td>: {{$tanker->nomor_chassiss ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-5">
        <h4 class="my-3">Data Tera Metrologi</h4>
        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">Nomor Surat Tera</td>
                    <td>: {{$tanker->nomor_surat_tera ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Masa Berlaku Tera</td>
                    <td>: {{convert_basic_to_slash_date($tanker->exp_tera) ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Kompartmen I (mm) </td>
                    <td></td>
                </tr>
                    <tr>
                        <td class="font-weight-bold">T1 </td>
                        <td>: {{$tanker->data_tm_k1_t1 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T2 </td>
                        <td>: {{$tanker->data_tm_k1_t2 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T3 </td>
                        <td>: {{$tanker->data_tm_k1_t3 ?? '-' }}</td>
                    </tr>
                <tr>
                    <td class="font-weight-bold">Kompartmen II (mm) </td>
                    <td></td>
                </tr>
                    <tr>
                        <td class="font-weight-bold">T1 </td>
                        <td>: {{$tanker->data_tm_k2_t1 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T2 </td>
                        <td>: {{$tanker->data_tm_k2_t2 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T3 </td>
                        <td>: {{$tanker->data_tm_k2_t3 ?? '-' }}</td>
                    </tr>
                <tr>
                    <td class="font-weight-bold">Kompartmen III (mm) </td>
                    <td></td>
                </tr>
                    <tr>
                        <td class="font-weight-bold">T1 </td>
                        <td>: {{$tanker->data_tm_k3_t1 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T2 </td>
                        <td>: {{$tanker->data_tm_k3_t2 ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">T3 </td>
                        <td>: {{$tanker->data_tm_k3_t3 ?? '-' }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>