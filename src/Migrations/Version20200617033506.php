<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617033506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stockings DROP FOREIGN KEY FK_FD96F0354FFA550E');
        $this->addSql('ALTER TABLE stockings DROP FOREIGN KEY FK_FD96F03564D218E');
        $this->addSql('DROP INDEX IDX_FD96F03564D218E ON stockings');
        $this->addSql('DROP INDEX IDX_FD96F0354FFA550E ON stockings');
        $this->addSql('ALTER TABLE stockings DROP location_id, DROP device_type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stockings ADD location_id INT NOT NULL, ADD device_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE stockings ADD CONSTRAINT FK_FD96F0354FFA550E FOREIGN KEY (device_type_id) REFERENCES device_types (id)');
        $this->addSql('ALTER TABLE stockings ADD CONSTRAINT FK_FD96F03564D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_FD96F03564D218E ON stockings (location_id)');
        $this->addSql('CREATE INDEX IDX_FD96F0354FFA550E ON stockings (device_type_id)');
    }
}
