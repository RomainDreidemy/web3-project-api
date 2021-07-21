<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210720120520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAFC2B591');
        $this->addSql('DROP INDEX IDX_C53D045FAFC2B591 ON image');
        $this->addSql('ALTER TABLE image ADD comment_id INT DEFAULT NULL, DROP module_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FF8697D13 ON image (comment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FF8697D13');
        $this->addSql('DROP INDEX IDX_C53D045FF8697D13 ON image');
        $this->addSql('ALTER TABLE image ADD module_id INT NOT NULL, DROP comment_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FAFC2B591 ON image (module_id)');
    }
}
