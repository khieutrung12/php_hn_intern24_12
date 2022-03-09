$(function () {
    $("#vouchers-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '/admin/vouchers/list',
        pageLength: 5,
        aLengthMenu: [[5, 10, 25, 50, -1],[5, 10, 25, 50, "All"]],
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'code', name: 'code'},
            {data: 'quantity', name: 'quantity'},
            {data: 'value', name: 'value'},
            {data: 'condition_min_price', name: 'condition_min_price'},
            {data: 'maximum_reduction', name: 'maximum_reduction'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
        ],
    }).on('draw', function () {
        $('input[name="voucher_checkbox"]').each(function () {this.checked = false;});
        $('input[name="main_checkbox"]').prop(this.checked = false);
        $('button#deleteAllBtn').addClass('hidden');
    });

    $('#form_add_voucher').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(document).find('span.error-text').text('');
            },
            success: function (response) {
                $('#addVoucher').modal('hide');
                $('#form_add_voucher')[0].reset();
                $('#vouchers-table').DataTable().ajax.reload(null, false);
                toastr.success(response.message);
            },
            error: function (xhr) {
                var err = JSON.parse(xhr.responseText);
                $.each(err.errors, function (key, value) {
                    $('span.error_' + key).text(value);
                });
            },
        });

        $(document).on("click", ".close-action", function () {
            $(document).find('span.error-text').text('');
            $('#form_add_voucher')[0].reset();
        });
    });
});
