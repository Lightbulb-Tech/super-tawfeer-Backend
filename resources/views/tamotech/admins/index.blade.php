@extends('tamotech.layout.index')
@section('title')
    {{__('main.admins')}}
@endsection
@section('content')
    {!! createBtn($createRoute,$addButtonText) !!}
    <div class="card p-3">
        <div class="card-datatable table-responsive">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('main.name')}}</th>
                    <th>{{__('main.image')}}</th>
                    <th>{{__('main.phone')}}</th>
                    <th>{{__('main.email')}}</th>
                    <th>{{__('main.actions')}}</th>
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
                ajax: "{{ $mainRoute }}",
                columns: [
                    {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {"data": "name", orderable: false, searchable: false},
                    {"data": "image", orderable: false, searchable: false},
                    {"data": "phone", orderable: false, searchable: false},
                    {"data": "email", orderable: false, searchable: false},
                    {"data": "actions", orderable: false, searchable: false}
                ],
                language: {
                    "sProcessing": "{{trans('dataTable.processing')}}",
                    {{--"sLengthMenu": "{{trans('dataTable.sLengthMenu')}}",--}}
                    "sZeroRecords": "<img src='{{asset('admin/images/emptybox.webp')}}' width='100px' height='100px'>",
                    {{--"sInfo": "{{trans('dataTable.sInfo')}}",--}}
                        {{--    "sInfoEmpty": "{{trans('dataTable.sInfoEmpty')}}",--}}
                        {{--    "sInfoFiltered": "{{trans('dataTable.sInfoFiltered')}}",--}}
                        {{--    "sInfoPostFix": "",--}}
                    "sSearch": "{{__("datatable.search")}}",
                    {{--"sUrl": "",--}}
                    "oPaginate": {
                        "sFirst": "{{trans('dataTable.sFirst')}}",
                        "sPrevious": "{{__("datatable.previous")}}",
                        "sNext": "{{__("datatable.next")}}",
                        "sLast": "{{trans('dataTable.sLast')}}"
                    },
                },
                dom: '<"row  mt-4"<"col-sm-6"B><"col-sm-6"f>>rtip',
                buttons: [
                    // {
                    //     extend: 'excel',
                    //     text: '📥 تصدير Excel',
                    //     className: 'btn btn-success me-2',
                    //     exportOptions: {
                    //         columns: [1, 3, 4]
                    //     }
                    // },
                    // {
                    //     extend: 'print',
                    //     text: '🖨️ طباعة',
                    //     className: 'btn btn-primary',
                    //     exportOptions: {
                    //         columns: [1, 3, 4]
                    //     }
                    // },
                    // {
                    //     extend: 'pdf',
                    //     text: '📄 تصدير PDF',
                    //     className: 'btn btn-danger',
                    //     exportOptions: {
                    //         columns: [1, 4]
                    //     },
                    //     customize: function (doc) {
                    //         doc.defaultStyle = {
                    //             font: 'Amiri',
                    //             alignment: 'right' // لعرض عربي من اليمين
                    //         };
                    //     }
                    // }
                ]

            });

        });
    </script>
@endsection
