<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611081700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE replies (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, thread_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A000672AF675F31B (author_id), INDEX IDX_A000672AE2904019 (thread_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE threads (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6F8E3DDDF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AE2904019 FOREIGN KEY (thread_id) REFERENCES threads (id)');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDDF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AE2904019');
        $this->addSql('DROP TABLE replies');
        $this->addSql('DROP TABLE threads');
    }
}
