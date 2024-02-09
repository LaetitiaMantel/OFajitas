<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209094226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP name, DROP price, DROP delivery_zip_code, DROP delivery_adress, DROP delivery_adress_supplement, DROP delivery_city');
        $this->addSql('ALTER TABLE product ADD cart_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD20AEF35F FOREIGN KEY (cart_id_id) REFERENCES cart (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD20AEF35F ON product (cart_id_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD20AEF35F');
        $this->addSql('DROP INDEX IDX_D34A04AD20AEF35F ON product');
        $this->addSql('ALTER TABLE product DROP cart_id_id');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin` COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE `order` ADD name VARCHAR(128) NOT NULL, ADD price INT NOT NULL, ADD delivery_zip_code INT NOT NULL, ADD delivery_adress VARCHAR(255) NOT NULL, ADD delivery_adress_supplement VARCHAR(255) DEFAULT NULL, ADD delivery_city VARCHAR(45) NOT NULL');
    }
}
