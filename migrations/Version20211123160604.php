<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123160604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE posseder (id INT AUTO_INCREMENT NOT NULL, nb_recommandation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posseder_user (posseder_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_5E5D377B1DB77787 (posseder_id), INDEX IDX_5E5D377BA76ED395 (user_id), PRIMARY KEY(posseder_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posseder_competences (posseder_id INT NOT NULL, competences_id INT NOT NULL, INDEX IDX_5B004B5F1DB77787 (posseder_id), INDEX IDX_5B004B5FA660B158 (competences_id), PRIMARY KEY(posseder_id, competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posseder_user ADD CONSTRAINT FK_5E5D377B1DB77787 FOREIGN KEY (posseder_id) REFERENCES posseder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_user ADD CONSTRAINT FK_5E5D377BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_competences ADD CONSTRAINT FK_5B004B5F1DB77787 FOREIGN KEY (posseder_id) REFERENCES posseder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE posseder_competences ADD CONSTRAINT FK_5B004B5FA660B158 FOREIGN KEY (competences_id) REFERENCES competences (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posseder_user DROP FOREIGN KEY FK_5E5D377B1DB77787');
        $this->addSql('ALTER TABLE posseder_competences DROP FOREIGN KEY FK_5B004B5F1DB77787');
        $this->addSql('DROP TABLE posseder');
        $this->addSql('DROP TABLE posseder_user');
        $this->addSql('DROP TABLE posseder_competences');
    }
}
