<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\ShopOrder;
use App\Helper\MoneyHelper;
use App\Repository\SettingsRepository;

final class CartProductFormatter
{
    private SettingsRepository $settingsRepository;

    private MoneyHelper $moneyHelper;

    public function __construct(
        SettingsRepository $settingsRepository,
        MoneyHelper $moneyHelper
    ) {

        $this->settingsRepository = $settingsRepository;
        $this->moneyHelper = $moneyHelper;
    }

    public function format(ShopOrder $order, array $data): array
    {
        $freeShippingPrice = $this->settingsRepository->getFreeShipping();
        $promoCode = $order->getCoupon();

        foreach ($data['products'] as &$orderProduct) {
            $orderProduct['current_price'] = $orderProduct['discount'] > 0 ? $orderProduct['discount'] : $orderProduct['price'];
            $orderProduct['total'] = $orderProduct['current_price'] * $orderProduct['quantity'];
        }

        return [
            'products' => $data['products'],
            'total' => $order->getTotal($freeShippingPrice),
            'items_total' => $order->getItemsTotal(),
            'free_shipping_price' => $freeShippingPrice,
            'promo_price' => null !== $promoCode ? $promoCode->getDiscount() : null,
            'shipping_price' => $order->getShippingPrice($freeShippingPrice),
        ];
    }
}