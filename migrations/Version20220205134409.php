<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220205134409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC8781257D5D');
        $this->addSql('ALTER TABLE biography_translation DROP FOREIGN KEY FK_DBE317381257D5D');
        $this->addSql('CREATE TABLE description_has_images (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_73D17E3081257D5D (entity_id), UNIQUE INDEX UNIQ_73D17E303DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description_translation (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, short_description LONGTEXT NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_58B55B9E81257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE description_has_images ADD CONSTRAINT FK_73D17E3081257D5D FOREIGN KEY (entity_id) REFERENCES description (id)');
        $this->addSql('ALTER TABLE description_has_images ADD CONSTRAINT FK_73D17E303DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE description_translation ADD CONSTRAINT FK_58B55B9E81257D5D FOREIGN KEY (entity_id) REFERENCES description (id)');
        $this->addSql('DROP TABLE biography');
        $this->addSql('DROP TABLE biography_has_images');
        $this->addSql('DROP TABLE biography_translation');
        $this->addSql('ALTER TABLE description DROP description, DROP locale, CHANGE type type VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biography (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE biography_has_images (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_7D9DBC8781257D5D (entity_id), UNIQUE INDEX UNIQ_7D9DBC873DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE biography_translation (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, short_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, locale VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_DBE317381257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC873DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC8781257D5D FOREIGN KEY (entity_id) REFERENCES biography (id)');
        $this->addSql('ALTER TABLE biography_translation ADD CONSTRAINT FK_DBE317381257D5D FOREIGN KEY (entity_id) REFERENCES biography (id)');
        $this->addSql('DROP TABLE description_has_images');
        $this->addSql('DROP TABLE description_translation');
        $this->addSql('ALTER TABLE description ADD description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD locale VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
