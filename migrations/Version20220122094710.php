<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122094710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_translation DROP FOREIGN KEY FK_6D59D991DAE07E97');
        $this->addSql('CREATE TABLE slider_has_images (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_DEC3F6F881257D5D (entity_id), UNIQUE INDEX UNIQ_DEC3F6F83DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slider_has_images ADD CONSTRAINT FK_DEC3F6F881257D5D FOREIGN KEY (entity_id) REFERENCES slider (id)');
        $this->addSql('ALTER TABLE slider_has_images ADD CONSTRAINT FK_DEC3F6F83DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_translation');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710073DA5256D');
        $this->addSql('DROP INDEX UNIQ_CFC710073DA5256D ON slider');
        $this->addSql('ALTER TABLE slider DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C01551433DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE blog_translation (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, alias VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, short_description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, locale VARCHAR(2) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6D59D991DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551433DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE blog_translation ADD CONSTRAINT FK_6D59D991DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('DROP TABLE slider_has_images');
        $this->addSql('ALTER TABLE slider ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710073DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFC710073DA5256D ON slider (image_id)');
    }
}
