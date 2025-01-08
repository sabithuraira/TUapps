<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <style type="text/css">
        * {
            font-family: Segoe UI, Arial, sans-serif;
            font-size: small
        }

        tr,
        td {
            padding-left: 8px;
        }

        ol.list-normal{
            padding-left: 15px;
            margin-top: 0;
        }

        ol.alphabetic-list {
            list-style-type: lower-alpha;
        }

        .pepet {
            white-space: nowrap;
            width: 1%;
        }

        .table-border {
            border: 1px solid black;
        }

        .table-border td,
        th {
            border: 1px solid black;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

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
            <td align="center">
                <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:120px">
                <br/>
                <i><b>BADAN PUSAT STATISTIK</b></i><br />
                <i><b>
                        @if ($unit_kerja_ttd != null)
                            {{ strtoupper($unit_kerja_ttd->nama) }}
                        @else
                            {{ strtoupper($unit_kerja->nama) }}
                        @endif
            </td>
        </tr>
    </table>

    <br /><br />

    <p align="center">SURAT TUGAS</p>
    <p align="center">NOMOR  {{ $model_rincian->nomor_st }}</p>

    <br /><br />

    
    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="25%" valign="top">Menimbang<br/></td>
            <td width="3%" valign="top">:</td>
            <td width="62%">
                <ol type="a" class="list-normal">
                    {!! $model->menimbang !!}
                </ol>
            </td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="25%" valign="top">Mengingat<br/></td>
            <td width="3%" valign="top">:</td>
            <td width="62%">
                <ol class="list-normal">
                    <li>Undang – Undang Nomor 16 Tahun 1997 Tentang Statistik</li>
                    <li>Peraturan Pemerintah Nomor 51 Tahun 1999 Tentang Penyelenggaraan Statistik;</li>
                    <li>Peraturan Presiden Republik Indonesia Nomor 86 Tahun 2007 Tentang Badan Pusat Statistik;</li>
                    <li>Peraturan Badan Pusat Statistik Nomor 7 Tahun 2020 tentang Organisasi dan Tata Kerja Badan Pusat Statistik;</li>
                    <li>Peraturan Badan Pusat Statistik Nomor 5 Tahun 2023 tentang Organisasi dan Tata Kerja Badan Pusat Statistik Provinsi dan Badan Pusat Statistik Kabupaten/Kota;</li>
                    {!! $model->mengingat !!}
                </ol>
            </td>
            <td width="5%"></td>
        </tr>

        <tr>
            <td width="5%"></td>
            <td colspan="3" align="center">Memberi Tugas<br /><br /></td>
            <td width="5%"></td>
        </tr>

        <tr>
            <td width="5%"></td>
            <td width="25%" valign="top">Kepada<br /><br /></td>
            <td width="3%" valign="top">:</td>
            <td width="62%">
                @if ($model->kategori == 2)
                    {{ $ketua->nama }}
                @else
                    {{ $model_rincian->nama }}<br/>
                    @if ($model_rincian->jenis_petugas == 2)
                        Mitra
                    @else
                        @if (substr($model_rincian->jabatan, 0, 10) == 'Kepala BPS')
                            Kepala BPS {{ $unit_kerja->nama }}
                        @else
                            {{ $model_rincian->jabatan }}
                        @endif
                    @endif
                @endif
                <br /><br />
            </td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="25%" valign="top">Untuk<br /><br /></td>
            <td width="3%" valign="top">:</td>
            <td width="62%">
                @if (strlen($model_rincian->tujuan_tugas) > 0 && $model_rincian->tujuan_tugas!='-')
                    {{ $model->tugas }} ke {{ $model_rincian->tujuan_tugas }}
                @else
                    {{ $model->tugas }}
                @endif
                 pada tanggal 

                @if (date('n', strtotime($model_rincian->tanggal_mulai)) == date('n', strtotime($model_rincian->tanggal_selesai)))
                    @if (date('Y-m-d', strtotime($model_rincian->tanggal_mulai)) ==
                            date('Y-m-d', strtotime($model_rincian->tanggal_selesai)))
                        {{ date('d', strtotime($model_rincian->tanggal_selesai)) }}
                        {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }}
                        {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                    @else
                        {{ date('d', strtotime($model_rincian->tanggal_mulai)) }}
                        s.d
                        {{ date('d', strtotime($model_rincian->tanggal_selesai)) }}
                        {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }}
                        {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                    @endif
                @else
                    {{ date('d', strtotime($model_rincian->tanggal_mulai)) }}
                    {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }}
                    {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}
                    s.d
                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }}
                    {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }}
                    {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                @endif
                <br /><br />
            </td>
            <td width="5%"></td>
        </tr>

        @if (($model->kategori == 2) & (count($list_anggota) > 0))
            <tr>
                <td width="5%"></td>
                <td width="25%" valign="top">Anggota<br /><br /></td>
                <td width="3%" valign="top">:</td>
                <td width="62%">
                    @if ($list_anggota[0]->jenis_petugas == 2)
                        1. {{ $list_anggota[0]->nama }} / Mitra
                    @else
                        1. {{ $list_anggota[0]->nama }} / {{ $list_anggota[0]->jabatan }}
                    @endif
                </td>
                <td width="5%"></td>
            </tr>

            @foreach ($list_anggota as $k => $v)
                @if (!$loop->first)
                    <tr>
                        <td width="5%"></td>
                        <td width="25%" valign="top"><br /><br /></td>
                        <td width="3%" valign="top"></td>
                        <td width="62%">
                            @if ($v->jenis_petugas == 2)
                                {{ $k + 1 }}. {{ $v->nama }} / Mitra
                            @else
                                {{ $k + 1 }}. {{ $v->nama }} / {{ $v->jabatan }}
                            @endif
                        </td>
                        <td width="5%"></td>
                    </tr>
                @endif
            @endforeach
        @endif
    </table>

    <br /><br />

    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="45%" align="center"></td>
            <td width="5%"></td>
            <td width="40%" align="left">
                @if ($unit_kerja_ttd != null)
                    {{ $unit_kerja_ttd->ibu_kota }}
                @else
                    {{ $unit_kerja->ibu_kota }}
                @endif
                , {{ date('d', strtotime($model_rincian->created_at)) }}
                {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }}
                {{ date('Y', strtotime($model_rincian->created_at)) }}<br />
                <br/>
                <!-- cek jika unit kerja bukan kepala dari unit kerja -->
                @if ($unit_kerja_ttd != null)
                    @if ($unit_kerja_ttd->kepala_nip != $model_rincian->pejabat_ttd_nip)
                        an.
                    @endif
                @else
                    @if ($unit_kerja->kepala_nip != $model_rincian->pejabat_ttd_nip)
                        an.
                    @endif
                @endif

                Kepala Badan Pusat Statistik<br />

                @if ($unit_kerja_ttd != null)
                    {{ $unit_kerja_ttd->nama }}
                    @if ($unit_kerja_ttd->kepala_nip != $model_rincian->pejabat_ttd_nip)
                        <br />{{ $user_ttd->nmjab }}
                    @endif
                @else
                    {{ $unit_kerja->nama }}
                    @if ($unit_kerja->kepala_nip != $model_rincian->pejabat_ttd_nip)
                        <br /><br />{{ $user_ttd->nmjab }}
                    @endif
                @endif
                <br /><br />
                <br />
                <br />
                {{ $model_rincian->pejabat_ttd_nama }}<br/>
            </td>
            <td width="5%"></td>
        </tr>
    </table>
</body>

</html>
