@if (!empty($show_logbook_rekap))
<div class="col-lg-12 col-md-12" id="logbook_rekap_section">
    <div class="card">
        <div class="body">
            <div class="row clearfix align-items-end">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <label>Mode:</label>
                        <select class="form-control" id="lb_rekap_mode">
                            <option value="day" selected>Per Tanggal</option>
                            <option value="month">Per Bulan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6" id="lb_rekap_day_filter">
                    <div class="form-group">
                        <label>Tanggal:</label>
                        <div class="input-group date" data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" id="lb_rekap_tanggal" value="{{ date('Y-m-d') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6" id="lb_rekap_month_filter" style="display:none;">
                    <div class="form-group">
                        <label>Bulan:</label>
                        <select class="form-control" id="lb_rekap_month">
                            @foreach (config('app.months') as $key => $value)
                                <option value="{{ $key }}" @if ((int)$key === (int)date('n')) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6" id="lb_rekap_year_filter" style="display:none;">
                    <div class="form-group">
                        <label>Tahun:</label>
                        <select class="form-control" id="lb_rekap_year">
                            @for ($i = date('Y'); $i >= 2019; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="form-group">
                        <button type="button" class="btn btn-info btn-block" id="lb_rekap_refresh">
                            <i class="fa fa-refresh"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive m-t-10">
                <table class="table table-bordered table-striped table-hover table-sm m-b-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">No</th>
                            <th>Ketua Tim</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Pegawai Isi Logbook</th>
                            <th class="text-center" style="min-width:180px;">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="lb_rekap_table_body">
                        <tr>
                            <td colspan="7" class="text-center text-muted">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lb_rekap_detail_modal" tabindex="-1" role="dialog" aria-labelledby="lb_rekap_detail_title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lb_rekap_detail_title">Detail Logbook Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted m-b-10" id="lb_rekap_detail_subtitle"></p>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover table-sm m-b-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px;">No</th>
                                <th style="min-width:160px;">Nama Pegawai</th>
                                <th style="width:120px;">Tanggal</th>
                                <th>Isi</th>
                            </tr>
                        </thead>
                        <tbody id="lb_rekap_detail_body">
                            <tr>
                                <td colspan="4" class="text-center text-muted">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif
