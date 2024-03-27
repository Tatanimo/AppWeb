<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327125911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE companies_addresses (id INT AUTO_INCREMENT NOT NULL, companies_id INT NOT NULL, cities_id INT NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_9E53F9446AE4741E (companies_id), INDEX IDX_9E53F944CAC75398 (cities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companies_addresses ADD CONSTRAINT FK_9E53F9446AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE companies_addresses ADD CONSTRAINT FK_9E53F944CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE cities_companies DROP FOREIGN KEY FK_49B880FF6AE4741E');
        $this->addSql('ALTER TABLE cities_companies DROP FOREIGN KEY FK_49B880FFCAC75398');
        $this->addSql('DROP TABLE cities_companies');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cities_companies (cities_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_49B880FFCAC75398 (cities_id), INDEX IDX_49B880FF6AE4741E (companies_id), PRIMARY KEY(cities_id, companies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cities_companies ADD CONSTRAINT FK_49B880FF6AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cities_companies ADD CONSTRAINT FK_49B880FFCAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE companies_addresses DROP FOREIGN KEY FK_9E53F9446AE4741E');
        $this->addSql('ALTER TABLE companies_addresses DROP FOREIGN KEY FK_9E53F944CAC75398');
        $this->addSql('DROP TABLE companies_addresses');
    }
}
