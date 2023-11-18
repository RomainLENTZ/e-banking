<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231118154742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emprunt (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, emprunteur_id INTEGER NOT NULL, montant DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, echeance DATETIME NOT NULL, annuite DOUBLE PRECISION NOT NULL, taux DOUBLE PRECISION NOT NULL, CONSTRAINT FK_364071D7F0840037 FOREIGN KEY (emprunteur_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_364071D7F0840037 ON emprunt (emprunteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE emprunt');
    }
}
