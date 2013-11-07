<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131107023730 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE rsvp_type (type VARCHAR(255) NOT NULL, PRIMARY KEY(type)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE rsvp ADD type VARCHAR(255) DEFAULT NULL AFTER rsvp_id");
        $this->addSql("ALTER TABLE rsvp ADD CONSTRAINT FK_9FA5CE4E8CDE5729 FOREIGN KEY (type) REFERENCES rsvp_type (type)");
        $this->addSql("CREATE INDEX IDX_9FA5CE4E8CDE5729 ON rsvp (type)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE rsvp DROP FOREIGN KEY FK_9FA5CE4E8CDE5729");
        $this->addSql("DROP TABLE rsvp_type");
        $this->addSql("DROP INDEX IDX_9FA5CE4E8CDE5729 ON rsvp");
        $this->addSql("ALTER TABLE rsvp DROP type");
    }
}
