<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200317155430 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, ride_id INT NOT NULL, author_id INT NOT NULL, date_comment DATETIME NOT NULL, text_comment VARCHAR(255) NOT NULL, INDEX IDX_9474526C302A8A70 (ride_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE path (id INT AUTO_INCREMENT NOT NULL, departure_id INT NOT NULL, destination_id INT NOT NULL, driver_id INT NOT NULL, date_time DATETIME NOT NULL, seats INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_B548B0F7704ED06 (departure_id), INDEX IDX_B548B0F816C6140 (destination_id), INDEX IDX_B548B0FC3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE path_user (path_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E0FF5F1ED96C566B (path_id), INDEX IDX_E0FF5F1EA76ED395 (user_id), PRIMARY KEY(path_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C302A8A70 FOREIGN KEY (ride_id) REFERENCES path (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0F7704ED06 FOREIGN KEY (departure_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0F816C6140 FOREIGN KEY (destination_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE path ADD CONSTRAINT FK_B548B0FC3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE path_user ADD CONSTRAINT FK_E0FF5F1ED96C566B FOREIGN KEY (path_id) REFERENCES path (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE path_user ADD CONSTRAINT FK_E0FF5F1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C302A8A70');
        $this->addSql('ALTER TABLE path_user DROP FOREIGN KEY FK_E0FF5F1ED96C566B');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0F7704ED06');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0F816C6140');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE path DROP FOREIGN KEY FK_B548B0FC3423909');
        $this->addSql('ALTER TABLE path_user DROP FOREIGN KEY FK_E0FF5F1EA76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE path');
        $this->addSql('DROP TABLE path_user');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE user');
    }
}
