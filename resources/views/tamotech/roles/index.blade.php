@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    <div class="card-header mb-2">
        <h4 class="card-title">
        </h4>
        @if(checkIfHasPermission('roles-create'))
            <div class="justify-content-end">
                <a href="{{route('roles.create')}}" class="btn btn-success"
                   title="{{__('permission.role')}}">
                    <i class="fa fa-plus-circle" style="padding-left: 5px;"></i>   {{__('permission.add role')}}
                </a>
            </div>
        @endif
    </div>
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('main.name')}}</th>
                    <th>{{__('main.display_name')}}</th>
                    <th>{{__('main.description')}}</th>
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
                ajax: "{{ $mainRoute }}",
                columns: [
                    {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'name', name: 'name', orderable: false, searchable: true},
                    {data: 'display_name', name: 'display_name', orderable: false, searchable: true},
                    {data: 'description', name: 'description', orderable: false, searchable: true},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
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
    </script>
@endsection
