<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130929152425 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE album (album_id BIGINT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(album_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE song ADD album_id BIGINT DEFAULT NULL AFTER artist_id");
        $this->addSql("ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11137ABCF FOREIGN KEY (album_id) REFERENCES album (album_id)");
        $this->addSql("CREATE INDEX IDX_33EDEEA11137ABCF ON song (album_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11137ABCF");
        $this->addSql("DROP TABLE album");
        $this->addSql("DROP INDEX IDX_33EDEEA11137ABCF ON song");
        $this->addSql("ALTER TABLE song DROP album_id");
    }
}
