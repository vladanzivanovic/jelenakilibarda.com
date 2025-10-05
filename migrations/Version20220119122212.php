<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220119122212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC87D44F05E5');
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC8762283C10');
        $this->addSql('DROP INDEX UNIQ_7D9DBC87D44F05E5 ON biography_has_images');
        $this->addSql('DROP INDEX IDX_7D9DBC8762283C10 ON biography_has_images');
        $this->addSql('ALTER TABLE biography_has_images ADD entity_id INT NOT NULL, ADD image_id INT NOT NULL, DROP biography_id, DROP images_id');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC8781257D5D FOREIGN KEY (entity_id) REFERENCES biography (id)');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC873DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_7D9DBC8781257D5D ON biography_has_images (entity_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D9DBC873DA5256D ON biography_has_images (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC8781257D5D');
        $this->addSql('ALTER TABLE biography_has_images DROP FOREIGN KEY FK_7D9DBC873DA5256D');
        $this->addSql('DROP INDEX IDX_7D9DBC8781257D5D ON biography_has_images');
        $this->addSql('DROP INDEX UNIQ_7D9DBC873DA5256D ON biography_has_images');
        $this->addSql('ALTER TABLE biography_has_images ADD biography_id INT NOT NULL, ADD images_id INT NOT NULL, DROP entity_id, DROP image_id');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC87D44F05E5 FOREIGN KEY (images_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE biography_has_images ADD CONSTRAINT FK_7D9DBC8762283C10 FOREIGN KEY (biography_id) REFERENCES biography (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D9DBC87D44F05E5 ON biography_has_images (images_id)');
        $this->addSql('CREATE INDEX IDX_7D9DBC8762283C10 ON biography_has_images (biography_id)');
    }
}
