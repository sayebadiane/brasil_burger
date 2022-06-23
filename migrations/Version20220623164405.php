<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623164405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D17CE5090');
        $this->addSql('DROP INDEX IDX_EFE35A0D17CE5090 ON burger');
        $this->addSql('ALTER TABLE burger CHANGE burger_id catalogues_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D685E5B99 FOREIGN KEY (catalogues_id) REFERENCES catalogues (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D685E5B99 ON burger (catalogues_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A934A7843DC');
        $this->addSql('DROP INDEX IDX_7D053A934A7843DC ON menu');
        $this->addSql('ALTER TABLE menu CHANGE catalogue_id catalogues_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93685E5B99 FOREIGN KEY (catalogues_id) REFERENCES catalogues (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93685E5B99 ON menu (catalogues_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0D685E5B99');
        $this->addSql('DROP INDEX IDX_EFE35A0D685E5B99 ON burger');
        $this->addSql('ALTER TABLE burger CHANGE catalogues_id burger_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0D17CE5090 FOREIGN KEY (burger_id) REFERENCES catalogues (id)');
        $this->addSql('CREATE INDEX IDX_EFE35A0D17CE5090 ON burger (burger_id)');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93685E5B99');
        $this->addSql('DROP INDEX IDX_7D053A93685E5B99 ON menu');
        $this->addSql('ALTER TABLE menu CHANGE catalogues_id catalogue_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A934A7843DC FOREIGN KEY (catalogue_id) REFERENCES catalogues (id)');
        $this->addSql('CREATE INDEX IDX_7D053A934A7843DC ON menu (catalogue_id)');
    }
}
