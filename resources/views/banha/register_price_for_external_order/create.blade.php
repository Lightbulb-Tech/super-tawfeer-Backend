<form id="form" action="{{$storeRoute}}" method="post">
    @csrf
    <div class="row">
        @foreach($external_order->orderDetails as $key => $detail)
            <div class="col-6 mb-4">
                <label class="form-label fw-bold">
                    {{ __('banha.order') }} ({{ $loop->iteration }}) ({{ $detail->orderCategory->title ?? '-' }})
                </label>
                <p class="small text-muted mb-2">{{ $detail->details ?? '-' }}</p>
                @if(!empty($detail->image))
                    <div class="mb-2">
                        <img src="{{ show_file($detail->image) }}" alt="order image" class="img-fluid rounded border"
                             style="max-height: 120px; width: 100%; object-fit: cover;">
                    </div>
                @endif
                <label class="form-label text-danger">{{ __('banha.price') }}</label>
                <input type="number" class="form-control" min="0.01" step="0.01" name="prices[]"
                       data-validation="required">

                <input type="hidden" name="orderDetailsIds[]" value="{{ $detail->id }}">
            </div>
        @endforeach
        <input type="hidden" name="order_id" value="{{ $external_order->id }}">
        <div class="col-12 mb-4">
            <label class="form-label fw-bold">
                {{ __('banha.total_orders_prices') }}
            </label>
            <input type="number" class="form-control" id="orders_price" readonly name="orders_price">
        </div>
    </div>
    <br>
    {!! storeButton($storeRoute) !!}
    {!! closeButton() !!}
</form>
<script>
    $(document).ready(function() {
        function updateTotalPrice() {
            let total = 0;
            $('input[name="prices[]"]').each(function() {
                let val = parseFloat($(this).val());
                if (!isNaN(val)) {
                    total += val;
                }
            });
            $('#orders_price').val(total.toFixed(2));
        }
        $(document).on('input', 'input[name="prices[]"]', function() {
            updateTotalPrice();
        });
        updateTotalPrice();
    });
</script>
