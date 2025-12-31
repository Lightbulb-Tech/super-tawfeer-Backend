@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
<style>
    /* Style for toggle switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 26px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #4caf50; /* اللون لما يكون مفعّل */
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #4caf50;
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

</style>
@section('content')
    {!! createBtn($createRoute,$addButtonText) !!}
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('banha.code')}}</th>
                    <th>{{__('banha.from_date')}}</th>
                    <th>{{__('banha.to_date')}}</th>
                    <th>{{__('banha.type')}}</th>
                    <th>{{__('banha.value')}}</th>
                    <th>{{__('banha.usage_times')}}</th>
                    <th>{{__('banha.is_active')}}</th>
                    <th>{{__('banha.actions')}}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var myTable;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(function () {
            myTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: true,
                ordering: true,
                iDisplayLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "الكل"]],
                ajax: "{{ $dataTableRoute }}",
                columns: [
                    {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {"data": 'code', name: 'code', orderable: false, searchable: true},
                    {"data": 'from_date', name: 'from_date', orderable: false, searchable: true},
                    {"data": 'to_date', name: 'to_date', orderable: false, searchable: true},
                    {"data": 'type', name: 'type', orderable: false, searchable: true},
                    {"data": 'value', name: 'value', orderable: false, searchable: true},
                    {"data": 'usage_times', name: 'usage_times', orderable: false, searchable: true},
                    {"data": 'is_active', name: 'is_active', orderable: false, searchable: true},
                    {"data": "actions", orderable: false, searchable: false}
                ],
                language: {
                    sProcessing: "{{ __('datatable.processing') }}",
                    sLengthMenu: "{{ __('datatable.lengthMenu') }}",
                    sZeroRecords: "<img src='{{asset('admin/images/emptybox.webp')}}' width='100px' height='100px'>",
                    sInfo: "{{ __('datatable.info') }}",
                    sInfoEmpty: "{{ __('datatable.infoEmpty') }}",
                    sInfoFiltered: "{{ __('datatable.infoFiltered') }}",
                    sSearch: "{{ __('datatable.search') }}",
                    oPaginate: {
                        sFirst: "{{ __('datatable.first') }}",
                        sPrevious: "{{ __('datatable.previous') }}",
                        sNext: "{{ __('datatable.next') }}",
                        sLast: "{{ __('datatable.last') }}"
                    },
                    oAria: {
                        sSortAscending: "{{ __('datatable.sortAscending') }}",
                        sSortDescending: "{{ __('datatable.sortDescending') }}"
                    }
                },
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [1, 3, 4], // Column index which needs to export
                        }
                    }
                ],
            });


        });
        $(document).on('change', '.toggle-switch', function (e) {
            e.preventDefault();

            let rentId = $(this).data('id');
            let field = $(this).data('field');
            let isChecked = $(this).is(':checked') ? 1 : 0;

            Swal.fire({
                title: "{{ __('banha.confirmation') }}",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: "{{ __('banha.confirm') }}",
                cancelButtonText: "{{ __('banha.cancel') }}",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('coupon-active.update', ':id') }}".replace(':id', rentId),
                        type: "PUT",
                        data: {
                            [field]: isChecked,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: "{{ __('banha.updated_successfully') }}",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            reloadDataTable();
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('error') }}",
                                text: "{{ __('try again') }}"
                            });
                        }
                    });
                } else {
                    $(this).prop('checked', !isChecked);
                }
            })
        });
        $(document).ajaxComplete(function () {
            $("#generateCodeButton").on('click', function () {
                let button = $(this);
                let originalText = button.html();
                button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{__("banha.generating")}}...');
                button.prop('disabled', true);
                setTimeout(function () {
                    let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    let code = '';
                    for (let i = 0; i < 8; i++) {
                        code += characters.charAt(Math.floor(Math.random() * characters.length));
                    }
                    $("#generatedCode").val(code);
                    button.html(originalText);
                    button.prop('disabled', false);
                }, 500);
            });
        });
    </script>
@endsection
