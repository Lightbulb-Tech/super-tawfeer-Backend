@extends('tamotech.layout.index')
@section('title')
    {{$bladeTitle}}
@endsection
@section('content')
    {{--    {!! createBtn($createRoute,$addButtonText) !!}--}}
    <button id="exportExcelBtn" class="btn btn-success">
        <i class="ti ti-file-spreadsheet me-1"></i>
        <span>تصدير Excel</span>
    </button>
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('banha.image')}}</th>
                    <th>{{__('banha.name')}}</th>
                    <th>{{__('banha.phone')}}</th>
                    <th>{{__('banha.status')}}</th>
                    <th>{{__('banha.number_of_derived')}}</th>
                    {{--                    <th>{{__('banha.actions')}}</th>--}}
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
                    {"data": 'name', name: 'name', orderable: false, searchable: true},
                    {"data": 'phone', name: 'phone', orderable: false, searchable: true},
                    {"data": 'status', name: 'status', orderable: false, searchable: true},
                    {"data": 'number_of_orders', name: 'number_of_orders', orderable: false, searchable: true},
                    // {"data": "actions", orderable: false, searchable: false}
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
        document.getElementById('exportExcelBtn').addEventListener('click', function () {
            let btn = this;
            let originalContent = btn.innerHTML;

            // 🔹 عرض اللودر وتعطيل الزر
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> جاري التحميل...';
            btn.disabled = true;

            setTimeout(() => {
                let table = document.getElementById('dataTable').cloneNode(true);

                // 🧹 مسح محتوى الأعمدة التي تحتوي على الكلاس no-export
                table.querySelectorAll('td.no-export, th.no-export').forEach(cell => {
                    cell.innerHTML = ''; // نخلي الخلية فاضية
                });

                // 📄 إعداد التصدير
                let dataType = 'application/vnd.ms-excel';
                let fileName = 'السائقين الاكثر توصيلا.xls';
                let link = document.createElement('a');
                link.href = 'data:' + dataType + ', ' + encodeURIComponent(table.outerHTML);
                link.download = fileName;
                link.click();

                // ✅ إعادة الزر لحالته الأصلية
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }, 800);
        });
    </script>
@endsection
