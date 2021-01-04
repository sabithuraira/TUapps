<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * { font-family: Segoe UI, Arial, sans-serif; }
    tr, td{ padding-left: 8px; }
    .table-border{ border: 1px solid black; }
    .table-border td, th{ border: 1px solid black; }
    tfoot tr td{ font-weight: bold; font-size: x-small; }
    .gray { background-color: lightgray }
</style>

</head>
<body>
  <table width="100%">
    <tr>
        <td>
            <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:100px">
        </td>
        <td>
            <h2>BADAN PUSAT STATISTIK</h2>
            <h2>
                {{ strtoupper($unit_kerja->nama) }}
            </h2>
        </td>
        <td align="center">
        </td>
    </tr>
  </table>

  <p align="center"><b><u>SURAT TUGAS</u></b></p>
  <p align="center">NOMOR : {{ $model_rincian->nomor_st }}</p>

  <table width="100%" class="table-border">
        <tr>
            <td width=""></td>
        </tr>
  </table>


  <br/>
  
  <table width="100%">
    <tr>
        <td width="15%"></td>
        <td width="25%" align="center">
        </td>
        <td width="10%"></td>
        <td width="35%" align="center">
            <p>{{ $unit_kerja->ibu_kota }}, {{ date('d M Y', strtotime($model_rincian->created_at)) }}</p>
            <p>Kepala BPS {{ $unit_kerja->nama }}</p>
            <br/>
            <br/>
            <u>{{ $model_rincian->pejabat_ttd_nama }}</u><br/>
            NIP. {{ $model_rincian->pejabat_ttd_nip }} <br/>
        </td>
        <td width="10%"></td>
    </tr>

  </table>

</body>
</html>