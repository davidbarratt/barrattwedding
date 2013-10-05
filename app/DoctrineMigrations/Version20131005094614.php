<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131005094614 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE rsvp ADD first_name VARCHAR(255) NOT NULL AFTER name");
        $this->addSql("ALTER TABLE rsvp ADD last_name VARCHAR(255) NOT NULL AFTER first_name");
        $this->addSql("ALTER TABLE rsvp DROP name");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE rsvp ADD name VARCHAR(255) NOT NULL AFTER attending");
        $this->addSql("ALTER TABLE rsvp DROP first_name");
        $this->addSql("ALTER TABLE rsvp DROP last_name");

    }
}
