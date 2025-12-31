<style>
    /* 📦 حاوية رئيسية موحدة */
    .order-container {
        max-width: 1200px; /* العرض الكلي للصفحة */
        margin: 0 auto; /* توسيط الحاوية */
        padding: 0 15px; /* مسافة من الجوانب */
    }

    /* 🧾 كروت تفاصيل الطلب */
    .order-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order-item {
        flex: 1 1 calc(50% - 20px);
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .order-item .icon {
        font-size: 22px;
        padding: 10px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
    }

    .order-item .title {
        font-weight: 600;
        color: #0d6efd;
        flex: 0 0 200px;
    }

    .order-item .value {
        font-weight: 500;
        color: #333;
    }

    /* 🪄 جدول المنتجات */
    .products-table {
        margin-top: 30px;
        width: 100%;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e0e0e0;
    }

    .products-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-table th {
        padding: 12px;
        font-weight: 600;
        text-align: center;
        background: #f9f9f9;
        color: #333;
        border-bottom: 1px solid #e0e0e0;
    }

    .products-table td {
        text-align: center;
        padding: 10px;
        color: #333;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .products-table tbody tr:nth-child(even) {
        background-color: #fafafa;
    }

    .products-table tbody tr:hover {
        background-color: #f2f6ff;
        transition: 0.2s;
    }

    .products-table img {
        max-width: 50px;
        max-height: 50px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    .products-table td:first-child {
        width: 70px;
    }

    .products-table td,
    .products-table th {
        border: none;
    }

    .products-table thead tr:first-child th:first-child {
        border-top-left-radius: 12px;
    }

    .products-table thead tr:first-child th:last-child {
        border-top-right-radius: 12px;
    }

    .products-table tfoot tr,
    .products-table tbody tr:last-child {
        background-color: #f8f9fa;
    }

    .products-table tfoot td,
    .products-table tbody tr:last-child td {
        font-weight: 600;
        padding: 12px;
    }

</style>

<div class="order-container">
    <!-- 🧾 كروت بيانات الطلب -->
    <div class="order-details">
        <div class="order-item">
            <div class="icon bg-primary"><i class="fas fa-user"></i></div>
            <div class="title">{{ __("banha.user_name") }}</div>
            <div class="value">{{ @$obj->user->first_name ?? '-' }} {{ @$obj->user->last_name ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-success"><i class="fas fa-phone"></i></div>
            <div class="title">{{ __("banha.user_phone") }}</div>
            <div class="value">{{ @$obj->user->phone ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-info"><i class="fas fa-barcode"></i></div>
            <div class="title">{{ __("banha.code") }}</div>
            <div class="value">{{ $obj->code ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-warning"><i class="fas fa-info-circle"></i></div>
            <div class="title">{{ __("banha.status") }}</div>
            <div class="value">{{ \App\Enums\ExternalOrderStatusEnum::tryFrom($obj->status)->lang() ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-secondary"><i class="fas fa-box"></i></div>
            <div class="title">{{ __("banha.orders_price") }}</div>
            <div class="value">{{ $obj->orders_price ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-dark"><i class="fas fa-map-marker-alt"></i></div>
            <div class="title">{{ __("banha.area") }}</div>
            <div class="value">{{ $obj->area->title ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-warning"><i class="fas fa-shipping-fast"></i></div>
            <div class="title">{{ __("banha.shipping_price") }}</div>
            <div class="value">{{ $obj->shipping_price ?? '-' }}</div>
        </div>
        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-dollar-sign"></i></div>
            <div class="title">{{ __("banha.final_price") }}</div>
            <div class="value">{{ $obj->final_price ?? '-' }}</div>
        </div>
    </div>

    <!-- 🪄 جدول المنتجات -->
    <div class="products-table">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('banha.order_category')}}</th>
                <th>{{__('banha.image')}}</th>
                <th>{{__('banha.price')}}</th>
                <th>{{__('banha.details')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($obj->orderDetails as $key=> $detail)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ @$detail->orderCategory->title ?? '-' }}</td>
                    <td><img src="{!! show_file(@$detail->image) !!}" alt="product"></td>
                    <td>{{ @$detail->price }}</td>
                    <td title="{{@$detail->details}}">
                        {{ \Illuminate\Support\Str::limit(@$detail->details , 30 ) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
