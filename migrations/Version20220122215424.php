<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122215424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider_translation DROP FOREIGN KEY FK_CDA703942CCC9638');
        $this->addSql('DROP INDEX IDX_CDA703942CCC9638 ON slider_translation');
        $this->addSql('ALTER TABLE slider_translation CHANGE slider_id entity_id INT NOT NULL');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA7039481257D5D FOREIGN KEY (entity_id) REFERENCES slider (id)');
        $this->addSql('CREATE INDEX IDX_CDA7039481257D5D ON slider_translation (entity_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slider_translation DROP FOREIGN KEY FK_CDA7039481257D5D');
        $this->addSql('DROP INDEX IDX_CDA7039481257D5D ON slider_translation');
        $this->addSql('ALTER TABLE slider_translation CHANGE entity_id slider_id INT NOT NULL');
        $this->addSql('ALTER TABLE slider_translation ADD CONSTRAINT FK_CDA703942CCC9638 FOREIGN KEY (slider_id) REFERENCES slider (id)');
        $this->addSql('CREATE INDEX IDX_CDA703942CCC9638 ON slider_translation (slider_id)');
    }
}
