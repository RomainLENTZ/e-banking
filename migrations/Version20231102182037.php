<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102182037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compte (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, detenteur_id INTEGER NOT NULL, numero VARCHAR(15) NOT NULL, type_de_compte VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, CONSTRAINT FK_CFF65260742F89B9 FOREIGN KEY (detenteur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CFF65260742F89B9 ON compte (detenteur_id)');
        $this->addSql('CREATE TABLE operation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, CONSTRAINT FK_1981A66D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES compte (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1981A66D60BB6FE6 ON operation (auteur_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, rib VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE virement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, compte_beneficiaire_id INTEGER NOT NULL, compte_emetteur_id INTEGER NOT NULL, date DATETIME NOT NULL, montant DOUBLE PRECISION NOT NULL, CONSTRAINT FK_2D4DCFA693345638 FOREIGN KEY (compte_beneficiaire_id) REFERENCES compte (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2D4DCFA655F8A4D8 FOREIGN KEY (compte_emetteur_id) REFERENCES compte (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2D4DCFA693345638 ON virement (compte_beneficiaire_id)');
        $this->addSql('CREATE INDEX IDX_2D4DCFA655F8A4D8 ON virement (compte_emetteur_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE virement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
