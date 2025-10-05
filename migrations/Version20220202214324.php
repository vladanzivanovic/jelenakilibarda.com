<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220202214324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Facebook', '', 'FACEBOOK')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Instagram', '', 'INSTAGRAM')");
        $this->addSql("INSERT INTO settings (`name`, `value`, `slug`) VALUES ('Youtube', '', 'YOUTUBE')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
