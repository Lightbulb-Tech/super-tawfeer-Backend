@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    {{--    {!! createBtn($createRoute,$addButtonText) !!}--}}
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('banha.code')}}</th>
                    <th>{{__('banha.driver_name')}}</th>
                    <th>{{__('banha.user_name')}}</th>
                    <th>{{__('banha.user_phone')}}</th>
                    <th>{{__('banha.area')}}</th>
                    <th>{{__('banha.address')}}</th>
                    <th>{{__('banha.shipping_price')}}</th>
                    <th>{{__('banha.orders_price')}}</th>
                    <th>{{__('banha.final_price')}}</th>
                    <th>{{__('banha.status')}}</th>
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
                    {"data": 'driver_name', name: 'driver_name', orderable: false, searchable: true},
                    {"data": 'user_name', name: 'user_id', orderable: false, searchable: true},
                    {"data": 'user_phone', name: 'user_id', orderable: false, searchable: true},
                    {"data": 'area', name: 'area', orderable: false, searchable: true},
                    {"data": 'address', name: 'address', orderable: false, searchable: true},
                    {"data": 'shipping_price', name: 'shipping_price', orderable: false, searchable: true},
                    {"data": 'orders_price', name: 'orders_price', orderable: false, searchable: true},
                    {"data": 'final_price', name: 'final_price', orderable: false, searchable: true},
                    {"data": "status", name: 'status', orderable: false, searchable: false},
                    // {"data": "invoice_pdf", orderable: false, searchable: false},
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
        $(document).ready(function () {
            // قبول الاشتراك
            $(document).on("click", ".change_order_status", function () {
                let id = $(this).data("id");
                let status = $(this).data("status");
                confirmAction(id, status, "{{ __('banha.confirm_change_order_status') }}", "{{ __('banha.accepted') }}");
            });
            function confirmAction(id, status, confirmText, successText) {
                Swal.fire({
                    title: "{{ __('banha.Are_you_sure') }}",
                    text: confirmText,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "{{ __('banha.yes') }}",
                    cancelButtonText: "{{ __('banha.no') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        updateOrderStatus(id, status, successText);
                    }
                });
            }

            function updateOrderStatus(id, status, successText) {
                $.ajax({
                    url: "{{ route('update-external-order-status.update', ':id') }}".replace(":id", id),
                    type: "put",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                    },
                    success: function (response) {
                        if (response) {
                            if (response.code === 422) {
                                toastr.warning(response.message);
                            } else {
                                Swal.fire({
                                    icon: "success",
                                    title: "{{ __('banha.success') }}",
                                    text: successText,
                                });
                            }
                        }
                        $('#dataTable').DataTable().ajax.reload();
                    },
                });
            }
        });
        $(document).on("click", ".choose_driver", function () {
            let id = $(this).data('id')
            let url = "{{route('get-drivers-for-external-orders.index')}}"
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    order_id: id
                },
                success: function (response) {
                    $('.modal-body').html(response.data.html);
                    $('#basicModal .modal-dialog').addClass('modal-xl');
                    $.validate({
                        modules: 'security, date',
                        lang: "{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}"
                    });
                    $('#basicModal').modal('show');
                }
            })
        });
        $(document).on("click", ".register_final_price", function () {
            let id = $(this).data('id')
            let url = "{{route('register-final-to-external-order.index')}}"
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    order_id: id
                },
                success: function (response) {
                    $('.modal-body').html(response.data.html);
                    $('#basicModal .modal-dialog').addClass('modal-xl');
                    $.validate({
                        modules: 'security, date',
                        lang: "{{app()->getLocale() == 'ar' ? 'ar' : 'en'}}"
                    });
                    $('#basicModal').modal('show');
                }
            })
        });


    </script>
@endsection
