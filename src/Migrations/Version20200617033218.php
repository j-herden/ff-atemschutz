<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617033218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stockings ADD position_id INT NOT NULL');
        $this->addSql('ALTER TABLE stockings ADD CONSTRAINT FK_FD96F035DD842E46 FOREIGN KEY (position_id) REFERENCES positions (id)');
        $this->addSql('CREATE INDEX IDX_FD96F035DD842E46 ON stockings (position_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stockings DROP FOREIGN KEY FK_FD96F035DD842E46');
        $this->addSql('DROP INDEX IDX_FD96F035DD842E46 ON stockings');
        $this->addSql('ALTER TABLE stockings DROP position_id');
    }
}
