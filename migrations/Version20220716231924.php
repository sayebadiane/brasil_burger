<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220716231924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_boisson_taille_commande (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, tailleboisson_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_D7ABB2D3CCD7E912 (menu_id), INDEX IDX_D7ABB2D382EA2E54 (commande_id), INDEX IDX_D7ABB2D336F1CA00 (tailleboisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_boisson_taille_commande ADD CONSTRAINT FK_D7ABB2D3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_boisson_taille_commande ADD CONSTRAINT FK_D7ABB2D382EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE menu_boisson_taille_commande ADD CONSTRAINT FK_D7ABB2D336F1CA00 FOREIGN KEY (tailleboisson_id) REFERENCES boisson_taille (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE menu_boisson_taille_commande');
    }
}
