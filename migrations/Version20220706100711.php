<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706100711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_portion_frite ADD menu_id INT DEFAULT NULL, ADD portionfrite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_portion_frite ADD CONSTRAINT FK_29FA693BCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_portion_frite ADD CONSTRAINT FK_29FA693BB2D45716 FOREIGN KEY (portionfrite_id) REFERENCES portion_frite (id)');
        $this->addSql('CREATE INDEX IDX_29FA693BCCD7E912 ON menu_portion_frite (menu_id)');
        $this->addSql('CREATE INDEX IDX_29FA693BB2D45716 ON menu_portion_frite (portionfrite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_portion_frite DROP FOREIGN KEY FK_29FA693BCCD7E912');
        $this->addSql('ALTER TABLE menu_portion_frite DROP FOREIGN KEY FK_29FA693BB2D45716');
        $this->addSql('DROP INDEX IDX_29FA693BCCD7E912 ON menu_portion_frite');
        $this->addSql('DROP INDEX IDX_29FA693BB2D45716 ON menu_portion_frite');
        $this->addSql('ALTER TABLE menu_portion_frite DROP menu_id, DROP portionfrite_id');
    }
}
