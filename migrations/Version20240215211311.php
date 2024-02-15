<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215211311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place ADD boat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDA1E84A29 FOREIGN KEY (boat_id) REFERENCES boat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CDA1E84A29 ON place (boat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDA1E84A29');
        $this->addSql('DROP INDEX UNIQ_741D53CDA1E84A29 ON place');
        $this->addSql('ALTER TABLE place DROP boat_id');
    }
}
