<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123161856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE posseder_competences');
        $this->addSql('DROP TABLE posseder_user');
        $this->addSql('ALTER TABLE posseder ADD user_id INT DEFAULT NULL, ADD competence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE posseder ADD CONSTRAINT FK_62EF7CBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posseder ADD CONSTRAINT FK_62EF7CBA15761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('CREATE INDEX IDX_62EF7CBAA76ED395 ON posseder (user_id)');
        $this->addSql('CREATE INDEX IDX_62EF7CBA15761DAB ON posseder (competence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posseder_competences (posseder_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_5B004B5F1DB77787 (posseder_id), INDEX IDX_5B004B5FA660B158 (competences_id), PRIMARY KEY(posseder_id, competences_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE posseder_user (posseder_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5E5D377B1DB77787 (posseder_id), INDEX IDX_5E5D377BA76ED395 (user_id), PRIMARY KEY(posseder_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE posseder_competences ADD CONSTRAINT FK_5B004B5FA660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_competences ADD CONSTRAINT FK_5B004B5F1DB77787 FOREIGN KEY (posseder_id) REFERENCES posseder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_user ADD CONSTRAINT FK_5E5D377BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_user ADD CONSTRAINT FK_5E5D377B1DB77787 FOREIGN KEY (posseder_id) REFERENCES posseder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder DROP FOREIGN KEY FK_62EF7CBAA76ED395');
        $this->addSql('ALTER TABLE posseder DROP FOREIGN KEY FK_62EF7CBA15761DAB');
        $this->addSql('DROP INDEX IDX_62EF7CBAA76ED395 ON posseder');
        $this->addSql('DROP INDEX IDX_62EF7CBA15761DAB ON posseder');
        $this->addSql('ALTER TABLE posseder DROP user_id, DROP competence_id');
    }
}
