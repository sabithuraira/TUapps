<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    {{-- <meta charset="UTF-8"> --}}
    <style type="text/css">
        * {
            font-family: Segoe UI, Arial, sans-serif;
            font-size: 12px
        }

        tr,
        td {
            padding-left: 8px;
        }

        .pepet {
            white-space: nowrap;
            width: 1%;
        }

        .table-border {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            white-space: nowrap;
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

        .text-center {
            text-align: center
        }
    </style>

    {{-- <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}"> --}}

</head>

<body>
    <div class="container">
        <div style="margin-right: 5px;float: right;">Palembang, ................ 202....</div>
        <table class=" ">
            <tr>
                <td>Kepada Yth: </td>
            </tr>
            @if ($user->kd_kab == '00')
                <tr>
                    <td>Kepala Bagian...</td>
                </tr>
                <tr>
                    <td>BPS Provinsi Sumatera Selatan</td>
                </tr>
                <tr>
                    <td>di Palembang</td>
                </tr>
            @else
                <tr>
                    <td>Kepala BPS {{ $unit_kerja->nama }}</td>
                </tr>
                <tr>
                    <td>di {{ $unit_kerja->ibu_kota }}</td>
                </tr>
            @endif
        </table>
        <br>
        <div style="text-align:center">FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</div>
        <table class="table-border">
            <tr>
                <td colspan="4">I. DATA PEGAWAI</td>
            </tr>
            <tr>
                <td width="10%">Nama</td>
                <td width="40%">{{ $model->nama }}</td>
                <td width="12%">NIP</td>
                <td>{{ $model->nip }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>{{ $model->jabatan }}</td>
                <td>Masa Kerja</td>
                <td>{{ $model->masa_kerja }}</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td colspan="3">
                    {{-- {{ substr($model->unit_kerja, 2, 2) }} --}}
                    BPS {{ config('app.unit_kerjas')[substr($model->unit_kerja, 2, 2)] }}
                </td>
            </tr>
        </table>
        <br>
        <table class="table-border">
            <tr>
                <td colspan="4">II. JENIS CUTI YANG DIAMBIL</td>
            </tr>
            <tr>
                <td>1. Cuti Tahunan</td>
                <td width="10%" class="text-center">
                    @if ($model->jenis_cuti == 'Cuti Tahunan')
                        V
                    @endif
                </td>
                <td>2. Cuti Besar</td>
                <td width="10%" class="text-center">
                    @if ($model->jenis_cuti == 'Cuti Besar')
                        &#10004;
                    @endif
                </td>
            </tr>
            <tr>
                <td>3. Cuti Sakit</td>
                <td class="text-center">
                    @if ($model->jenis_cuti == 'Cuti Sakit')
                        V
                    @endif
                </td>
                <td>4. Cuti Melahirkan</td>
                <td class="text-center">
                    @if ($model->jenis_cuti == 'Cuti Melahirkan')
                        V
                    @endif
                </td>
            </tr>
            <tr>
                <td>5. Cuti Karena Alasan Penting</td>
                <td class="text-center">
                    @if ($model->jenis_cuti == 'Cuti Karena Alasan Penting')
                        V
                    @endif
                </td>
                <td>6. Cuti di Luar Tanggungan Negara</td>
                <td class="text-center">
                    @if ($model->jenis_cuti == 'Cuti di Luar Tanggungan Negara')
                        V
                    @endif
                </td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td> III. ALASAN CUTI </td>
            </tr>
            <tr>
                <td>
                    {{ $model->alasan }}
                    <br>
                    <br>
                </td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td colspan="6">IV. LAMANYA CUTI</td>
            </tr>
            <tr>
                <td>Selama</td>
                <td style="text-align: center"> {{ $model->lama_cuti_hari_kerja + $model->lama_cuti_hari_libur }} (hari)
                </td>
                <td style="text-align:center">mulai tanggal</td>
                <td style="text-align: center"> {{ $model->tanggal_mulai }}</td>
                <td style="width: 5%; text-align:center">s/d</td>
                <td style="text-align: center"> {{ $model->tanggal_selesai }}</td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td colspan="5">V. CATATAN CUTI</td>
            </tr>
            <tr>
                <td colspan="3">1. Cuti Tahunan</td>
                <td width="35%">2. Cuti Besar</td>
                <td class="text-center" width="25%"> {{ $catatan_cuti->cuti_besar }}</td>
            </tr>
            <tr>
                <td class="text-center">Tahun</td>
                <td style="text-align:center">Sisa</td>
                <td style="text-align:center">Keterangan</td>
                <td>3. Cuti Sakit</td>
                <td class="text-center">{{ $catatan_cuti->cuti_sakit }} </td>
            </tr>
            <tr>
                <td class="text-center">{{ date('Y') - 1 }}</td>
                <td class="text-center">{{ $catatan_cuti->cuti_tahunan_sebelum }} </td>
                <td class="text-center"> {{ $catatan_cuti->keterangan_cuti_tahunan_sebelum }}</td>
                <td>4. Cuti Melahirkan</td>
                <td class="text-center"> {{ $catatan_cuti->cuti_melahirkan }}</td>
            </tr>
            <tr>
                <td class="text-center">{{ date('Y') }}</td>
                <td class="text-center"> {{ $catatan_cuti->cuti_tahunan }}</td>
                <td class="text-center">{{ $catatan_cuti->keterangan_cuti_tahunan }} </td>
                <td>5. Cuti Karena Alasan Penting</td>
                <td class="text-center"> {{ $catatan_cuti->cuti_penting }}</td>
            </tr>
            <tr>
                <td class="text-center">Total</td>
                <td class="text-center"> {{ $catatan_cuti->cuti_tahunan + $catatan_cuti->cuti_tahunan_sebelum }}</td>
                <td> </td>
                <td>6. Cuti di Luar Tanggungan Negara</td>
                <td class="text-center"> {{ $catatan_cuti->cuti_luar_tanggungan }} </td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td colspan="3">VI. ALAMAT SELAMA MENJALANKAN CUTI</td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: topx">{{ $model->alamat_cuti }} </td>
                <td width="15%" style="white-space: nowrap;">Telp/HP (Aktif)</td>
                <td width="30%"> {{ $model->no_telp }} </td>
            </tr>
            <tr>

                <td colspan="2" width="20%" class="text-center">Hormat Saya,
                    <br>
                    <br>
                    <br>
                    {{ $model->nama }}
                    <br>
                    NIP. {{ $model->nip }}
                </td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td colspan="4">VI. PERTIMBANGAN ATASAN LANGSUNG</td>

            </tr>
            <tr class="text-center">
                <td width="20%">Disetujui</td>
                <td width="25%">Disetujui dgn Perubahan</td>
                <td width="20%">Ditangguhkan</td>
                <td width="35%">Tidak Disetujui</td>
            </tr>
            <tr>
                <td><br><br><br></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid transparent; "></td>
                <td style="border: 1px solid transparent"></td>
                <td style="border-bottom: 1px solid transparent"></td>
                <td class="text-center">
                    Palembang, .............. 202........
                    <br>
                    <br>
                    <br>
                    {{ $model->nama_atasan }}
                    <br>
                    NIP. {{ $model->nip_atasan }}
                </td>
            </tr>
        </table>
        <br>
        <table class="table-border ">
            <tr>
                <td colspan="4">VII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</td>

            </tr>
            <tr class="text-center">
                <td width="20%">Disetujui</td>
                <td width="25%">Disetujui dgn Perubahan</td>
                <td width="20%">Ditangguhkan</td>
                <td width="35%">Tidak Disetujui</td>
            </tr>
            <tr>
                <td><br><br><br></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="border: 1px solid transparent; "></td>
                <td style="border: 1px solid transparent"></td>
                <td style="border-bottom: 1px solid transparent"></td>
                <td class="text-center">
                    Palembang, .............. 202.....
                    <br>
                    <br>
                    <br>
                    {{ $model->nama_pejabat }}
                    <br>
                    NIP. {{ $model->nip_pejabat }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
