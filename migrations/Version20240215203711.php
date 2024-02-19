<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215203711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_order ADD orders_id INT DEFAULT NULL, ADD products_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_order ADD CONSTRAINT FK_F68579A8CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE ligne_order ADD CONSTRAINT FK_F68579A86C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_F68579A8CFFE9AD6 ON ligne_order (orders_id)');
        $this->addSql('CREATE INDEX IDX_F68579A86C8A81A9 ON ligne_order (products_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD ref VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE product CHANGE rating rating NUMERIC(2, 1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE rating rating NUMERIC(2, 1) DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_order DROP FOREIGN KEY FK_F68579A8CFFE9AD6');
        $this->addSql('ALTER TABLE ligne_order DROP FOREIGN KEY FK_F68579A86C8A81A9');
        $this->addSql('DROP INDEX IDX_F68579A8CFFE9AD6 ON ligne_order');
        $this->addSql('DROP INDEX IDX_F68579A86C8A81A9 ON ligne_order');
        $this->addSql('ALTER TABLE ligne_order DROP orders_id, DROP products_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP ref');
    }
}
