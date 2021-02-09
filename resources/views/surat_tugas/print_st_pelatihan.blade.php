<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">

* { font-family: Segoe UI, Arial, sans-serif;  font-size: small }
    tr, td{ padding-left: 8px; }
    .pepet{ white-space:nowrap; width:1%; }
    .table-border{ border: 1px solid black; }
    .table-border td, th{ border: 1px solid black; }
    tfoot tr td{ font-weight: bold; font-size: x-small; }
    table{ border-collapse: collapse; }
    .table-woborder{ border: none; }
    .table-woborder td, th{ border: none; }
    td.table-woborder { border: none; }
    td.table-wobordertb { border-top: none; border-bottom: none; }
    .gray { background-color: lightgray }
    .page-break { page-break-after: always; }
    header {
        position: fixed;
        top: -40px;
        left: 0px;
        right: 0px;
    }

    footer {
        position: fixed; 
        bottom: -60px; 
        left: 0px; 
        right: 0px;
        height: 50px; 
        text-align: center;
        line-height: 35px;
    }
</style>

</head>
<body>
        <table width="100%">
            <tr>
                <td class="pepet">
                    <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:120px">
                </td>
                <td align="left">
                    <i><b>BADAN PUSAT STATISTIK</b></i><br/>
                    <i><b>
                    @if($unit_kerja_ttd!=null)
                        {{ strtoupper($unit_kerja_ttd->nama) }}
                    @else
                        {{ strtoupper($unit_kerja->nama) }}
                    @endif    
                </td>
            </tr>
        </table>

  <br/><br/><br/><br/><br/>

  <p align="center"><b><u>SURAT TUGAS</u></b></p>
  <p align="center">NOMOR : {{ $model_rincian->nomor_st }}</p>
  
    <br/>
    <br/>

  <table width="100%">
        <tr>
            <td width="10%"></td>
            <td colspan="3">Yang bertanda tangan di bawah ini:<br/><br/><br/></td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td colspan="3" align="center"><b>
                @if($unit_kerja_ttd!=null)
                    Kepala BPS {{ $unit_kerja_ttd->nama }}
                @else
                    Kepala BPS {{ $unit_kerja->nama }}
                @endif
            </b><br/><br/></td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td colspan="3">Memberi tugas kepada:<br/><br/></td>
            <td width="15%"></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Nama<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">TERLAMPIR<br/><br/></td>
            <td width="15%"></td>
        </tr>
        
        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Jabatan<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">TERLAMPIR<br/><br/></td>
            <td width="15%"></td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Tujuan Tugas</td>
            <td width="3%" valign="top">:</td>
            <td width="47%">
                @if(strlen($model_rincian->tujuan_tugas)>0)
                    {{ $model->tugas }} ke {{ $model_rincian->tujuan_tugas }}
                @else
                    {{ $model->tugas }}    
                @endif
            <br/><br/></td>
            <td width="15%"></td>
        </tr>
        
        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Waktu Pelaksanaan<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">TERLAMPIR<br/><br/></td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Pembebanan<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">
                @if ($model->sumber_anggaran!=3)
                    {{ $model->MakRel->KodeMak }}.{{ $model->listKodeJenis[5] }}
                @else
                    -
                @endif
                <br/><br/>
            </td>
            <td width="15%"></td>
        </tr>
  </table>

  <br/><br/>
  
  <table width="100%">
    <tr>
        <td width="15%"></td>
        <td width="25%" align="center"></td>
        <td width="10%"></td>
        <td width="35%" align="center">
            @if($unit_kerja_ttd!=null)
                {{ $unit_kerja_ttd->ibu_kota }}
            @else
                {{ $unit_kerja->ibu_kota }}
            @endif    
            , {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}<br/>
            Kepala Badan Pusat Statistik<br/> 
            
            @if($unit_kerja_ttd!=null)
                 {{ $unit_kerja_ttd->nama }}
            @else
                 {{ $unit_kerja->nama }}
            @endif
            <br/>
            <br/>
            <br/>
            <br/>
            <u>{{ $model_rincian->pejabat_ttd_nama }}</u><br/>
            NIP. {{ $model_rincian->pejabat_ttd_nip }} <br/>
        </td>
        <td width="10%"></td>
    </tr>
  </table>
    
    <div class="page-break"></div>

    <table width="100%">
        <tr>
            <td width="10%"></td>
            <td colspan="2">Lampiran Surat Tugas</td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="20%">Nomor</td>
            <td>: {{ $model_rincian->nomor_st }}</td>
        </tr>
        
        <tr>
            <td width="10%"></td>
            <td width="20%">Tanggal</td>
            <td>: {{ date('d M Y', strtotime($model_rincian->tanggal_mulai)) }}</td>
        </tr>
    </table>
    <br/><br/><br/>

    <table width="100%" class="table-border">
        <tr>
            <td width="3%">No</td>
            <td width="28%">Nama</td>
            <td width="21%">Jabatan</td>
            <td width="28%">Asal Daerah</td>
            <td width="20%">Kedudukan</td>
        </tr>
        @foreach($list_anggota as $key=>$value)
            <tr>
                <td width="3%">{{ $key+1 }}</td>
                <td width="32%">{{ $value->nama }}</td>
                <td width="15%">
                    @if(strlen($value->jabatan)>0)
                        {{ $value->jabatan }}
                    @else
                        Mitra
                    @endif
                </td>
                <td width="30%">{{ $value->asal_daerah }}</td>
                <td width="20%">{{ $value->jabatan_pelatihan }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>