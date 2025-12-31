@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    @if (auth('admin')->user()->admin_type == \App\Enums\AdminTypeisEnum::Developer->value)
        {!! createBtn($createRoute , __('permission.permissions')) !!}
    @endif
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('permission.description')}}</th>
                    <th>{{__('permission.description_ar')}}</th>
                    <th>{{__('permission.actions')}}</th>
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
                    {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {"data": "description", orderable: true, searchable: true},
                    {"data": "description_ar", orderable: true, searchable: true},
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
