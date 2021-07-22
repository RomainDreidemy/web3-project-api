<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722090248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vegetable (id INT AUTO_INCREMENT NOT NULL, family_id INT NOT NULL, name VARCHAR(255) NOT NULL, water INT NOT NULL, fiber INT NOT NULL, glucose INT NOT NULL, protein INT NOT NULL, lipid INT NOT NULL, intro_text LONGTEXT DEFAULT NULL, culture_text LONGTEXT DEFAULT NULL, entretien_text LONGTEXT DEFAULT NULL, recolte_text LONGTEXT DEFAULT NULL, culture_start VARCHAR(255) DEFAULT NULL, culture_end VARCHAR(255) DEFAULT NULL, recolte_start VARCHAR(255) DEFAULT NULL, recolte_end VARCHAR(255) DEFAULT NULL, INDEX IDX_DB9894F7C35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vegetable ADD CONSTRAINT FK_DB9894F7C35E566A FOREIGN KEY (family_id) REFERENCES familly (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vegetable');
    }
}
