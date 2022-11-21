<div class="row">
    <div class="col-lg-4">
        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">Tanggal </td>
                    <td>: {{$inspection->day->date}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Nomor Polisi </td>
                    <td>: {{$inspection->tanker->nomor_polisi}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Status </td>
                    <td>: {{$inspection->status}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-lg-4">
        <table>
            <tbody>
                <tr>
                    <td class="font-weight-bold">Nama AMT 1 </td>
                    <td>: {{$inspection->amt1}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">Nama AMT 2 </td>
                    <td>: {{$inspection->amt2}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>