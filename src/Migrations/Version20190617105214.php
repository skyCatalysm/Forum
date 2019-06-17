<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190617105214 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(180) NOT NULL, total_threads INT NOT NULL, image_filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE replies (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, thread_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A000672AF675F31B (author_id), INDEX IDX_A000672AE2904019 (thread_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE threads (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, category_id INT NOT NULL, subject VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6F8E3DDDF675F31B (author_id), INDEX IDX_6F8E3DDD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE replies ADD CONSTRAINT FK_A000672AE2904019 FOREIGN KEY (thread_id) REFERENCES threads (id)');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDDF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE threads ADD CONSTRAINT FK_6F8E3DDD12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDD12469DE2');
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AE2904019');
        $this->addSql('ALTER TABLE replies DROP FOREIGN KEY FK_A000672AF675F31B');
        $this->addSql('ALTER TABLE threads DROP FOREIGN KEY FK_6F8E3DDDF675F31B');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE replies');
        $this->addSql('DROP TABLE threads');
        $this->addSql('DROP TABLE user');
    }
}
