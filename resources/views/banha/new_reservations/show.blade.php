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
            <div class="icon bg-primary"><i class="fas fa-user"></i></div> <!-- اسم المستخدم -->
            <div class="title">{{ __("banha.user_name") }}</div>
            <div class="value">{{ isset($obj->user) ? @$obj->user->first_name . ' ' .  @$obj->user->last_name : $obj->name  }} </div>
        </div>

        <div class="order-item">
            <div class="icon bg-success"><i class="fas fa-phone-alt"></i></div> <!-- رقم الهاتف -->
            <div class="title">{{ __("banha.user_phone") }}</div>
            <div class="value">{{ isset($obj->user) ? @$obj->user->phone  : $obj->phone  }} </div>
        </div>

        <div class="order-item">
            <div class="icon bg-info"><i class="fas fa-barcode"></i></div> <!-- كود الحجز -->
            <div class="title">{{ __("banha.code") }}</div>
            <div class="value">{{ $obj->code ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-warning"><i class="fas fa-info-circle"></i></div> <!-- الحالة -->
            <div class="title">{{ __("banha.status") }}</div>
            <div class="value">{{ \App\Enums\ReservationStatusEnum::tryFrom($obj->status)->lang() ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-secondary"><i class="fas fa-truck"></i></div> <!-- المركبة -->
            <div class="title">{{ __("banha.vehicle") }}</div>
            <div class="value">{{ $obj->vehicle->model ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-success"><i class="fas fa-ticket-alt"></i></div> <!-- كوبون موجود -->
            <div class="title">{{ __("banha.has_coupon") }}</div>
            <div class="value">
                @if($obj->coupon_id == null)
                    {{ __("banha.no") }}
                @else
                    {{ __("banha.yes") }}
                @endif
            </div>
        </div>

        @if($obj->coupon_id != null)
            <div class="order-item">
                <div class="icon bg-dark"><i class="fas fa-tag"></i></div> <!-- نوع الكوبون -->
                <div class="title">{{ __("banha.coupon_type") }}</div>
                <div class="value">{{ \App\Enums\CouponTypeisEnum::tryFrom($obj->coupon_type)->lang() ?? '-' }}</div>
            </div>
            <div class="order-item">
                <div class="icon bg-warning"><i class="fas fa-coins"></i></div> <!-- قيمة الكوبون -->
                <div class="title">{{ __("banha.coupon_value") }}</div>
                <div class="value">{{ $obj->coupon_value ?? '-' }}</div>
            </div>
            <div class="order-item">
                <div class="icon bg-info"><i class="fas fa-percent"></i></div> <!-- خصم الكوبون -->
                <div class="title">{{ __("banha.coupon_discount") }}</div>
                <div class="value">{{ $obj->coupon_discount ?? '-' }}</div>
            </div>
        @endif

        <div class="order-item">
            <div class="icon bg-dark"><i class="fas fa-map-marker-alt"></i></div> <!-- من العنوان -->
            <div class="title">{{ __("banha.from_address") }}</div>
            <div class="value">{{ $obj->from_address ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-warning"><i class="fas fa-map-marked-alt"></i></div> <!-- إلى العنوان -->
            <div class="title">{{ __("banha.to_address") }}</div>
            <div class="value">{{ $obj->to_address ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-calendar-alt"></i></div> <!-- التاريخ -->
            <div class="title">{{ __("banha.date") }}</div>
            <div class="value">{{ $obj->date ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-clock"></i></div> <!-- الوقت -->
            <div class="title">{{ __("banha.time") }}</div>
            <div class="value">{{ $obj->time ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-dollar-sign"></i></div> <!-- سعر الكيلومتر -->
            <div class="title">{{ __("banha.price_of_km") }}</div>
            <div class="value">{{ $obj->price_of_km ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-road"></i></div> <!-- عدد الكيلومترات -->
            <div class="title">{{ __("banha.number_of_km") }}</div>
            <div class="value">{{ $obj->number_of_km ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-money-bill-wave"></i></div> <!-- السعر الإجمالي -->
            <div class="title">{{ __("banha.price") }}</div>
            <div class="value">{{ $obj->price ?? '-' }}</div>
        </div>

        <div class="order-item">
            <div class="icon bg-danger"><i class="fas fa-check-circle"></i></div> <!-- السعر النهائي -->
            <div class="title">{{ __("banha.final_price") }}</div>
            <div class="value">{{ $obj->final_price ?? '-' }}</div>
        </div>
    </div>
</div>
