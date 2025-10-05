<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114114927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ask_us (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, subject VARCHAR(255) NOT NULL, note LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, position INT NOT NULL, type SMALLINT NOT NULL, status SMALLINT NOT NULL, UNIQUE INDEX UNIQ_6F9DB8E73DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banner_translation (id INT AUTO_INCREMENT NOT NULL, banner_id INT NOT NULL, description LONGTEXT NOT NULL, button_text VARCHAR(50) NOT NULL, button_link VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_841ECF1C684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, status SMALLINT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C01551433DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_translation (id INT AUTO_INCREMENT NOT NULL, blog_id INT NOT NULL, title VARCHAR(255) NOT NULL, alias VARCHAR(255) NOT NULL, short_description LONGTEXT NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_6D59D991DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue_has_images (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, catalogue_id INT NOT NULL, UNIQUE INDEX UNIQ_B78B220F3DA5256D (image_id), INDEX IDX_B78B220F4A7843DC (catalogue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue_translation (id INT AUTO_INCREMENT NOT NULL, catalogue_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_EE172CFF4A7843DC (catalogue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, from_email VARCHAR(255) NOT NULL, to_email VARCHAR(255) NOT NULL, raw_data LONGTEXT DEFAULT NULL, error_message TEXT DEFAULT NULL, status VARCHAR(150) NOT NULL, script VARCHAR(200) NOT NULL, code VARCHAR(5) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, related_to_type SMALLINT NOT NULL, is_main TINYINT(1) NOT NULL, device SMALLINT NOT NULL, parent_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, value LONGTEXT NOT NULL, slug VARCHAR(100) NOT NULL, locale VARCHAR(2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, text_position SMALLINT NOT NULL, position INT NOT NULL, status SMALLINT NOT NULL, UNIQUE INDEX UNIQ_CFC710073DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_text (id INT AUTO_INCREMENT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_text_translation (id INT AUTO_INCREMENT NOT NULL, slider_text_id INT NOT NULL, description LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_4078DA64177610E4 (slider_text_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_translation (id INT AUTO_INCREMENT NOT NULL, slider_id INT NOT NULL, description LONGTEXT NOT NULL, button_text VARCHAR(100) NOT NULL, button_link VARCHAR(255) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_CDA703942CCC9638 (slider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, reset_request_at DATETIME DEFAULT NULL, note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status SMALLINT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE banner ADD CONSTRAINT FK_6F9DB8E73DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE banner_translation ADD CONSTRAINT FK_841ECF1C684EC833 FOREIGN KEY (banner_id) REFERENCES banner (id)');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C01551433DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE blog_translation ADD CONSTRAINT FK_6D59D991DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE catalogue_translation ADD CONSTRAINT FK_EE172CFF4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE slider ADD CONSTRAINT FK_CFC710073DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE slider_text_translation ADD CONSTRAINT FK_4078DA64177610E4 FOREIGN KEY (slider_text_id) REFERENCES slider_text (id)');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA703942CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE banner_translation DROP FOREIGN KEY FK_841ECF1C684EC833');
        $this->addSql('ALTER TABLE blog_translation DROP FOREIGN KEY FK_6D59D991DAE07E97');
        $this->addSql('ALTER TABLE catalogue_has_images DROP FOREIGN KEY FK_B78B220F4A7843DC');
        $this->addSql('ALTER TABLE catalogue_translation DROP FOREIGN KEY FK_EE172CFF4A7843DC');
        $this->addSql('ALTER TABLE banner DROP FOREIGN KEY FK_6F9DB8E73DA5256D');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C01551433DA5256D');
        $this->addSql('ALTER TABLE catalogue_has_images DROP FOREIGN KEY FK_B78B220F3DA5256D');
        $this->addSql('ALTER TABLE slider DROP FOREIGN KEY FK_CFC710073DA5256D');
        $this->addSql('ALTER TABLE slider_translation DROP FOREIGN KEY FK_CDA703942CCC9638');
        $this->addSql('ALTER TABLE slider_text_translation DROP FOREIGN KEY FK_4078DA64177610E4');
        $this->addSql('DROP TABLE ask_us');
        $this->addSql('DROP TABLE banner');
        $this->addSql('DROP TABLE banner_translation');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_translation');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE catalogue_has_images');
        $this->addSql('DROP TABLE catalogue_translation');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE slider_text');
        $this->addSql('DROP TABLE slider_text_translation');
        $this->addSql('DROP TABLE slider_translation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
