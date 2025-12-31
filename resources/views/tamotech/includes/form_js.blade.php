<script>
    $(document).ready(function () {
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.success)
                        $('#basicModal').modal('hide');
                        myTable.ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('main.messageError')}}',
                        html: errorMessage,
                    });
                }
            })
        })
    });
</script>
