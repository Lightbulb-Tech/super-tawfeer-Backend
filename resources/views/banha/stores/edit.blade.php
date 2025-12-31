<form id="form" action="{{$updateRoute}}" method="post">
    @method('Put')
    @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.title')}} </label>
            <input type="text" class="form-control" name="title"
                   data-validation="required" value="{{$obj->title}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.logo')}}</label>
            <input type="file" class="dropify" name="logo"
                   data-default-file="{{  image_path($obj->logo)}}">
        </div>
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.cover_image')}}</label>
            <input type="file" class="dropify" name="cover_image"
                   data-default-file="{{ image_path($obj->cover_image) }}">
        </div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <label for="nameBasic" class="form-label mb-0">{{__('banha.features')}}</label>
            <button type="button" id="toggleFeaturesBtn" class="btn btn-primary">
                {{ count($obj->features) > 0 ? __('banha.hide_features') : __('banha.show_features') }}
            </button>
        </div>
        <div id="featuresTableWrapper" style="display: {{ count($obj->features) > 0 ? 'block' : 'none' }};">
        <table id="dynamicTable" class="table table-bordered">
                <thead>
                <tr>
                    @foreach (config('translatable.locales') as $locale)
                        <th>{{ __('banha.title') }} {!! getFieldLanguage($locale) !!}</th>
                    @endforeach
                    @foreach (config('translatable.locales') as $locale)
                        <th>{{ __('banha.description') }} {!! getFieldLanguage($locale) !!}</th>
                    @endforeach
                    <th>{{ __('banha.icon') }} </th>
                    <th class="text-center align-middle">{{ __('banha.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($obj->features) && count($obj->features) > 0)
                    @foreach($obj->features as $key=>$item)
                        <tr data-index="0">
                            @foreach (config('translatable.locales') as $locale)
                                <td>
                                    <input type="text" class="form-control"
                                           name="features[{{$key}}][{{ $locale }}][title]" data-validation="required"
                                           value="{{$item->translate($locale)->title}}">
                                </td>
                            @endforeach
                            @foreach (config('translatable.locales') as $locale)
                                <td>
                        <textarea type="text" class="form-control"
                                  name="features[{{$key}}][{{ $locale }}][description]" data-validation="required">
                            {{$item->translate($locale)->description}}
                        </textarea>
                                </td>
                            @endforeach
                            <td>
                                <input type="file" class="dropify"
                                       name="features[{{$key}}][icon]"
                                       data-default-file="{{ image_path($item->icon) }}">
                            </td>
                            <td class="text-center align-middle">
                                <button type="button"
                                        class="btn btn-danger deleteRow">{{ __('banha.remove') }}</button>
                                <button type="button"
                                        class="btn btn-success addRow">{{ __('banha.add') }}</button>
                            </td>
                            <input type="hidden" name="features[{{$key}}][id]" value="{{$item->id}}">
                        </tr>
                        <input type="hidden" name="featuresIds[]" value="{{$item->id}}">
                    @endforeach
                @else
                    <tr data-index="0">
                        @foreach (config('translatable.locales') as $locale)
                            <td>
                                <input type="text" class="form-control"
                                       name="features[0][{{ $locale }}][title]" data-validation="required">
                            </td>

                        @endforeach
                        @foreach (config('translatable.locales') as $locale)
                            <td>
                        <textarea type="text" class="form-control"
                                  name="features[0][{{ $locale }}][description]" data-validation="required">
                        </textarea>
                            </td>
                        @endforeach
                        <td>
                            <input type="file" class="dropify"
                                   name="features[0][icon]" data-validation="required">
                        </td>
                        <td class="text-center align-middle">
                            <button type="button"
                                    class="btn btn-danger deleteRow">{{ __('banha.remove') }}</button>
                            <button type="button"
                                    class="btn btn-success addRow">{{ __('banha.add') }}</button>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
    {!! closeButton() !!}

</form>
<script>
    const locales = @json(config('translatable.locales'));
    let rowIndex = $('#dynamicTable tbody tr').length;

    $(document).ready(function () {
        function updateDeleteButtons() {
            const rows = $('#dynamicTable tbody tr');

            // نحدد هل الصفحة تعديل ولا إنشاء
            const hasFeatures = {{ isset($obj->features) && count($obj->features) > 0 ? 'true' : 'false' }};

            if (hasFeatures) {
                // صفحة التعديل → مفيش أي تعطيل
                rows.find('.deleteRow').prop('disabled', false);
            } else {
                // صفحة الإنشاء → امنع حذف آخر صف فقط
                if (rows.length === 1) {
                    rows.find('.deleteRow').prop('disabled', true);
                } else {
                    rows.find('.deleteRow').prop('disabled', false);
                }
            }
        }


        // إضافة صف جديد
        $(document).on('click', '.addRow', function () {
            let newRow = `<tr data-index="${rowIndex}">`;

            // Titles
            locales.forEach(locale => {
                let validation = locale === 'ar' ? 'required' : 'required';
                newRow += `
        <td>
            <input type="text" class="form-control"
                   name="features[${rowIndex}][${locale}][title]"
                   data-validation="${validation}">
        </td>`;
            });

            // Descriptions
            locales.forEach(locale => {
                let validation = locale === 'ar' ? 'required' : 'required';
                newRow += `
        <td>
            <textarea type="text" class="form-control"
                   name="features[${rowIndex}][${locale}][description]"
                   data-validation="${validation}">
            </textarea>
        </td>`;
            });
            newRow += `
        <td>
            <input type="file" class="dropify"
                   name="features[${rowIndex}][icon]"
                   data-validation="required">
        </td>`;
            newRow += `
        <td class="text-center align-middle">
            <button type="button" class="btn btn-danger deleteRow">{{ __('banha.remove') }}</button>
            <button type="button" class="btn btn-success addRow">{{ __('banha.add') }}</button>
        </td>
    </tr>`;
            $('#dynamicTable tbody').append(newRow);
            // إعادة تهيئة dropify للـ input الجديد
            $('.dropify').dropify({
                messages: {
                    default: '{{__("banha.Drag image here")}}',
                    replace: 'اسحب صورة جديدة أو اضغط للاستبدال',
                    remove: 'إزالة',
                    error: 'عذرًا، الملف غير صالح'
                }
            });
            rowIndex++;
            updateDeleteButtons();
        });
        // حذف صف
        $(document).on('click', '.deleteRow', function () {
            $(this).closest('tr').remove();
            updateDeleteButtons();
        });

        updateDeleteButtons();
    });
</script>
