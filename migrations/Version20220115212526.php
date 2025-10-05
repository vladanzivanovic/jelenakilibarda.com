<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115212526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biography (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE biography_has_images (id INT AUTO_INCREMENT NOT NULL, biography_id INT NOT NULL, images_id INT NOT NULL, INDEX IDX_7D9DBC8762283C10 (biography_id), UNIQUE INDEX UNIQ_7D9DBC87D44F05E5 (images_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC8762283C10 FOREIGN KEY (biography_id) REFERENCES biography (id)');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC87D44F05E5 FOREIGN KEY (images_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC8762283C10');
        $this->addSql('DROP TABLE biography');
        $this->addSql('DROP TABLE biography_has_images');
    }
}
