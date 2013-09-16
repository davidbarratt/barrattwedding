<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130916185634 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE rsvp ADD party_size INT NOT NULL AFTER phone");
        
        $this->addSql('UPDATE rsvp SET party_size = adults + children WHERE rsvp_id = rsvp_id');
                
        $this->addSql("ALTER TABLE rsvp DROP adults, DROP children");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE rsvp ADD children INT NOT NULL AFTER party_size, CHANGE party_size adults INT NOT NULL AFTER party_size");
    }
}
