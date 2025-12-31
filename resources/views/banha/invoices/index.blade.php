<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة طلب رقم {{$order->code}}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            background: #fff;
            padding: 10px;
            color: #000;
            font-weight: 800; /* زيادة وضوح الخطوط */
            line-height: 1.5; /* تحسين قابلية القراءة */
        }

        .invoice-container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        /* Header */
        .invoice-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .invoice-header .logo-box {
            width: 120px;
            height: 120px;
            margin: 0 auto 5px;
        }

        .invoice-header h1 {
            font-size: 24px; /* أكبر وأكثر وضوحًا */
            font-weight: 600;
            margin-bottom: 3px;
        }

        .invoice-number {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 0;
        }

        /* Info Section */
        .info-section {
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .info-section div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px; /* زيادة المسافة بين السطور */
        }

        /* Products Table */
        .products-table {
            width: 100%;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .products-table tr {
            border-bottom: 1px dashed #000;
        }

        .products-table tr:last-child {
            border-bottom: none;
        }

        .products-table td {
            padding: 6px 4px;
            vertical-align: middle;
            font-size: 13px;
            font-weight: 500;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-left: 5px;
        }

        .icon-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-line span {
            margin-left: 5px;
            font-size: 13px;
        }

        /* Totals Section */
        .totals-section {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .totals-section div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .final-total {
            font-weight: 600;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
            font-size: 15px;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 11px;
            font-weight: 500;
            margin-top: 10px;
            line-height: 1.4;
        }

        /* App Info Section */
        .app-info {
            text-align: center;
            font-size: 11px;
            font-weight: 500;
            margin-top: 5px;
            line-height: 1.4;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                width: 100%;
            }

            @page {
                margin: 0.5cm;
            }
        }
        .products-table th,
        .products-table td {
            text-align: center;      /* لمحاذاة أفقي وسط */
            vertical-align: middle;  /* لمحاذاة عمودي وسط */
            padding: 6px 4px;
            font-size: 13px;
            font-weight: 500;
        }
    </style>

</head>
<body>
<div class="invoice-container">
    <!-- Header -->
    <!-- Header -->
    <!-- Header -->
    <div class="invoice-header" style="text-align: center; margin-bottom: 10px;">
        <!-- Logo -->
        <div class="logo-box" style="width: 120px; height: 120px; margin: 0 auto 5px;">
            @if(isset($app_settings))
                <img src="{{ show_file($app_settings->logo)}}" alt="Logo"
                     style="width: 100%; height: 100%; object-fit: contain;">
            @else
                <img src="{{ asset('') }}default_logo.png" alt="Logo"
                     style="width: 100%; height: 100%; object-fit: contain;">
            @endif
        </div>
        <!-- Title and Order Info -->
        <h1 style="margin:0 0 3px 0; font-size:22px; font-weight:600;">فاتورة طلب</h1>
        <div class="invoice-number" style="margin-bottom:0;">رقم الطلب: {{$order->code}}</div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div><span>اسم العميل:</span> <span>{{$order->user->first_name . ' ' . $order->user->last_name  ?? '-'}}</span></div>
        <div><span>تاريخ الطلب:</span> <span>{{$order->created_at->format('Y-m-d H:i')}}</span></div>
        <div><span>رقم الطلب:</span> <span>{{$order->code}}</span></div>
        <div><span>عنوان التوصيل:</span> <span>{{$order->user->address->address ?? '-'}}</span></div>
        <div><span>هاتف العميل:</span> <span>{{$order->user->phone ?? '-'}}</span></div>
        <div><span>إجمالي الفاتورة:</span> <span>{{number_format($order->final_price,2)}} ج</span></div>
    </div>

    <!-- Products Table -->
    <table class="products-table">
        <thead>
        <tr>
            <th style="width:40px;">#</th>
            <th style="width:60px;">الصورة</th>
            <th> المنتج</th>
            <th>السعر</th>
            <th>الكمية</th>
            <th>الاجمالي</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->details as $key=> $item)
            <tr>
                <td>{{++$key}}</td>
                <td>
                    <div class="icon-box">
                        <img src="{{image_path($item->product->image ?? '')}}" alt="{{$item->product->title ?? 'منتج'}}">
                    </div>
                </td>
                <td>{{$item->product->title ?? '-'}}</td>
                <td>{{number_format($item->price,2)}} ج</td>
                <td>{{$item->quantity}}</td>
                <td>{{number_format($item->price * $item->quantity,2)}} ج</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <!-- Totals -->
    <div class="totals-section">
        <div><span>المجموع الفرعي:</span> <span>{{number_format($order->details->sum(fn($i)=>$i->price*$i->quantity),2)}} ج</span>
        </div>
        <div><span> التوصيل:</span> <span>+ {{number_format($order->shipping_price,2)}} ج</span></div>
        <div><span>الخصم:</span> <span>- {{number_format($order->coupon_discount,2)}} ج</span></div>
    </div>
    <div class="final-total">
        <span>الإجمالي </span>
        <span>
        {{ number_format($order->final_price, 2) }} ج
    </span>
    </div>


    <!-- Footer -->
    <div class="footer">
        <p>تم إنشاء هذه الفاتورة تلقائياً بواسطة النظام</p>
        <p>شكراً لتسوقكم معنا</p>
    </div>

    <!-- App Info Section -->
    <div class="app-info" style="text-align: center; font-size: 10px; margin-top: 10px;">
        @if(isset($app_settings))
            <p> {{ $app_settings->app_name ?? '-' }}</p>
            <p>رقم التواصل: {{ $app_settings->phone ?? '-' }}</p>
            <p>البريد الإلكتروني: {{ $app_settings->email ?? '-' }}</p>
        @else
            <p>رقم التواصل: 0123456789</p>
            <p>البريد الإلكتروني: info@example.com</p>
        @endif
    </div>
</div>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>
