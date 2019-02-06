<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border-collapse: collapse;
    }

    tr, td{
        padding-left: 8px;
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

</head>
<body>

  <table width="100%">
    <tr>
        <td width="80%"/></td>
        <td align="center">
            @if ($type == 1)
                <h4 class="text-center" style='border:2px #444444 solid;'>CKP-T</h4>
            @else
                <h4 class="text-center" style='border:2px #444444 solid;'>CKP-R</h4>
            @endif
        </td>
    </tr>
  </table>

  <h3 align="center">CAPAIAN KINERJA PEGAWAI TAHUN 2019</h3>

  <table width="100%">
    <tr><td width="15%">Satuan Organisasi</td><td>: {{ $user->nmorg }}</td></tr>
    <tr><td>Nama</td><td>: {{ $user->name }}</td></tr>
    <tr><td>Jabatan</td><td>: {{ $user->nmjab }}</td></tr>
    <tr><td>Periode</td><td>: 1 -  {{ $last_day_month }} {{ $monthName }} {{ $year }}</td></tr>
  </table>

  <table width="100%" class="table-border">
    <thead>
    <tr align="center">
            
            @if ($type == 1)
                <th>No</th>
                <th width="40%">{{ $model->attributes()['uraian'] }}</th>
                <th>{{ $model->attributes()['satuan'] }}</th>
                <th>Target Kuantitas</th>
                <th>{{ $model->attributes()['kode_butir'] }}</th>
                <th>{{ $model->attributes()['angka_kredit'] }}</th>
                <th>{{ $model->attributes()['keterangan'] }}</th>
            @else
                <th rowspan="2">No</th>
                <th rowspan="2"  width="40%">{{ $model->attributes()['uraian'] }}</th>
                <th rowspan="2">{{ $model->attributes()['satuan'] }}</th>
                
                <th colspan="3">Kuantitas</th>
                <th rowspan="2">Tingkat Kualitas</th>
                
                <th rowspan="2">{{ $model->attributes()['kode_butir'] }}</th>
                <th rowspan="2">{{ $model->attributes()['angka_kredit'] }}</th>
                <th rowspan="2">{{ $model->attributes()['keterangan'] }}</th>
            
            @endif
        </tr>

        @if ($type != 1)
            <tr>
                <th>Target</th>
                <th>Realisasi</th>
                <th>%</th>
            </tr>
        @endif
    </thead>

    <tbody>
        @php
            $no_column = 1;
            $total_column = ($type==1) ? 7 : 10;
            $total_jumlah_column = ($type==1) ? 6 : 9;
            $total_rata_column = ($type==1) ? 3 : 6;
        @endphp

        <tr align="center">
            <td>({{ $no_column++ }})</td>
            <td>({{ $no_column++ }})</td>
            <td>({{ $no_column++ }})</td>
            <td>({{ $no_column++ }})</td>
            
            @if ($type == 2)
                <td>({{ $no_column++ }})</td>
                <td>({{ $no_column++ }})</td>
                <td>({{ $no_column++ }})</td>
            @endif

            <td>({{ $no_column++ }})</td>
            <td>({{ $no_column++ }})</td>
            <td>({{ $no_column++ }})</td>
        </tr>
        
        <tr><td colspan="{{ $total_column }}"><b>UTAMA</b></td></tr>
        @foreach($datas['utama'] as $key=>$data)
        
            <tr>
                <td align="center">{{ $key+1 }}</td>
                <td>{{$data->uraian }}</td>
                <td>{{$data->satuan }}</td>
                <td align="center">{{$data->target_kuantitas }}</td>

                @if ($type == 2)
                    <td>{{ $data->realisasi_kuantitas }}</td>
                    <td>%</td>
                    <td>{{ $data->kualitas }}</td>
                @endif

                <td>{{ $data->kode_butir }}</td>
                <td>{{ $data->angka_kredit }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach

        
        <tr><td colspan="{{ $total_column }}"><b>TAMBAHAN</b></td></tr>
        @foreach($datas['tambahan'] as $key=>$data)
        
            <tr>
                <td align="center">{{ $key+1 }}</td>
                <td>{{$data->uraian }}</td>
                <td>{{$data->satuan }}</td>
                <td align="center">{{$data->target_kuantitas }}</td>

                @if ($type == 2)
                    <td>{{ $data->realisasi_kuantitas }}</td>
                    <td>%</td>
                    <td>{{ $data->kualitas }}</td>
                @endif

                <td>{{ $data->kode_butir }}</td>
                <td>{{ $data->angka_kredit }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach

        
        <tr align="center">
            <td colspan="{{ $total_jumlah_column }}"><b>JUMLAH</b></td>
            <td>100</td>
        </tr>

        @if ($type!=1)
        <tr align="center">
            <td colspan="{{ $total_rata_column }}"><b>RATA-RATA</b></td>
            <td>100</td>
            <td>100</td>
            <td></td>
        </tr>
        
        <tr align="center">
            <td colspan="{{ $total_rata_column }}"><b>CAPAIAN KINERJA PEGAWAI (CKP)</b></td>
            <td colspan="2">100</td>
            <td></td>
        </tr>
        @endif
    </tbody>
  </table>

  <br/>
  <table width="30%">
      
    @if ($type!=1)
        <tr><td><b>Kesepakatan Target</b></td></tr>
        <tr><td>Tanggal : {{ $first_working_day }}</td></tr>
    @else
        <tr><td><b>Penilaian Kinerja</b></td></tr>
        <tr><td>Tanggal : {{ $last_working_day }}</td></tr>
    @endif
  </table>
  
  <br/>

  
  <table width="100%">
    <tr>
        <td width="15%"></td>
        <td width="25%" align="center">
            <p>Pegawai Yang Dinilai</p>
            <br/>
            <br/>
            ( {{ $user->name }} )<br/>
            NIP.  {{ $user->nip_baru }}
        </td>
        <td width="20%"></td>
        <td width="25%" align="center">
            <p>Pejabat Penilai</p>
            <br/>
            <br/>
            ( Bambang Sri Yuwono)<br/>
            NIP.  19671112 199101 1 001<br/>
        </td>
        <td width="15%"></td>
    </tr>

  </table>

</body>
</html>