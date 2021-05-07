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

    tr, td{ padding-left: 8px; }

    .table-border{ border: 1px solid black; }
    
    .table-border td, th{ border: 1px solid black; }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .gray { background-color: lightgray }
</style>

</head>
<body>
    <h4 align="center">
        FORMULIR SASARAN KERJA<br/>
        PEGAWAI NEGERI SIPIL
    </h4>

  <table width="100%" class="table-border">
    <tbody>
        <tr>
            <td><b>NO</b></td>
            <td colspan="2"><b>I. PEJABAT PENILAI</b></td>
            <td><b>NO</b></td>
            <td colspan="6"><b>II. PEGAWAI NEGERI SIPIL YANG DINILAI</b></td>
        </tr>
        
        <tr>
            <td>1</td><td>Nama</td><td>{{ $user_target->name }}</td>
            <td>1</td><td colspan="2">Nama</td><td colspan="4">{{ $user_pimpinan->name }}</td>
        </tr>
        <tr>
            <td>2</td><td>NIP</td><td>{{ $user_target->nip_baru }}</td>
            <td>2</td><td colspan="2">NIP</td><td colspan="4">{{ $user_pimpinan->nip_baru }}</td>
        </tr>
        <tr>
            <td>3</td><td>Pangkat/Gol.Ruang</td><td>{{ $skp_induk->user_pangkat }}/{{ $skp_induk->user_gol }}</td>
            <td>3</td><td colspan="2">Pangkat/Gol.Ruang</td><td colspan="4">{{ $skp_induk->pimpinan_pangkat }}/{{ $skp_induk->pimpinan_gol }}</td>
        </tr>
        <tr>
            <td>4</td><td>Jabatan</td><td>{{ $skp_induk->user_jabatan }}</td>
            <td>4</td><td colspan="2">Jabatan</td><td colspan="4">{{ $skp_induk->pimpinan_jabatan }}</td>
        </tr>
        <tr>
            <td>5</td><td>Unit Kerja</td><td>{{ $skp_induk->user_unit_kerja }}</td>
            <td>5</td><td colspan="2">Unit Kerja</td><td colspan="4">{{ $skp_induk->pimpinan_unit_kerja }}</td>
        </tr>
        
        <tr>
            <td rowspan="2"><b>NO</b></td>
            <td colspan="2"  rowspan="2"><b>III. KEGIATAN TUGAS JABATAN</b></td>
            <td rowspan="2"><b>AK</b></td>
            <td colspan="6" align="center"><b>TARGET</b></td>
        </tr>
        
        <tr align="center">
            <td colspan="2"><b>KUANT/OUTPUT</b></td>
            <td><b>KUAL/MUTU</b></td>
            <td colspan="2"><b>WAKTU</b></td>
            <td><b>BIAYA</b></td>
        </tr>
        
        @foreach($skp_target as $key=>$data)
            <tr>
                <td>{{ $key+1 }}</td>
                <td colspan="2">{{ $data->uraian }}</td>
                <td>{{ $data->angka_kredit }}</td>
                <td>{{ $data->target_kuantitas }}</td>
                <td>{{ $data->satuan }}</td>
                <td>{{ $data->target_kualitas }}</td>
                <td>{{ $data->waktu }}</td>
                <td>{{ $data->satuan_waktu }}</td>
                <td>{{ $data->biaya }}</td>
            </tr>
        @endforeach
    </tbody>
  </table>
  
  <br/>
  <table width="100%">
    <tr>
        <td width="15%"></td>
        <td width="30%" align="center">
            <p>Pejabat Penilai</p>
            <br/>
            <br/>
            ( {{ $user_pimpinan->name }} )<br/>
            NIP.   {{ $user_pimpinan->nip_baru }} <br/>
        </td>
        <td width="10%"></td>
        <td width="30%" align="center">
            <p>Pegawai Yang Dinilai</p>
            <br/>
            <br/>
            ( {{ $user_target->name }} )<br/>
            NIP.  {{ $user_target->nip_baru }}
        </td>
        <td width="15%"></td>
    </tr>

  </table>

</body>
</html>