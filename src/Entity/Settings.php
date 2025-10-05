<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingsRepository")
 */
class Settings
{
    const FIELD_FREE_SHIPPING = 'FREE_SHIPPING';

    const FIELD_MAIN_EMAIL = 'MAIN_EMAIL';

    const FIELD_TELEPHONE = 'TELEPHONE';

    const FIELD_MOBILE_PHONE = 'MOBILE_PHONE';

    const FIELD_STREET = 'STREET';

    const FIELD_CITY = 'CITY';

    const FIELD_ZIP_CODE = 'ZIP_CODE';

    const FIELD_ACCOUNT_NUMBER = 'ACCOUNT_NUMBER';

    const FIELD_PIB = 'OIB';

    const FIELD_SITE_NAME = 'SITE_NAME';

    const FIELD_FULL_COMPANY_NAME = 'FULL_COMPANY_NAME';

    const FIELD_COMPANY_ACTIVITY = 'COMPANY_ACTIVITY';

    const FIELD_COMPANY_CODE = 'COMPANY_CODE';

    const FIELD_COMPANY_ID = 'COMPANY_ID';

    const FIELD_PDV_ID = 'PDV_ID';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $locale;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
