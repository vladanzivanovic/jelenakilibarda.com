<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125203418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue_has_images DROP FOREIGN KEY FK_B78B220F4A7843DC');
        $this->addSql('DROP INDEX IDX_B78B220F4A7843DC ON catalogue_has_images');
        $this->addSql('ALTER TABLE catalogue_has_images CHANGE catalogue_id entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F81257D5D FOREIGN KEY (entity_id) REFERENCES catalogue (id)');
        $this->addSql('CREATE INDEX IDX_B78B220F81257D5D ON catalogue_has_images (entity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalogue_has_images DROP FOREIGN KEY FK_B78B220F81257D5D');
        $this->addSql('DROP INDEX IDX_B78B220F81257D5D ON catalogue_has_images');
        $this->addSql('ALTER TABLE catalogue_has_images CHANGE entity_id catalogue_id INT NOT NULL');
        $this->addSql('ALTER TABLE catalogue_has_images ADD CONSTRAINT FK_B78B220F4A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogue (id)');
        $this->addSql('CREATE INDEX IDX_B78B220F4A7843DC ON catalogue_has_images (catalogue_id)');
    }
}
