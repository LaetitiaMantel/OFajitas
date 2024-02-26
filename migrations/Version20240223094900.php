<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223094900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD address VARCHAR(255) NOT NULL, ADD address_complement VARCHAR(255) DEFAULT NULL, ADD zip_code INT NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD phone_number INT DEFAULT NULL, ADD billing_address VARCHAR(255) DEFAULT NULL, ADD billing_address_complement VARCHAR(255) DEFAULT NULL, ADD billing_zip_code INT DEFAULT NULL, ADD billing_city VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP address, DROP address_complement, DROP zip_code, DROP city, DROP phone_number, DROP billing_address, DROP billing_address_complement, DROP billing_zip_code, DROP billing_city');
    }
}
