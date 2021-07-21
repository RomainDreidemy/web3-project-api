<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720132300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173E6A44609C');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173EFA377076');
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_action_condition (action_id INT NOT NULL, action_condition_id INT NOT NULL, INDEX IDX_D7D26D979D32F035 (action_id), INDEX IDX_D7D26D9714054796 (action_condition_id), PRIMARY KEY(action_id, action_condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE action_condition (id INT AUTO_INCREMENT NOT NULL, sensor_type_id INT NOT NULL, family_id INT NOT NULL, operator VARCHAR(2) NOT NULL, value INT NOT NULL, INDEX IDX_19D09B5ED8550BD9 (sensor_type_id), INDEX IDX_19D09B5EC35E566A (family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action_action_condition ADD CONSTRAINT FK_D7D26D979D32F035 FOREIGN KEY (action_id) REFERENCES action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_action_condition ADD CONSTRAINT FK_D7D26D9714054796 FOREIGN KEY (action_condition_id) REFERENCES action_condition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE action_condition ADD CONSTRAINT FK_19D09B5ED8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES sensor_type (id)');
        $this->addSql('ALTER TABLE action_condition ADD CONSTRAINT FK_19D09B5EC35E566A FOREIGN KEY (family_id) REFERENCES familly (id)');
        $this->addSql('DROP TABLE sheet');
        $this->addSql('DROP TABLE spec');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action_action_condition DROP FOREIGN KEY FK_D7D26D979D32F035');
        $this->addSql('ALTER TABLE action_action_condition DROP FOREIGN KEY FK_D7D26D9714054796');
        $this->addSql('CREATE TABLE sheet (id INT AUTO_INCREMENT NOT NULL, familly_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_873C91E28D6893A3 (familly_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE spec (id INT AUTO_INCREMENT NOT NULL, min_sheet_id INT DEFAULT NULL, max_sheet_id INT DEFAULT NULL, familly_id INT NOT NULL, sensor_type_id INT NOT NULL, min INT NOT NULL, max INT NOT NULL, UNIQUE INDEX UNIQ_C00E173EFA377076 (max_sheet_id), INDEX IDX_C00E173ED8550BD9 (sensor_type_id), UNIQUE INDEX UNIQ_C00E173E6A44609C (min_sheet_id), INDEX IDX_C00E173E8D6893A3 (familly_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sheet ADD CONSTRAINT FK_873C91E28D6893A3 FOREIGN KEY (familly_id) REFERENCES familly (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173E6A44609C FOREIGN KEY (min_sheet_id) REFERENCES sheet (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173E8D6893A3 FOREIGN KEY (familly_id) REFERENCES familly (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173ED8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES sensor_type (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173EFA377076 FOREIGN KEY (max_sheet_id) REFERENCES sheet (id)');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE action_action_condition');
        $this->addSql('DROP TABLE action_condition');
    }
}
