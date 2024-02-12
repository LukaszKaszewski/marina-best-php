<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212205019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD9D86650F');
        $this->addSql('DROP INDEX IDX_741D53CD9D86650F ON place');
        $this->addSql('ALTER TABLE user DROP card_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE INDEX IDX_741D53CD9D86650F ON place (user_id)');
        $this->addSql('ALTER TABLE user ADD card_id VARCHAR(255) NOT NULL');
    }
}
