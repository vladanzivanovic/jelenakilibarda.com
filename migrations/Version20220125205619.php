<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125205619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE catalogue_has_images');
        $this->addSql('ALTER TABLE catalogue ADD image_id INT NOT NULL, DROP status');
        $this->addSql('ALTER TABLE catalogue ADD CONSTRAINT FK_59A699F53DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_59A699F53DA5256D ON catalogue (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalogue_has_images (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, entity_id INT NOT NULL, UNIQUE INDEX UNIQ_B78B220F3DA5256D (image_id), INDEX IDX_B78B220F81257D5D (entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F81257D5D FOREIGN KEY (entity_id) REFERENCES catalogue (id)');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE catalogue DROP FOREIGN KEY FK_59A699F53DA5256D');
        $this->addSql('DROP INDEX UNIQ_59A699F53DA5256D ON catalogue');
        $this->addSql('ALTER TABLE catalogue ADD status SMALLINT NOT NULL, DROP image_id');
    }
}
