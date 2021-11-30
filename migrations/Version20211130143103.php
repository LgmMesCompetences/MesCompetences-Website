<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211130143103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, main_comp_id INT DEFAULT NULL, libelle VARCHAR(30) NOT NULL, level INT NOT NULL, INDEX IDX_94D4687F727ACA70 (parent_id), INDEX IDX_94D4687FB9469222 (main_comp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posseder (id INT AUTO_INCREMENT NOT NULL, competence_id INT NOT NULL, user_id INT NOT NULL, nbr_recommander INT NOT NULL, INDEX IDX_62EF7CBA15761DAB (competence_id), INDEX IDX_62EF7CBAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F727ACA70 FOREIGN KEY (parent_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FB9469222 FOREIGN KEY (main_comp_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE posseder ADD CONSTRAINT FK_62EF7CBA15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE posseder ADD CONSTRAINT FK_62EF7CBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F727ACA70');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687FB9469222');
        $this->addSql('ALTER TABLE posseder DROP FOREIGN KEY FK_62EF7CBA15761DAB');
        $this->addSql('ALTER TABLE posseder DROP FOREIGN KEY FK_62EF7CBAA76ED395');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE posseder');
        $this->addSql('DROP TABLE user');
    }
}
