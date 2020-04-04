
<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border-collapse: collapse;
    }

    tr, td{
        padding-left: 4px;
    }

    .table-border{
        border: 1px solid black;
    }
    
    .table-border td, th{
        border: 1px solid black;

    }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .gray {
        background-color: lightgray
    }
</style>

<table>
    <tbody>
        <tr class="text-center">
            <th colspan="7"><h1>LAPORAN PELAKSANAN TUGAS HARIAN SELAMA PERIODE WORK FROM HOME</h1></th>
        </tr>
        
        <tr>
            <td colspan="2">NAMA</td>
            <td colspan="2">: {{ $user->name }}</td>
        </tr>
        
        <tr>
            <td colspan="2">UNIT KERJA</td>
            <td colspan="2">: {{ $user->nmorg }} {{ $user->nmwil }}</td>
        </tr>
        
        <tr>
            <td colspan="2">TANGGAL</td>
            <td colspan="2">: {{ date('d M Y', strtotime($tanggal)) }}</td>
        </tr>
    </tbody>
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">DESKRIPSI PEKERJAAN/PENUGASAN</th>
            <th colspan="2">KUANTITAS</th>
            <th rowspan="2">DURASI WAKTU PENGERJAAN</th>
            <th rowspan="2">PEMBERI TUGAS</th>
            <th rowspan="2">STATUS PENYELESAIAN</th>
        </tr>
        
        <tr class="text-center">
            <th>VOLUME</th>
            <th>SATUAN</th>
        </tr>
        
        <tr>
            <th>[1]</th>
            <th>[2]</th>
            <th>[3]</th>
            <th>[4]</th>
            <th>[5]</th>
            <th>[6]</th>
            <th>[7]</th>
        </tr>
    </thead>

    <tbody>
        @foreach($datas as $key=>$data)
            @php
                $mulai_time = strtotime("2020-10-10 ".$data['waktu_mulai'].":00");
                $selesai_time = strtotime("2020-10-10 ".$data['waktu_selesai'].":00");
                $selisih_time = round(abs($selesai_time - $mulai_time) / 60,2)." menit";
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $data['isi'] }}</td>
                <td>{{ $data['volume'] }}</td>
                <td>{{ $data['satuan'] }}</td>
                <td>{{ $selisih_time }}</td>
                <td>{{ $data['pemberi_tugas'] }}</td>
                <td>{{ $data['status_penyelesaian'] }} %</td>
            </tr>
        @endforeach
    </tbody>
</table>