<!DOCTYPE html>
<html>
    <head>
        <title>Report</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
    </head>
    <body>
            Yth. Integrated Terminal Manager Ampenan, <br><br>
            Terlampir <strong>Hasil Pre-Trip Inspection Mobil Tangki</strong> pada <strong>{{$data->date}}</strong>
            
            @php
                $i = 1;
                $pretrip_avg = 0;
            @endphp
            @component('mail::table')
                | No   | No. Polisi | Hasil Pre Trip Inspection  |
                | ---- |:----------:| :----:|
                @foreach($data->inspections as $inspection)
                |{{$i}}| {{$inspection->tanker->nomor_polisi}} | {{$inspection->pretrip_percentage * 100}}% |
                    @php
                        $i +=1 ;
                        $pretrip_avg +=$inspection->pretrip_percentage;
                    @endphp
                @endforeach
            @endcomponent
            
            <p>Persentase Pre Trip Inspection: {{ round(($pretrip_avg / $data->count) * 100,2)}}%</p>

            @component('mail::table')
                |  |   |
                | :----| :----|
                | Pemeriksa          |      Approver |
                | Pengawas MT          |      HSSE IT Ampenan |
            @endcomponent
    </body>
</html>