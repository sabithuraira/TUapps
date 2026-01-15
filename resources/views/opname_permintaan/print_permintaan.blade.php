<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Permintaan Barang</title>
    <style type="text/css">
        body { font-family: "Times New Roman", serif; font-size: 12px; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 10px; }
        .info-table { width: 100%; margin-bottom: 20px; margin-top: 20px; }
        .info-table td { vertical-align: top; }
        table { border-collapse: collapse; width: 100%; }
        .border th, .border td { border: 1px solid #000; padding: 4px; }
        .center { text-align: center; }
        .setuju-spacing { padding-top: 20px; padding-bottom: 20px; }
        .right { text-align: right; }
        .small { font-size: 11px; }
        .space-top { margin-top: 12px; }
        .signature { height: 50px; }
        .underline { border-bottom: 1px dotted #000; display: inline-block; min-width: 180px; }
    </style>
</head>
<body>
    <div class="title">SURAT PERMINTAAN ATK, ARK &amp; CS</div>

    <table class="info-table">
        <tr>
            <td style="width:70%;">
                <div>Tim Kerja : {{ $unit_kerja }}</div>
            </td>
            <td style="width:30%;">
                <div>No. ................................</div>
                <div>Dibukukan : ............................</div>
            </td>
        </tr>
    </table>

    <table class="border">
        <thead>
            <tr class="center">
                <th style="width:5%;" rowspan="2">No</th>
                <th style="width:35%;" rowspan="2">Nama Barang</th>
                <th colspan="2" style="width:25%;">Banyaknya</th>
                <th style="width:10%;" rowspan="2">Satuan</th>
                <th style="width:25%;" rowspan="2">Keterangan</th>
            </tr>
            <tr class="center">
                <th>Diminta</th>
                <th>Disetujui</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="center">1</td>
                <td>{{ $model->masterBarang ? $model->masterBarang->nama_barang : '-' }}</td>
                <td class="center">{{ $model->jumlah_diminta }}</td>
                <td class="center"></td>
                <td class="center">{{ $model->masterBarang ? $model->masterBarang->satuan : '-' }}</td>
                <td></td>
            </tr>
            @for ($i = 0; $i < 8; $i++)
                <tr>
                    <td class="center">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="center">&nbsp;</td>
                    <td class="center">&nbsp;</td>
                    <td class="center">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>

    <table width="100%" class="info-table">
        <tr>
            <td width="10%"></td>
            <td width="30%">
                <div>Mengetahui</div>
                <div>Ketua Tim  {{ $unit_kerja }}</div>
                <div class="signature"></div>
                <div>Nama <span class="underline"></span></div>
                <div>NIP. <span></span></div>
            </td>
            <td width="20%"></td>
            <td width="30%">
                <div>Palembang, {{ $tanggal_label }}</div>
                <div></div>
                <div>Penerima Barang</div>
                <div class="signature"></div>
                <div>Nama {{ $penerima_nama }}</div>
                <div>NIP. {{ $penerima_nip }}</div>
            </td>
            <td width="10%"></td>
        </tr>

        <tr>
            <td colspan="5" class="center setuju-spacing">Setuju Dikeluarkan</td>
        </tr>

        <tr>
            <td width="10%"></td>
            <td width="30%">
                <div>Ketua Tim Umum</div>
                <div class="signature"></div>
                <div>Nama <span class="underline"></span></div>
                <div>NIP. <span class="underline"></span></div>
            </td>
            <td width="20%"></td>
            <td width="30%">
                <div>Petugas Pengelola Persediaan</div>
                <div class="signature"></div>
                <div>Nama <span class="underline"></span></div>
                <div>NIP. <span class="underline"></span></div>
            </td>
            <td width="10%"></td>
        </tr>
    </table>

</body>
</html>

