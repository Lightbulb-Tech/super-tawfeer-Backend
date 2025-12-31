<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superAdministrator' => [
            'admins' => 'c,r,u,d',
            'profile' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'app-settings' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            //////////////////////
            'countries' => 'c,r,u,d',
            'governorates' => 'c,r,u,d',
            'areas' => 'c,r,u,d',
            'stores' => 'c,r,u,d',
            'main-categories' => 'c,r,u,d',
            'sub-categories' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'product-attribute' => 'c,r,u,d',
            'import-products' => 'c',
            'main-categories-active' => 'u',
            'product-active' => 'u',
            'faqs' => 'c,r,u,d',
            'sliders' => 'c,r,u,d',
            'drivers' => 'c,r,u,d',
            'reason-cancellation' => 'c,r,u,d',
            'coupons' => 'c,r,u,d',
            'coupon-active' => 'u',
            'users' => 'r,d',
            'users-address' => 'r,d',
            'points-transfer-requests' => 'r,u,d',
            'subCategories-for-mainCategory' => 'r',
            'new-orders' => 'r',
            'current-orders' => 'r',
            'complete-orders' => 'r',
            'canceled-orders' => 'r',
            'update-order-status' => 'u',
            'points-histories' => 'r,d',
            'wallet-histories' => 'r,d',
            'general-notifications' => 'r,c',
            'get-available-drivers' => 'r',
            'choose-driver-to-order' => 'c',
            'most-products-sold' => 'r',
            'most-products-ordered' => 'r',
            'most-drivers-deliveries' => 'r',
            'products-with-zero-quantity' => 'c,r,u,d',
            'invoices' => 'c,r',
            'area-active' => 'u',
            'vehicle-active' => 'u',
            'vehicles' => 'c,r,u,d',
            'order-category-active' => 'u',
            'order-categories' => 'c,r,u,d',
            'new-reservations' => 'r',
            'current-reservations' => 'r',
            'complete-reservations' => 'r',
            'cancel-reservations' => 'r',
            'update-reservation-status' => 'u',
            'new-external-orders' => 'r',
            'current-external-orders' => 'r',
            'complete-external-orders' => 'r',
            'cancel-external-orders' => 'r',
            'update-external-order-status' => 'u',
            'get-drivers-for-external-orders' => 'r',
            'choose-driver-to-external-order' => 'c',
            'register-final-to-external-order' => 'c,r',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
