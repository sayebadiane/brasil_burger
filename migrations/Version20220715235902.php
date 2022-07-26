<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715235902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson_taille_commande (id INT AUTO_INCREMENT NOT NULL, boissontaille_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_F389E8C427A37561 (boissontaille_id), INDEX IDX_F389E8C482EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson_taille_commande ADD CONSTRAINT FK_F389E8C427A37561 FOREIGN KEY (boissontaille_id) REFERENCES boisson_taille (id)');
        $this->addSql('ALTER TABLE boisson_taille_commande ADD CONSTRAINT FK_F389E8C482EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE boisson_taille_commande');
    }
}
