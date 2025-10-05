<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220123205515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, youtube_id VARCHAR(100) NOT NULL, channel_id VARCHAR(250) NOT NULL, channel_title VARCHAR(250) NOT NULL, thumbnails LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_translation (id INT AUTO_INCREMENT NOT NULL, entity_id INT NOT NULL, description LONGTEXT NOT NULL, title VARCHAR(100) NOT NULL, locale VARCHAR(2) NOT NULL, INDEX IDX_96EBF4CE81257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE video_translation ADD CONSTRAINT FK_96EBF4CE81257D5D FOREIGN KEY (entity_id) REFERENCES video (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_translation DROP FOREIGN KEY FK_96EBF4CE81257D5D');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_translation');
    }
}
