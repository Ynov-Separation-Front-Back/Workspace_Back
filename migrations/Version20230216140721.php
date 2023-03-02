<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216140721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, thread_id, owner_id, content, created_at, updated_at, masked FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id INTEGER NOT NULL, owner_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL, masked BOOLEAN NOT NULL, CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, thread_id, owner_id, content, created_at, updated_at, masked) SELECT id, thread_id, owner_id, content, created_at, updated_at, masked FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE2904019 ON message (thread_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, thread_id, owner_id, content, created_at, updated_at, masked FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, thread_id INTEGER NOT NULL, owner_id INTEGER NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , masked BOOLEAN NOT NULL, CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, thread_id, owner_id, content, created_at, updated_at, masked) SELECT id, thread_id, owner_id, content, created_at, updated_at, masked FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307FE2904019 ON message (thread_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
    }
}
