<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        \common\pricing\PricingManager::className()
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'pricingManager' => [
            'class' => \common\pricing\PricingManager::className(),
            'strategies' => [
                \common\pricing\strategies\FixedPriceForQty::class
            ]
        ]
    ],
];
