<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210717143552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE familly (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3072AE5C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C242628A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, module_id INT NOT NULL, id_influx VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BC8617B0CD1A6DD6 (id_influx), INDEX IDX_BC8617B0C54C8C93 (type_id), INDEX IDX_BC8617B0AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sensor_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sheet (id INT AUTO_INCREMENT NOT NULL, familly_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_873C91E28D6893A3 (familly_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spec (id INT AUTO_INCREMENT NOT NULL, min_sheet_id INT DEFAULT NULL, max_sheet_id INT DEFAULT NULL, familly_id INT NOT NULL, sensor_type_id INT NOT NULL, min INT NOT NULL, max INT NOT NULL, UNIQUE INDEX UNIQ_C00E173E6A44609C (min_sheet_id), UNIQUE INDEX UNIQ_C00E173EFA377076 (max_sheet_id), INDEX IDX_C00E173E8D6893A3 (familly_id), INDEX IDX_C00E173ED8550BD9 (sensor_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0C54C8C93 FOREIGN KEY (type_id) REFERENCES sensor_type (id)');
        $this->addSql('ALTER TABLE sensor ADD CONSTRAINT FK_BC8617B0AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE sheet ADD CONSTRAINT FK_873C91E28D6893A3 FOREIGN KEY (familly_id) REFERENCES familly (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173E6A44609C FOREIGN KEY (min_sheet_id) REFERENCES sheet (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173EFA377076 FOREIGN KEY (max_sheet_id) REFERENCES sheet (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173E8D6893A3 FOREIGN KEY (familly_id) REFERENCES familly (id)');
        $this->addSql('ALTER TABLE spec ADD CONSTRAINT FK_C00E173ED8550BD9 FOREIGN KEY (sensor_type_id) REFERENCES sensor_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sheet DROP FOREIGN KEY FK_873C91E28D6893A3');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173E8D6893A3');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0AFC2B591');
        $this->addSql('ALTER TABLE sensor DROP FOREIGN KEY FK_BC8617B0C54C8C93');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173ED8550BD9');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173E6A44609C');
        $this->addSql('ALTER TABLE spec DROP FOREIGN KEY FK_C00E173EFA377076');
        $this->addSql('DROP TABLE familly');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE sensor');
        $this->addSql('DROP TABLE sensor_type');
        $this->addSql('DROP TABLE sheet');
        $this->addSql('DROP TABLE spec');
    }
}
