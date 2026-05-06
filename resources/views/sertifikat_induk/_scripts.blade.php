<script>
(function () {
    function renumberRows() {
        $('#peserta-rows tr').each(function (i) {
            $(this).find('.nomor-cell').text(i + 1);
        });
    }

    function addRow(val) {
        val = val || '';
        var tr = $('<tr class="peserta-row">')
            .append('<td class="text-center nomor-cell">0</td>')
            .append($('<td>').append($('<input>', { type: 'text', name: 'peserta_nama[]', class: 'form-control peserta-nama', value: val })))
            .append($('<td class="text-center">').append($('<button>', { type: 'button', class: 'btn btn-sm btn-danger btn-remove-row', html: '&times;' })));
        $('#peserta-rows').append(tr);
        renumberRows();
    }

    $('#btn-add-peserta').on('click', function () {
        addRow('');
    });

    $('#peserta-rows').on('click', '.btn-remove-row', function () {
        if ($('#peserta-rows tr').length <= 1) {
            $(this).closest('tr').find('input').val('');
            return;
        }
        $(this).closest('tr').remove();
        renumberRows();
    });

    $('#btn-preview-excel').on('click', function () {
        var input = document.getElementById('excel_peserta');
        if (!input.files || !input.files[0]) {
            alert('Pilih file Excel terlebih dahulu.');
            return;
        }
        var fd = new FormData();
        fd.append('excel_file', input.files[0]);
        fd.append('_token', $('meta[name=csrf-token]').attr('content'));

        $.ajax({
            url: '{{ url('sertifikat_induk/import_peserta_excel') }}',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.names && res.names.length) {
                    res.names.forEach(function (n) {
                        addRow(n);
                    });
                    $('#excel_peserta').val('');
                } else {
                    alert('Tidak ada nama yang terbaca dari file.');
                }
            },
            error: function (xhr) {
                var msg = 'Gagal membaca file.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                alert(msg);
            }
        });
    });

    renumberRows();
})();
</script>
