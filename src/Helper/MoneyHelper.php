<?php

declare(strict_types=1);

namespace App\Helper;

use Symfony\Component\HttpFoundation\RequestStack;

final class MoneyHelper
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public static function formatPriceToHuman(int $amount, array $language, float $currencyRate = 1): string
    {
        $formattedPrice = new \NumberFormatter($language['code'], \NumberFormatter::CURRENCY);

        if (1 < $currencyRate) {
            $amount = ($amount / $currencyRate) * 100;
        }

        return $formattedPrice->formatCurrency(abs($amount / 100), $language['currencyCode']);
    }

    public static function formatPriceToHumanWithoutCurrency(int $amount): string
    {
        return number_format(abs($amount / 100), 2);
    }

    public static function getPercentageBetweenNumbers(int $firstNumber, int $secondNumber): float
    {
        return round(abs((100 - ($secondNumber/$firstNumber) * 100)));
    }

    public function convertPrice(int $price, int $currencyRate = null): int
    {
        if (null === $currencyRate) {
            $currencyRate = $this->requestStack->getCurrentRequest()->attributes->getInt('currency_value');
        }

        if (1 < $currencyRate) {
            return (int) abs(($price / $currencyRate) * 100);
        }

        return $price;
    }
}
