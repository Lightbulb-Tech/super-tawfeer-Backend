<script>
    function createButton(route_name, model_title) {
        $.ajax({
            url: route_name,
            success: function (response) {
                $('.modal-body').html(response.data.html);
                $('.modal-title').text(model_title);
                $('#basicModal').modal('show');
                $('.dropify').dropify({
                    messages: {
                        default: '{{__("banha.Drag image here")}}',
                        replace: 'اسحب صورة جديدة أو اضغط للاستبدال',
                        remove: 'إزالة',
                        error: 'عذرًا، الملف غير صالح'
                    }
                });
                $.validate({
                    modules: 'security, date',
                    lang: "{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}"
                });

            }
        });
    }

    function editButton(route_name, model_title) {

        $.ajax({
            url: route_name,
            success: function (response) {
                $('.modal-body').html(response.data.html);
                $('.modal-title').text(model_title);
                $('#basicModal').modal('show');
                $('.dropify').dropify({
                    messages: {
                        default: '{{__("banha.Drag image here")}}',
                        replace: 'اسحب صورة جديدة أو اضغط للاستبدال',
                        remove: 'إزالة',
                        error: 'عذرًا، الملف غير صالح'
                    }
                });
                $.validate({
                    modules: 'security, date',
                    lang: "{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}"
                });
            }
        });
    }

    function showButton(route_name, model_title) {

        $.ajax({
            url: route_name,
            success: function (response) {
                $('.modal-body').html(response.data.html);
                $('.modal-title').text(model_title);
                $('#basicModal').modal('show');
            }
        });
    }
    function deleteButton(routeUrl) {
        swal.fire({
            title: "{{__('buttons.Are You Sure')}}",
            text: "{{__('buttons.You Can not to rollback')}}",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "{{__('buttons.accept')}}",
            cancelButtonText: "{{__('buttons.cancel')}}",
        }).then((result) => {
            if (result.isConfirmed) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: routeUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function (response) {
                        Swal.fire(
                            '{{__('main.done')}}',
                            response.success,
                            'success'
                        );
                        myTable.ajax.reload();
                    }
                });
            }
        });
    }

    $(document).on('submit', '#form', function (e) {
        e.preventDefault();
        let $form = $(this);
        let $submitBtn = $form.find('button[type="submit"]');
        let originalBtnHtml = $submitBtn.html();
        $submitBtn.html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>{{ __("main.loading") }}')
            .prop('disabled', true);
        $.ajax({
            url: $form.attr('action'),
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                handleSuccessResponce(response);
                $('#basicModal').modal('hide');
                $('input[type="file"].dropify').each(function() {
                    if (!this.files.length) {
                        $(this).removeAttr('name');
                    }
                });
                myTable.ajax.reload();
            },

            error: function (xhr, status, error) {
                let errorMessage = '';
                // 🟥 خطأ 500 (Internal Server Error)
                if (xhr.status === 500) {
                    errorMessage = '{{ __("banha.serverError") }}';
                    // 🟡 خطأ 422 (Validation Error)
                } else if (xhr.status === 422 && xhr.responseJSON?.data) {
                    $.each(xhr.responseJSON.data, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    // 🟩 أي أخطاء أخرى
                } else {
                    errorMessage = xhr.responseJSON?.message || '{{ __("main.messageError") }}';
                }

                Swal.fire({
                    icon: 'error',
                    title: '{{ __("main.messageError") }}',
                    html: errorMessage,
                });
            },
            complete: function () {
                $submitBtn.html(originalBtnHtml).prop('disabled', false);
            }
        });
    });

    function handleSuccessResponce(result) {
        console.log("handleSuccessResponce" + result.code)
        console.log(result)
        if (result.code === 200) {
            toastr.success(result.message ,'{{__("auth.successfully")}}');
        } else if (result.code === 201) {
            toastr.success(result.message ,'{{__("auth.successfully")}}');
            location.reload();
            //location.href = result.data.url;
        } else if (result.code === 202) {
            toastr.success(result.message ,'{{__("auth.successfully")}}');
            $('.upCreateModalClose').click()
            if ($('.select2').length > 0) {
                $('.select2').select2({
                    dropdownParent: $('#createModal .modal-body'),
                });
                // $('.select2').select2();
            }
            if(result.data.up_id){
                let up_name_id = result.data.up_name_id
                let up_id = result.data.up_id;
                let select = document.getElementById(''+up_id);
                let newOption = document.createElement('option');
                newOption.value = result.data.id; // Set the value attribute
                newOption.text = result.data[up_name_id]; // Set the visible text
                if($('#'+up_id).length > 0){
                    console.log("aslll");
                    select.add(newOption);
                    select.value = newOption.value;
                }else{
                    console.log("as");
                    console.log($('#'+up_id).length);
                    $('.'+up_id).append(newOption);
                    // $('.'+up_id).val(newOption.value);
                }
            }
            //location.href = result.data.url;
        } else if (result.code === 401) {
            toastr.warning('{{__("auth.an error occurred")}}', result.message)
        } else {
            toastr.error('{{__("auth.an error occurred")}}', result.message)
        }
    }
    function handleErrorResponce(errorObj) {
        console.log('handleErrorResponce');
        console.log(errorObj.status);
        if (errorObj.status == 422) {
            let errorsObj = $.parseJSON(errorObj.responseText);
            let listObject = errorsObj.data;
            let testArr = [];
            $.each(listObject, function (errorKey, errorArr) {
                $.each(errorArr, function (key, value) {
                    testArr.push(value);
                });
            });
            validToster('{{__("auth.an error occurred")}}', testArr)
        } else {
            errorToster('{{__("auth.an error occurred")}}', "{{__("auth.code error")}}");
        }
    }
</script>

})
