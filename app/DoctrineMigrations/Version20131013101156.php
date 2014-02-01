<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131013101156 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE guest (guest_id INT AUTO_INCREMENT NOT NULL, rsvp_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_ACB79A35EF80C8C2 (rsvp_id), PRIMARY KEY(guest_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE guest ADD CONSTRAINT FK_ACB79A35EF80C8C2 FOREIGN KEY (rsvp_id) REFERENCES rsvp (rsvp_id)");
        $this->addSql("ALTER TABLE rsvp DROP party_size");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE guest");
        $this->addSql("ALTER TABLE rsvp ADD party_size INT NOT NULL");
    }
}
