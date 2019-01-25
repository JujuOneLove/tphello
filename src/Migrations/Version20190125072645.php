<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190125072645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE weapon_user DROP FOREIGN KEY FK_358C3EB695B82273');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, flag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, team_a_id INT DEFAULT NULL, team_b_id INT DEFAULT NULL, score_team_a INT DEFAULT NULL, score_team_b INT DEFAULT NULL, date DATETIME NOT NULL, rating NUMERIC(5, 3) DEFAULT NULL, INDEX IDX_232B318CEA3FA723 (team_a_id), INDEX IDX_232B318CF88A08CD (team_b_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, game_id INT DEFAULT NULL, score_team_a INT NOT NULL, score_team_b INT NOT NULL, date DATETIME NOT NULL, amout INT NOT NULL, INDEX IDX_FBF0EC9BA76ED395 (user_id), INDEX IDX_FBF0EC9BE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CEA3FA723 FOREIGN KEY (team_a_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF88A08CD FOREIGN KEY (team_b_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('DROP TABLE weapon');
        $this->addSql('DROP TABLE weapon_user');
        $this->addSql('ALTER TABLE app_user DROP health');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CEA3FA723');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF88A08CD');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BE48FD905');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, damage NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE weapon_user (id INT AUTO_INCREMENT NOT NULL, weapon_id INT DEFAULT NULL, user_id INT DEFAULT NULL, quality INT NOT NULL, ammunition INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_358C3EB6A76ED395 (user_id), INDEX IDX_358C3EB695B82273 (weapon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE weapon_user ADD CONSTRAINT FK_358C3EB695B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('ALTER TABLE weapon_user ADD CONSTRAINT FK_358C3EB6A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id)');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE bet');
        $this->addSql('ALTER TABLE app_user ADD health INT DEFAULT NULL');
    }
}
