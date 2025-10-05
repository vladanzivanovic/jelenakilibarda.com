<?php

declare(strict_types=1);

namespace App\Helper;

use App\Repository\CurrencyRepository;
use App\Repository\SettingsRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final class CardPaymentHelper
{
    private RouterInterface $router;

    private CurrencyRepository $currencyRepository;

    private SettingsRepository $settingsRepository;

    private array $paypalSettings;

    public function __construct(
        RouterInterface $router,
        CurrencyRepository $currencyRepository,
        SettingsRepository $settingsRepository,
        array $paypalSettings
    ) {
        $this->router = $router;
        $this->paypalSettings = $paypalSettings;
        $this->currencyRepository = $currencyRepository;
        $this->settingsRepository = $settingsRepository;
    }

    public function getBasicData(string $locale): array
    {
        $rate = 1;

        $freeShippingPrice = $this->settingsRepository->getFreeShipping();
        $currency = $this->currencyRepository->findOneBy(['code' => $this->paypalSettings['currency']]);

        if (null !== $currency) {
            $rate = $currency->getRate();
        }

        $data = [
            'successUrl' => $this->generateRoute('site.checkout_completed_successful', $locale),
            'failedUrl' => $this->generateRoute('site.checkout_failed', $locale),
            'cancelUrl' => $this->generateRoute('site.checkout_page', $locale),
            'notifyUrl' => $this->generateRoute('site_api.card_notify_url'),
            'currencyRate' => $rate,
            'freeShippingPrice' => $freeShippingPrice,
        ];

        return $data;
    }

    private function generateRoute(string $path, string $locale = null): string
    {
        $params = [];

        if (null !== $locale) {
            $params = ['_locale' => $locale];
        }
        return $this->router->generate($path, $params, UrlGeneratorInterface::ABSOLUTE_URL);
    }
}