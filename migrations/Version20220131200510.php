<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220131200510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Glavna email adresa', '', 'MAIN_EMAIL')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Broj mobilnog telefona', '', 'MOBILE_PHONE')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Ulica i broj', '', 'STREET')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Mesto', '', 'CITY')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Poštanski broj', '', 'ZIP_CODE')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Naziv sajta', '', 'SITE_NAME')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
