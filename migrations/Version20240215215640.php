<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215215640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_order DROP FOREIGN KEY FK_F68579A86C8A81A9');
        $this->addSql('DROP INDEX IDX_F68579A86C8A81A9 ON ligne_order');
        $this->addSql('ALTER TABLE ligne_order DROP products_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_order ADD products_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_order ADD CONSTRAINT FK_F68579A86C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F68579A86C8A81A9 ON ligne_order (products_id)');
    }
}
