<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115222409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biography_translation (id INT AUTO_INCREMENT NOT NULL, biography_id INT NOT NULL, short_description LONGTEXT NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_DBE317362283C10 (biography_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biography_translation ADD CONSTRAINT FK_DBE317362283C10 FOREIGN KEY (biography_id) REFERENCES biography (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE biography_translation');
    }
}
