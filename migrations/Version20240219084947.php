<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219084947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_order ADD order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_order ADD CONSTRAINT FK_F68579A88D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_F68579A88D9F6D38 ON ligne_order (order_id)');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD ref VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_order DROP FOREIGN KEY FK_F68579A88D9F6D38');
        $this->addSql('DROP INDEX IDX_F68579A88D9F6D38 ON ligne_order');
        $this->addSql('ALTER TABLE ligne_order DROP order_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP user_id, DROP ref');
    }
}