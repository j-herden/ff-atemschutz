<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617030556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE positions (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, device_type_id INT DEFAULT NULL, name VARCHAR(20) NOT NULL, INDEX IDX_D69FE57C64D218E (location_id), INDEX IDX_D69FE57C4FFA550E (device_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE positions ADD CONSTRAINT FK_D69FE57C64D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE positions ADD CONSTRAINT FK_D69FE57C4FFA550E FOREIGN KEY (device_type_id) REFERENCES device_types (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE positions');
    }
}
