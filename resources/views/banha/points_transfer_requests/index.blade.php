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
                    <th>{{__('banha.user')}}</th>
                    <th>{{__('banha.user_phone')}}</th>
                    <th>{{__('banha.status')}}</th>
                    <th>{{__('banha.point_price')}}</th>
                    <th>{{__('banha.points')}}</th>
                    <th>{{__('banha.total_price')}}</th>
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
                    {"data": 'user', name: 'user', orderable: false, searchable: true},
                    {"data": 'user_phone', name: 'user_phone', orderable: false, searchable: true},
                    {"data": 'status', name: 'status', orderable: false, searchable: true},
                    {"data": 'points', name: 'points', orderable: false, searchable: true},
                    {"data": 'point_price', name: 'point_price', orderable: false, searchable: true},
                    {"data": 'total', name: 'total', orderable: false, searchable: true},
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
            $(document).on("click", ".accept-transfer", function () {
                let id = $(this).data("id");
                confirmAction(id, 'accepted', "{{ __('banha.confirm_accept') }}", "{{ __('banha.accepted') }}");
            });

            // رفض الاشتراك
            $(document).on("click", ".reject-transfer", function () {
                let id = $(this).data("id");
                confirmAction(id, 'refused', "{{ __('banha.confirm_reject') }}", "{{ __('banha.refused') }}");
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
                        updateSubscriptionStatus(id, status, successText);
                    }
                });
            }

            function updateSubscriptionStatus(id, status, successText) {
                $.ajax({
                    url: "{{ route('points-transfer-requests.update', ':id') }}".replace(":id", id),
                    type: "put",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "{{ __('banha.success') }}",
                            text: successText,
                        });
                        $('#dataTable').DataTable().ajax.reload();
                    },
                });

            }
        });
    </script>
@endsection
