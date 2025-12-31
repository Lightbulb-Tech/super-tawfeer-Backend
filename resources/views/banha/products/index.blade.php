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
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("banha.main_category")}}</label>
                <select name="main_category_id" id="main_category_filter" class="form-control select2">
                    <option value="">{{__("banha.choose")}}</option>
                    @foreach($main_categories as $main_category)
                        <option value="{{ $main_category->id }}">{{ $main_category->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{__("banha.sub_category")}}</label>
                <select name="sub_category_id" id="sub_categories_filter" class="form-control select2">
                    <option value="">{{__("banha.choose")}}</option>
                </select>
            </div>
            <span class="text-danger">{{__('banha.you_must_choose_main_category_first')}}</span>
        </div>
    </div>
    {!! createBtn($createRoute,$addButtonText) !!}
    {!! createBtn($importRouteCreate,$addProductsWithSheetExcel ,'danger') !!}
    <button id="exportExcelBtn" class="btn btn-success mb-2">
        <i class="ti ti-file-spreadsheet me-1"></i>
        <span>تصدير Excel</span>
    </button>
    <div class="card p-3">
        <div class="card-datatable table-responsive pt-0">
            <table id="dataTable" class="datatables-basic table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('banha.title')}}</th>
                    <th>{{__('banha.image')}}</th>
                    <th>{{__('banha.main_category')}}</th>
                    <th>{{__('banha.sub_category')}}</th>
                    <th>{{__('banha.number_of_sales')}}</th>
                    <th>{{__('banha.number_of_orders')}}</th>
                    <th>{{__('banha.price')}}</th>
                    <th>{{__('banha.amount')}}</th>
                    <th>{{__('banha.points')}}</th>
                    <th class="no-export">{{__('banha.is_active')}}</th>
                    <th class="no-export">{{__('banha.actions')}}</th>
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
                ajax: {
                    url: "{{ $dataTableRoute }}",
                    data: function (response) {
                        response.main_category_id = $('#main_category_filter').val();
                        response.sub_category_id = $('#sub_categories_filter').val();
                    }
                },
                columns: [
                    {"data": 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {"data": 'title', name: 'product_translations.title', orderable: false, searchable: true},
                    {"data": 'image', name: 'products.image', orderable: false, searchable: true},
                    {"data": 'main_category', name: 'products.main_category_id', orderable: false, searchable: true},
                    {"data": 'sub_category', name: 'products.sub_category_id', orderable: false, searchable: true},
                    {"data": 'sold_count', name: 'products.sold_count', orderable: false, searchable: true},
                    {"data": 'ordered_count', name: 'products.ordered_count', orderable: false, searchable: true},
                    {"data": 'price', name: 'products.price', orderable: false, searchable: true},
                    {"data": 'amount', name: 'products.amount', orderable: false, searchable: true},
                    {"data": 'points', name: 'products.points', orderable: false, searchable: true},
                    {"data": 'is_active', name: 'products.is_active', orderable: false, searchable: true},
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
            $('#main_category_filter, #sub_categories_filter').change(function () {
                myTable.ajax.reload();
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
                        url: "{{ route('product-active.update', ':id') }}".replace(':id', rentId),
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
        $(document).on('change', '#main_category', function () {
            var mainCategoryId = $(this).val();
            if (mainCategoryId === '' || mainCategoryId === null) {
                $('#sub_categories').html('');
                $('.text-danger').show();
                return;
            }
            if (!isNaN(mainCategoryId) && mainCategoryId.trim() !== '') {
                var url = "{{route('subCategories-for-mainCategory.index',['main_category_id'=>'mainCategoryId'])}}";
                url = url.replace('mainCategoryId', mainCategoryId);
                $.ajax({
                    url: url,
                    method: 'Get',
                    success: function (response) {
                        $('#sub_categories').html(response.data.html);
                        $('.text-danger').hide();
                    }
                })
            }
        });
        $(document).on('change', '#main_category_filter', function () {
            var mainCategoryId = $(this).val();
            if (mainCategoryId === '' || mainCategoryId === null) {
                $('#sub_categories').html('');
                $('.text-danger').show();
                return;
            }
            if (!isNaN(mainCategoryId) && mainCategoryId.trim() !== '') {
                var url = "{{route('subCategories-for-mainCategory.index',['main_category_id'=>'mainCategoryId'])}}";
                url = url.replace('mainCategoryId', mainCategoryId);
                $.ajax({
                    url: url,
                    method: 'Get',
                    success: function (response) {
                        $('#sub_categories_filter').html(response.data.html);
                        $('.text-danger').hide();
                    }
                })
            }
        });
        $(document).on('change', '#has_offer', function () {
            var hasOffer = $(this).val();
            if (hasOffer === 'yes') {
                $('#offer').show()
            } else {
                $('#offer').hide()
            }
        });
        $(document).on('click', '#toggleFeaturesBtn', function () {
            let wrapper = $('#imagesTableWrapper');
            if (wrapper.is(':visible')) {
                wrapper.hide();
                $(this).text('{{ __("banha.add_images") }}');
            } else {
                wrapper.show();
                $(this).text('{{ __("banha.hide_images") }}');
            }
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
                let fileName = 'المنتجات.xlsx';
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
