<?php

namespace App\Entity;

interface TranslationInterface
{
    public function getTranslationByLocale(string $locale): ?TranslatableInterface;

    public function createTranslation(): TranslatableInterface;
}
