<?php

namespace App\Enums;

enum NotificationTypesEnum: string
{
    case General = 'general';
    case OrderConfirmed = 'order_confirmed';
    case OrderPrepared = 'order_prepared';
    case OrderDeliveredToDriver = 'order_delivered_to_driver';
    case OrderDeliveredToClient = 'order_delivered_to_client';
    case OrderCancelled = 'order_cancelled';
    case OrderCompleted = 'order_completed';
    case ApprovePointTransfer = 'approve_point_transfer';
    case RefusePointTransfer = 'refuse_point_transfer';
    case PointTransferRequest = 'point_transfer_request';
    case PayOrderFromWallet = 'pay_order_from_wallet';

    case ReservationConfirmed = 'reservation_confirmed';
    case ReservationCompleted = 'reservation_completed';
    case ReservationLoading = 'reservation_loading';
    case ReservationCancelled = 'reservation_cancelled';


    public function action()
    {
        return match ($this) {
            self::General => "general",
            self::OrderConfirmed => "order_confirmed",
            self::OrderPrepared => "order_prepared",
            self::OrderDeliveredToDriver => "order_delivered_to_driver",
            self::OrderDeliveredToClient => "order_delivered_to_client",
            self::OrderCancelled => "order_cancelled",
            self::OrderCompleted => "order_completed",
            self::ApprovePointTransfer => "approve_point_transfer",
            self::RefusePointTransfer => "refuse_point_transfer",
            self::PointTransferRequest => "point_transfer_request",
            self::PayOrderFromWallet => "pay_order_from_wallet",
            self::ReservationConfirmed => "reservation_confirmed",
            self::ReservationCompleted => "reservation_completed",
            self::ReservationLoading => "reservation_loading",
            self::ReservationCancelled => "reservation_cancelled",
        };
    }
}
