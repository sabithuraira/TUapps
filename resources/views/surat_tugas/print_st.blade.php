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
    .gray { background-color: lightgray }
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
    <header>
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
    </header>

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
            <td width="47%">
            @if($model->kategori==2)    
                {{ $ketua->nama }}
            @else
                {{ $model_rincian->nama }}
            @endif
            <br/><br/></td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="25%">NIP<br/><br/></td>
            <td width="3%">:</td>
            <td width="47%">
                @if($model->kategori==2)    
                    @if($ketua->jenis_petugas==2)
                        -
                    @else
                        {{ $ketua->nip }}
                    @endif
                @else
                    @if($model_rincian->jenis_petugas==2)
                        -
                    @else
                        {{ $model_rincian->nip }}
                    @endif
                @endif

            <br/><br/></td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Jabatan<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">
                @if($model->kategori==2)
                    @if($ketua->jenis_petugas==2)
                        Mitra
                    @else
                        @if(substr($ketua->jabatan,0, 10)=="Kepala BPS")
                            Kepala BPS {{ $unit_kerja->nama }}
                        @else
                            {{ $ketua->jabatan }}
                        @endif
                    @endif
                @else
                    @if($model_rincian->jenis_petugas==2)
                        Mitra
                    @else
                        @if(substr($model_rincian->jabatan,0, 10)=="Kepala BPS")
                            Kepala BPS {{ $unit_kerja->nama }}
                        @else
                            {{ $model_rincian->jabatan }}
                        @endif
                    @endif
                @endif
                <br/><br/></td>
            <td width="15%"></td>
        </tr>

        @if($model->kategori==2 & count($list_anggota)>0)
            <tr>
                <td width="10%"></td>
                <td width="25%" valign="top">Anggota<br/><br/></td>
                <td width="3%" valign="top">:</td>
                <td width="47%">
                    @if($list_anggota[0]->jenis_petugas==2)
                        1. {{ $list_anggota[0]->nama }} / Mitra
                    @else
                        1. {{ $list_anggota[0]->nama }} / {{ $list_anggota[0]->jabatan }}
                    @endif
                </td>
                <td width="15%"></td>
            </tr>

            @foreach ($list_anggota as $k=>$v)
                @if (!$loop->first)
                    <tr>
                        <td width="10%"></td>
                        <td width="25%" valign="top"><br/><br/></td>
                        <td width="3%" valign="top"></td>
                        <td width="47%">
                            @if($v->jenis_petugas==2)
                                {{ $k+1 }}. {{ $v->nama }} / Mitra
                            @else   
                                {{ $k+1 }}. {{ $v->nama }} / {{ $v->jabatan }} 
                            @endif
                        </td>
                        <td width="15%"></td>
                    </tr>
                @endif
            @endforeach
        @endif

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
            <td width="47%">
                @if (date('n', strtotime($model_rincian->tanggal_mulai))==date('n', strtotime($model_rincian->tanggal_selesai)))
                    @if(date('Y-m-d', strtotime($model_rincian->tanggal_mulai))==date('Y-m-d', strtotime($model_rincian->tanggal_selesai)))
                        {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                    @else
                        {{ date('d', strtotime($model_rincian->tanggal_mulai)) }}
                        s.d 
                        {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                    @endif
                @else
                    {{ date('d', strtotime($model_rincian->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }} {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}
                    s.d 
                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}                
                @endif
                <br/><br/>
            </td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="10%"></td>
            <td width="25%" valign="top">Pembebanan<br/><br/></td>
            <td width="3%" valign="top">:</td>
            <td width="47%">
                @if ($model->sumber_anggaran!=3)
                    {{ $model->MakRel->KodeMak }}
                    @if ($model->jenis_st!=4)
                        .{{ $model->listKodeJenis[$model->jenis_st] }}
                    @endif
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
            
            <!-- cek jika unit kerja bukan kepala dari unit kerja -->
            @if($unit_kerja_ttd!=null)
                @if($unit_kerja_ttd->kepala_nip!=$model_rincian->pejabat_ttd_nip)
                    an. 
                @endif
            @else
                @if($unit_kerja->kepala_nip!=$model_rincian->pejabat_ttd_nip)
                    an. 
                @endif
            @endif

            Kepala Badan Pusat Statistik<br/> 
            
            @if($unit_kerja_ttd!=null)
                 {{ $unit_kerja_ttd->nama }}
                 @if($unit_kerja_ttd->kepala_nip!=$model_rincian->pejabat_ttd_nip)
                    <br/><br/>{{ $user_ttd->nmjab }}
                @endif
            @else
                 {{ $unit_kerja->nama }}
                 @if($unit_kerja->kepala_nip!=$model_rincian->pejabat_ttd_nip)
                    <br/><br/>{{ $user_ttd->nmjab }}
                @endif
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

</body>
</html>