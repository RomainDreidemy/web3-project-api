<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210717160153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module ADD familly_id INT NOT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426288D6893A3 FOREIGN KEY (familly_id) REFERENCES familly (id)');
        $this->addSql('CREATE INDEX IDX_C2426288D6893A3 ON module (familly_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426288D6893A3');
        $this->addSql('DROP INDEX IDX_C2426288D6893A3 ON module');
        $this->addSql('ALTER TABLE module DROP familly_id');
    }
}
