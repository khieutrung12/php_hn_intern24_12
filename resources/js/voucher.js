$(function () {
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
