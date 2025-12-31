<form id="form" action="{{$storeRoute}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.title')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[title]"
                       data-validation="required">
            </div>
        @endforeach
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.description')}} {!! getFieldLanguage($locale) !!}</label>
                <textarea type="text" class="form-control" name="{{ $locale }}[description]"
                          data-validation="required"></textarea>
            </div>
        @endforeach
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
            <div class="col-3 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.price')}}</label>
            <input type="number" class="form-control" min="0.01" step="0.01" name="price" data-validation="required">
        </div>
            <div class="col-3 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.amount')}}</label>
            <input type="number" class="form-control" min="1" name="amount" data-validation="required">
        </div>
            <div class="col-3 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.max_quantity_for_order')}}</label>
                <input type="number" class="form-control" min="1" name="max_quantity_for_order"
                       data-validation="required">
            </div>
            <div class="col-3 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.points')}}</label>
            <input type="number" class="form-control" min="0.1" step="0.01" name="points" data-validation="required">
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.made_in_egypt')}}</label>
            <select class="form-control" name="made_in_egypt" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes">{{__("banha.yes")}}</option>
                <option value="no">{{__("banha.no")}}</option>
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.our_products')}}</label>
            <select class="form-control" name="our_products" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes">{{__("banha.yes")}}</option>
                <option value="no">{{__("banha.no")}}</option>
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.has_offer')}}</label>
            <select class="form-control" id="has_offer" name="has_offer" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes">{{__("banha.yes")}}</option>
                <option value="no">{{__("banha.no")}}</option>
            </select>
        </div>
        <div id="offer" style="display: none">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="type" class="form-label">{{__('banha.offer_type')}}</label>
                    <select class="form-control" name="type" data-validation="required">
                        <option value="">{{__("banha.choose")}}</option>
                        @foreach($offerTypes as $offerType)
                            <option value="{{$offerType->value}}">
                                {{ \App\Enums\OfferTypeisEnum::tryFrom($offerType->value)->lang() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="value" class="form-label">{{__('banha.value')}}</label>
                    <input type="number" class="form-control" min="1" name="value" data-validation="required">
                </div>

                <div class="col-6 mb-3">
                    <label for="from_date" class="form-label">{{__('banha.from_date')}}</label>
                    <input type="date" class="form-control" name="from_date" data-validation="required">
                </div>

                <div class="col-6 mb-3">
                    <label for="to_date" class="form-label">{{__('banha.to_date')}}</label>
                    <input type="date" class="form-control" name="to_date" data-validation="required">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 mb-3">
            <label for="nameBasic" class="form-label mb-0">{{__('banha.images')}}</label>
            <button type="button" id="toggleFeaturesBtn" class="btn btn-primary">
                {{ __('banha.add_images') }}
            </button>
        </div>
        <div id="imagesTableWrapper" style="display: none;">
            <div class="col-12 mb-3">
                <label for="images" class="form-label">{{ __('banha.images') }}</label>
                <input type="file" id="images" class="dropify" name="images[]" multiple accept="image/*"
                       data-validation="required">
                <small id="images-count" class="text-muted d-block mt-2">
                    لم يتم اختيار صور بعد
                </small>
            </div>
        </div>
        <div class="col-12 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.image')}}</label>
            <input type="file" class="dropify" name="image" data-validation="required">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

<script>
    $(document).on('click', '#toggleProductAttributesBtn', function () {
        let wrapper = $('#ProductAttributesTableWrapper');
        if (wrapper.is(':visible')) {
            wrapper.hide();
            $(this).text('{{ __("banha.add_product_attributes") }}');
        } else {
            wrapper.show();
            $(this).text('{{ __("banha.show_product_attributes") }}');
        }
    });
    $('#images').on('change', function () {
        const count = this.files.length;
        const text = count > 0
            ? `تم اختيار ${count} صورة`
            : 'لم يتم اختيار صور بعد';
        $('#images-count').text(text);
    });
    $('#max_quantity_for_order').on('input', function () {
        var max_quantity_for_order = parseFloat($(this).val());
        var amount = parseFloat($('#amount').val());
        if (max_quantity_for_order > amount) {
            toastr.warning('{{ __("banha.max_quantity_for_order_must_be_equal_or_less_than_amount") }}');
            $(this).val(amount); // إعادة ضبط القيمة للحد الأقصى
        }
    });

</script>
