<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225203725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rfid (id INT AUTO_INCREMENT NOT NULL, number INT NOT NULL, key_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE place ADD key_number_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4D67436A FOREIGN KEY (key_number_id) REFERENCES rfid (id)');
        $this->addSql('CREATE INDEX IDX_741D53CD4D67436A ON place (key_number_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD4D67436A');
        $this->addSql('DROP TABLE rfid');
        $this->addSql('DROP INDEX IDX_741D53CD4D67436A ON place');
        $this->addSql('ALTER TABLE place DROP key_number_id');
    }
}
