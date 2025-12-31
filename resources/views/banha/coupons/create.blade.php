<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        <div class="col-6 mb-3">
            <label for="nameBasic" class="form-label">{{__('banha.code')}}</label>
            <input type="text" class="form-control" name="code" data-validation="required" id="generatedCode">
        </div>
        <div class="col-3 mb-3">
        </div>
        <div class="col-3 mb-3">
            <label for="nameBasic" class="form-label"></label>
            <button class="btn btn-danger mt-3" id="generateCodeButton" type="button">
                {{ __("banha.generate_code_random") }}
            </button>
        </div>
        <div class="col-4 mb-3">
            <label for="type" class="form-label">{{__('banha.type')}}</label>
            <select class="form-control" name="type" data-validation="required">
                <option value="">{{__("banha.choose")}}</option>
                @foreach($couponsTypes as $couponsType)
                    <option value="{{$couponsType->value}}">
                        {{ \App\Enums\CouponTypeisEnum::tryFrom($couponsType->value)->lang() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-4 mb-3">
            <label for="value" class="form-label">{{__('banha.value')}}</label>
            <input type="number" class="form-control" min="1" name="value" data-validation="required">
        </div>
        <div class="col-4 mb-3">
            <label for="value" class="form-label">{{__('banha.usage_times')}}</label>
            <input type="number" class="form-control" min="1" name="usage_times" data-validation="required">
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
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>

