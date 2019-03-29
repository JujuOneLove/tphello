<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329092622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_product DROP FOREIGN KEY FK_8B471AA76D128938');
        $this->addSql('DROP TABLE user_order');
        $this->addSql('ALTER TABLE product DROP quantity, DROP picture');
        $this->addSql('ALTER TABLE app_user ADD api_token VARCHAR(180) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E97BA2F5EB ON app_user (api_token)');
        $this->addSql('DROP INDEX IDX_8B471AA76D128938 ON user_product');
        $this->addSql('ALTER TABLE user_product DROP user_order_id, DROP created_at');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_order (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, discount INT NOT NULL, reference VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP INDEX UNIQ_88BDF3E97BA2F5EB ON app_user');
        $this->addSql('ALTER TABLE app_user DROP api_token');
        $this->addSql('ALTER TABLE product ADD quantity INT NOT NULL, ADD picture VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_product ADD user_order_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_product ADD CONSTRAINT FK_8B471AA76D128938 FOREIGN KEY (user_order_id) REFERENCES user_order (id)');
        $this->addSql('CREATE INDEX IDX_8B471AA76D128938 ON user_product (user_order_id)');
    }
}
