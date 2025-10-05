<?php

declare(strict_types=1);

namespace App\Helper;

use App\Repository\SettingsRepository;

final class SettingsHelper
{
    private SettingsRepository $settingsRepository;

    public function __construct(
        SettingsRepository $settingsRepository
    ) {

        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @return array<string, int|string>
     */
    public function getSettings(): array
    {
        $settings = $this->settingsRepository->getSettingsForUserRegistrationEmail();
        $formatted = [];

        foreach ($settings as $setting) {
            $formatted[$setting['slug']] = $setting['value'];
        }

        return $formatted;
    }
}