<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Settings;
use App\Helper\MoneyHelper;
use App\Repository\SettingsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SettingsExtension extends AbstractExtension
{
    private SettingsRepository $settingsRepository;

    public function __construct(
        SettingsRepository $settingsRepository
    ) {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('settings', [$this, 'getSettings']),
        ];
    }

    /**
     * @return array|null
     */
    public function getSettings(): ?array
    {
        $settings = $this->settingsRepository->getSettingsForContactPage();

        $formatted = [];

        foreach ($settings as $setting) {
            $slug = $setting['slug'];
            $value = $setting['value'];

            $formatted[$slug] = $value;
        }

        return $formatted;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'settings_extension';
    }
}
