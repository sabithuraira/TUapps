@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('dopamin_spada') }}">Pertanyaan Spada</a></li>
    <li class="breadcrumb-item">Hasil Jawaban</li>
</ul>
@endsection

@section('content')
<div class="container" id="app_hasil">
    <div class="card">
        <div class="header">
            <h2><i class="fa fa-list-alt"></i> Hasil Jawaban</h2>
        </div>
        <div class="body">
            <div class="card bg-light m-b-20" v-if="questionText">
                <div class="body p-3">
                    <strong>Pertanyaan:</strong>
                    <p class="m-t-5 m-b-0 font-weight-bold text-dark">@{{ questionText }}</p>
                </div>
            </div>

            <div v-if="loading" class="text-center p-4">
                <img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="80" height="80" alt="Loading...">
                <p class="m-t-10">Memuat jawaban...</p>
            </div>

            <template v-else>
                <div class="m-b-15 d-flex flex-wrap align-items-center">
                    <button type="button" class="btn btn-success mr-2" :disabled="selectedIds.length === 0 || submitting" @click="submitStatus(1)">
                        <span v-if="!submittingApprove"><i class="fa fa-check"></i> Approve Item Dipilih</span>
                        <span v-else><i class="fa fa-spinner fa-spin"></i> Memproses...</span>
                    </button>
                    <button type="button" class="btn btn-warning" :disabled="selectedIds.length === 0 || submitting" @click="submitStatus(2)">
                        <span v-if="!submittingUnapprove"><i class="fa fa-times"></i> Unapprove Item Dipilih</span>
                        <span v-else><i class="fa fa-spinner fa-spin"></i> Memproses...</span>
                    </button>
                    <span class="ml-2 text-muted" v-if="selectedIds.length > 0">@{{ selectedIds.length }} dipilih</span>
                </div>

                <div v-if="answers.length === 0" class="alert alert-info">Belum ada jawaban.</div>

                <div class="table-responsive" v-else>
                    <table class="table table-bordered m-b-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;">
                                    <input type="checkbox" :checked="allSelected" @change="toggleSelectAll">
                                </th>
                                <th>No</th>
                                <th>Jawaban</th>
                                <th class="text-center">Status Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in answers" :key="item.id">
                                <td class="text-center">
                                    <input type="checkbox" :value="item.id" v-model="selectedIds">
                                </td>
                                <td class="text-center">@{{ index + 1 }}</td>
                                <td>@{{ item.answer }}</td>
                                <td class="text-center">
                                    <span v-if="item.status_approve == 1" class="badge badge-success">Approve</span>
                                    <span v-else class="badge badge-secondary">Tidak Approve</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </template>

            <div class="m-t-15">
                <a href="{{ url('dopamin_spada') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vmHasil = new Vue({
    el: '#app_hasil',
    data: {
        questionId: {{ (int) $questionId }},
        questionText: '',
        answers: [],
        loading: true,
        selectedIds: [],
        submitting: false,
        submittingApprove: false,
        submittingUnapprove: false,
        spadaAnswerApiUrl: (window.API_CONFIG && window.API_CONFIG.MADING_API_URL) ? (window.API_CONFIG.MADING_API_URL + '/spada-answer') : 'http://mading.farifam.com/api/spada-answer',
        spadaQuestionApiUrl: (window.API_CONFIG && window.API_CONFIG.MADING_SPADA_QUESTION_API) ? window.API_CONFIG.MADING_SPADA_QUESTION_API : 'http://mading.farifam.com/api/spada-question',
    },
    computed: {
        allSelected: function () {
            if (this.answers.length === 0) return false;
            return this.selectedIds.length === this.answers.length;
        },
    },
    methods: {
        loadQuestion: function () {
            var self = this;
            $.ajax({
                url: self.spadaQuestionApiUrl + '/' + self.questionId,
                method: 'GET',
                dataType: 'json',
                crossDomain: true,
            }).done(function (data) {
                var q = (data && data.data) ? data.data : (data && data.question ? data : null);
                self.questionText = (q && q.question) ? q.question : '';
            }).fail(function () {});
        },
        loadAnswers: function () {
            var self = this;
            self.loading = true;
            self.loadQuestion();
            $.ajax({
                url: self.spadaAnswerApiUrl + '/question/' + self.questionId,
                method: 'GET',
                dataType: 'json',
                crossDomain: true,
            }).done(function (data) {
                var raw = data.datas || data.data || (Array.isArray(data) ? data : []);
                self.answers = Array.isArray(raw) ? raw : [];
                self.selectedIds = [];
                self.loading = false;
            }).fail(function () {
                self.answers = [];
                self.loading = false;
            });
        },
        toggleSelectAll: function () {
            if (this.allSelected) {
                this.selectedIds = [];
            } else {
                this.selectedIds = this.answers.map(function (a) { return a.id; });
            }
        },
        submitStatus: function (statusApprove) {
            var self = this;
            if (self.selectedIds.length === 0) return;
            self.submitting = true;
            if (statusApprove === 1) self.submittingApprove = true; else self.submittingUnapprove = true;
            $.ajax({
                url: self.spadaAnswerApiUrl + '/status-approve',
                method: 'POST',
                dataType: 'json',
                crossDomain: true,
                contentType: 'application/json',
                data: JSON.stringify({
                    status_approve: statusApprove,
                    ids: self.selectedIds,
                }),
            }).done(function (data) {
                if (data.success == '1') {
                    alert('Status berhasil diupdate.');
                    self.loadAnswers();
                } else {
                    alert(data.message || 'Gagal mengupdate status.');
                }
                self.submitting = false;
                self.submittingApprove = false;
                self.submittingUnapprove = false;
            }).fail(function (xhr) {
                var msg = 'Gagal mengupdate status.';
                try {
                    var r = JSON.parse(xhr.responseText);
                    if (r.message) msg = r.message;
                } catch (e) {}
                alert(msg);
                self.submitting = false;
                self.submittingApprove = false;
                self.submittingUnapprove = false;
            });
        },
    },
});
vmHasil.loadAnswers();
</script>
@endsection
