<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240224231457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wintering (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, boat_name VARCHAR(255) NOT NULL, boat_length INT NOT NULL, boat_width INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_91FAB1A9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wintering ADD CONSTRAINT FK_91FAB1A9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wintering DROP FOREIGN KEY FK_91FAB1A9D86650F');
        $this->addSql('DROP TABLE wintering');
    }
}
