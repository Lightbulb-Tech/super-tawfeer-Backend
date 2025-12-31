@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    {!! createBtn($createRoute,$addButtonText) !!}
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('banha.image')}}</th>
                    <th>{{__('banha.type')}}</th>
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
                    {"data": 'image', name: 'image', orderable: false, searchable: true},
                    {"data": 'type', name: 'type', orderable: false, searchable: true},
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
        $(document).ajaxComplete(function () {

            function handleTypeChange() {
                const type = $("#type").val();

                // إخفاء كل الأقسام أولاً
                $('#moduleNameDiv, #productsDiv, #categoriesDiv').hide();

                // إزالة الاسم من جميع السلكتات
                $('#productsDiv select, #categoriesDiv select').attr('name', '');

                if (type === 'module') {
                    $('#moduleNameDiv').show();
                } else if (type === 'product') {
                    $('#productsDiv').show().find('select').attr('name', 'module_id');
                } else if (type === 'category') {
                    $('#categoriesDiv').show().find('select').attr('name', 'module_id');
                }
            }

            function handleModuleNameChange() {
                const module = $("#module_name").val();

                // إخفاء الأقسام
                $('#productsDiv, #categoriesDiv').hide();
                $('#productsDiv select, #categoriesDiv select').attr('name', '');

                if (module === 'product') {
                    $('#productsDiv').show().find('select').attr('name', 'module_id');
                } else if (module === 'category') {
                    $('#categoriesDiv').show().find('select').attr('name', 'module_id');
                }
            }

            // تشغيل عند التغيير
            $("#type").on('change', handleTypeChange);
            $("#module_name").on('change', handleModuleNameChange);

            // تشغيل عند تحميل الصفحة (أو بعد كل Ajax)
            handleTypeChange();
            handleModuleNameChange();

        });


    </script>
@endsection
