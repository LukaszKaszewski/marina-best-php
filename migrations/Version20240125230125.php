<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240125230125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boats ADD user_id INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD mmsi VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE boats ADD CONSTRAINT FK_8DDF0906A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8DDF0906A76ED395 ON boats (user_id)');
        $this->addSql('ALTER TABLE place ADD boat_id INT NOT NULL');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CDA1E84A29 FOREIGN KEY (boat_id) REFERENCES boats (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CDA1E84A29 ON place (boat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boats DROP FOREIGN KEY FK_8DDF0906A76ED395');
        $this->addSql('DROP INDEX IDX_8DDF0906A76ED395 ON boats');
        $this->addSql('ALTER TABLE boats DROP user_id, DROP name, DROP mmsi');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CDA1E84A29');
        $this->addSql('DROP INDEX UNIQ_741D53CDA1E84A29 ON place');
        $this->addSql('ALTER TABLE place DROP boat_id');
    }
}
