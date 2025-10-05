<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117214132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_translation DROP FOREIGN KEY FK_DBE317362283C10');
        $this->addSql('DROP INDEX IDX_DBE317362283C10 ON biography_translation');
        $this->addSql('ALTER TABLE biography_translation CHANGE biography_id entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE biography_translation ADD CONSTRAINT FK_DBE317381257D5D FOREIGN KEY (entity_id) REFERENCES biography (id)');
        $this->addSql('CREATE INDEX IDX_DBE317381257D5D ON biography_translation (entity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_translation DROP FOREIGN KEY FK_DBE317381257D5D');
        $this->addSql('DROP INDEX IDX_DBE317381257D5D ON biography_translation');
        $this->addSql('ALTER TABLE biography_translation CHANGE entity_id biography_id INT NOT NULL');
        $this->addSql('ALTER TABLE biography_translation ADD CONSTRAINT FK_DBE317362283C10 FOREIGN KEY (biography_id) REFERENCES biography (id)');
        $this->addSql('CREATE INDEX IDX_DBE317362283C10 ON biography_translation (biography_id)');
    }
}
