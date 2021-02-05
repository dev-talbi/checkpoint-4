<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210204111729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE injustice_theme (injustice_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_6F5B899CEE1415BC (injustice_id), INDEX IDX_6F5B899C59027487 (theme_id), PRIMARY KEY(injustice_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, subject VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE injustice_theme ADD CONSTRAINT FK_6F5B899CEE1415BC FOREIGN KEY (injustice_id) REFERENCES injustice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE injustice_theme ADD CONSTRAINT FK_6F5B899C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE injustice_theme DROP FOREIGN KEY FK_6F5B899C59027487');
        $this->addSql('DROP TABLE injustice_theme');
        $this->addSql('DROP TABLE theme');
    }
}
