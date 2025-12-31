<style>
    .image-box {
        width: 100%; /* يتبع عرض العمود col-3 */
        height: 200px; /* 👈 غيّر الارتفاع حسب المطلوب */
        position: relative;
        overflow: hidden; /* يخفي أي جزء زائد للصورة */
        border-radius: .5rem; /* نفس انحناء الصورة لو حبيت */
    }

    .fixed-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* يملأ الحاوية مع الحفاظ على النسبة */
        object-position: center;
        display: block;
    }
    /* إخفاء الزر افتراضيًا */
    .image-box .deleteImage {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* إظهاره عند مرور الماوس على الـdiv */
    .image-box:hover .deleteImage {
        opacity: 1;
    }


</style>
<form id="form" action="{{$updateRoute}}" method="post" enctype="multipart/form-data">
    @method('Put')
    @csrf
    <div class="row">
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.title')}} {!! getFieldLanguage($locale) !!}</label>
                <input type="text" class="form-control" name="{{ $locale }}[title]"
                       data-validation="required"
                       value="{{$obj->translate($locale)->title}}">
            </div>
        @endforeach
        @foreach (config('translatable.locales') as $locale)
            <div class="col-6 mb-3">
                <label for="nameBasic"
                       class="form-label">{{__('banha.description')}} {!! getFieldLanguage($locale) !!}</label>
                <textarea type="text" class="form-control" name="{{ $locale }}[description]"
                          data-validation="required">{{$obj->translate($locale)->description}}</textarea>
            </div>
        @endforeach
            <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.main_category')}}</label>
            <select class="form-control" id="main_category" name="main_category_id" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                @foreach($mainCategories as $mainCategory)
                    <option
                        value="{{$mainCategory->id}}" @selected($mainCategory->id == $obj->main_category_id)>{{$mainCategory->title}}</option>
                @endforeach
            </select>
        </div>
            <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.sub_category')}}</label>
            <select class="form-control" id="sub_categories" name="sub_category_id" data-validation="required">
                @foreach($subCategories as $subCategory)
                    <option
                        value="{{$subCategory->id}}" @selected($subCategory->id == $obj->sub_category)>{{$subCategory->title}}</option>
                @endforeach
            </select>
            {{--                <span class="text-danger">{{__('banha.you_must_choose_main_category_first')}}</span>--}}
        </div>
            <div class="col-4 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.brand')}}</label>
                <select class="form-control" name="brand_id">
                    <option value="">{{__("banha.choose")}}</option>
                    @foreach($brands as $brand)
                        <option
                            value="{{$brand->id}}" @selected($brand->id == $obj->brand_id)>{{$brand->title}}</option>
                    @endforeach
                </select>
            </div>
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.price')}}</label>
            <input type="number" class="form-control" min="0.01" step="0.01" value="{{$obj->price}}" name="price"
                   data-validation="required">
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.amount')}}</label>
            <input type="number" class="form-control" min="1" name="amount" value="{{$obj->amount}}"
                   data-validation="required">
        </div>
        <div class="col-4 mb-3">
            <label for="nameBasic"
                   class="form-label">{{__('banha.points')}}</label>
            <input type="number" class="form-control" min="0.01" step="0.01" name="points" value="{{$obj->points}}"
                   data-validation="required">
        </div>
            <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.made_in_egypt')}}</label>
            <select class="form-control" name="made_in_egypt" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes" @selected($obj->made_in_egypt == 'yes')>{{__("banha.yes")}}</option>
                <option value="no" @selected($obj->made_in_egypt == 'no')>{{__("banha.no")}}</option>
            </select>
        </div>
            <div class="col-4 mb-3">
                <label for="nameBasic" class="form-label">{{__('banha.our_products')}}</label>
                <select class="form-control" name="our_products" data-validation="required">
                    <option value="">{{__("banha.choose")}}</option>
                    <option value="yes" @selected($obj->our_products == 'yes')>{{__("banha.yes")}}</option>
                    <option value="no" @selected($obj->our_products == 'no')>{{__("banha.no")}}</option>
                </select>
            </div>
            <div class="col-4 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.has_offer')}}</label>
            <select class="form-control" id="has_offer" name="has_offer" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                <option value="yes" @selected(isset($obj->offer))>{{__("banha.yes")}}</option>
                <option value="no" @selected(!isset($obj->offer))>{{__("banha.no")}}</option>
            </select>
        </div>
        <div id="offer" style="display: @if(isset($obj->offer)) block @else none  @endif">
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="type" class="form-label">{{__('banha.offer_type')}}</label>
                    <select class="form-control" name="type" data-validation="required">
                        <option value="">{{__("banha.choose")}}</option>
                        @foreach($offerTypes as $offerType)
                            <option
                                value="{{$offerType->value}}" @selected($offerType->value == @$obj->offer->type)>
                                {{ \App\Enums\OfferTypeisEnum::tryFrom($offerType->value)->lang() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="value" class="form-label">{{__('banha.value')}}</label>
                    <input type="number" class="form-control" min="0.01" step="0.01" name="value"
                           value="{{@$obj->offer->value}}"
                           data-validation="required">
                </div>

                <div class="col-6 mb-3">
                    <label for="from_date" class="form-label">{{__('banha.from_date')}}</label>
                    <input type="date" class="form-control" name="from_date" value="{{@$obj->offer->from_date}}"
                           data-validation="required">
                </div>

                <div class="col-6 mb-3">
                    <label for="to_date" class="form-label">{{__('banha.to_date')}}</label>
                    <input type="date" class="form-control" name="to_date" value="{{@$obj->offer->to_date}}"
                           data-validation="required">
                </div>
            </div>
        </div>
        @if(isset($obj->images))
            <label for="nameBasic" class="form-label mb-0">{{__('banha.product_images')}}</label>
            @foreach($obj->images as $image)
                <div class="col-3 mb-3" style="max-width:200px;">
                    <div class="image-box position-relative">
                        <img src="{{ show_file($image->image) }}"
                             class="img-fluid rounded fixed-img"
                             alt="صورة المنتج">
                        <button type="button" data-id="{{$image->id}}"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 deleteImage"
                                aria-label="حذف">
                            {{__('banha.delete')}}
                        </button>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="d-flex align-items-center gap-2 mb-3">
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
            <input type="file" class="dropify" name="image"
                   data-default-file="{{ image_path($obj->image) }}">
        </div>
    </div>
    <br>
    {!! updateButton($updateRoute) !!}
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
    $(".deleteImage").on('click', function () {
        var imageId = $(this).data('id');
        var url = "{{route('product-images.destroy','imageId')}}".replace('imageId', imageId);
        $.ajax({
            url: url,
            type: 'Post',
            data: {
                _token: "{{csrf_token()}}",
                    _method: 'Delete'
                },
                success: function () {
                    $('[data-id="' + imageId + '"]').closest('.col-3').remove();
                }
            })
        })
</script>
