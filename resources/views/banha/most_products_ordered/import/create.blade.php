<div class="text text-center mb-2">
   <span class="text-success"> {{ __("banha.import_excel_warining") }}</span>
</div>
<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.main_category')}}</label>
            <select class="form-control" id="main_category" name="main_category_id" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                @foreach($mainCategories as $mainCategory)
                    <option value="{{$mainCategory->id}}">{{$mainCategory->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.sub_category')}}</label>
            <select class="form-control" id="sub_categories" name="sub_category_id" data-validation="required">
            </select>
            <span class="text-danger">{{__('banha.you_must_choose_main_category_first')}}</span>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.brand')}}</label>
            <select class="form-control" name="brand_id">
                <option value="">{{__("banha.choose")}}</option>
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 mb-3">
            <h5>{{ __('banha.you_must_download_file_model_excel') }}</h5>
            <a href="{{ asset('admin/assets/importProducts.xlsx') }}" download class="btn btn-danger"
               style="color: white">
                <i class="fas fa-file-excel"></i>
                <span style="margin-right:8px;">{{ __('banha.download_file') }}</span>
            </a>
        </div>
        <div class="alert alert-warning mt-3" role="alert">
            <strong>📌 ملاحظات هامة:</strong>
            <ul class="mb-0 mt-2">
                <li>
                    يجب أن تكون الإجابة في عمود <strong>(صنع في مصر)</strong> إما
                    <code>yes</code> أو <code>no</code> فقط.
                </li>
                <li>
                    يجب أن تكون الإجابة في عمود <strong>(من منتجاتنا)</strong> أيضًا
                    <code>yes</code> أو <code>no</code> فقط.
                </li>
                <li>
                    أي قيمة أخرى سيتم تجاهلها.
                </li>
            </ul>
        </div>

        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.upload_sheet_excel')}}</label>
            <input type="file" class="dropify" name="file" data-validation="required">
            <div class="progress mt-3" style="height: 20px; display: none;">
                <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                     role="progressbar" style="width: 0%">0%</div>
            </div>
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

