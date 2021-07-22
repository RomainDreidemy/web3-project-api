<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721161856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spec ADD family_id INT NOT NULL, ADD sensor_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173EC35E566A FOREIGN KEY (family_id) REFERENCES familly (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173ED8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES sensor_type (id)');
        $this->addSql('CREATE INDEX IDX_C00E173EC35E566A ON spec (family_id)');
        $this->addSql('CREATE INDEX IDX_C00E173ED8550BD9 ON spec (sensor_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173EC35E566A');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173ED8550BD9');
        $this->addSql('DROP INDEX IDX_C00E173EC35E566A ON spec');
        $this->addSql('DROP INDEX IDX_C00E173ED8550BD9 ON spec');
        $this->addSql('ALTER TABLE spec DROP family_id, DROP sensor_type_id');
    }
}
