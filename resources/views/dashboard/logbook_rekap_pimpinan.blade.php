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

            <div class="row clearfix">
                <div class="col-lg-7 col-md-12">
                    <h6 class="m-b-15">% Pegawai Isi Logbook per Ketua Tim</h6>
                    <div id="lb_rekap_chart_bar" style="height: 360px;"></div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <h6 class="m-b-15" id="lb_rekap_side_title">Ringkasan Persentase</h6>
                    <div id="lb_rekap_percent_list" style="max-height: 360px; overflow-y: auto;"></div>
                    <div id="lb_rekap_chart_line" style="height: 280px; display:none;"></div>
                    <p class="text-muted text-small m-t-10" id="lb_rekap_line_hint" style="display:none;">Tren jumlah pegawai yang mengisi logbook per hari.</p>
                </div>
            </div>

            <div class="table-responsive m-t-20">
                <table class="table table-bordered table-striped table-hover table-sm m-b-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;">No</th>
                            <th>Ketua Tim</th>
                            <th>Jabatan</th>
                            <th>NIP</th>
                            <th class="text-center">Anggota</th>
                            <th class="text-center">Pegawai Isi Logbook</th>
                            <th class="text-center" style="min-width:160px;">Persentase</th>
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
@endif
