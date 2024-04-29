<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429093502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, fk_category_id INT NOT NULL, fk_user_id INT NOT NULL, name VARCHAR(50) NOT NULL, race VARCHAR(50) DEFAULT NULL, weight INT DEFAULT NULL, birthdate DATE DEFAULT NULL, death TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, INDEX IDX_966C69DD7BB031D6 (fk_category_id), INDEX IDX_966C69DD5741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(50) DEFAULT NULL, publication_date DATE DEFAULT NULL, state TINYINT(1) DEFAULT NULL, keyword JSON DEFAULT NULL, modification_date DATE DEFAULT NULL, slug VARCHAR(50) NOT NULL, INDEX IDX_BFDD316867B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_animals (id INT AUTO_INCREMENT NOT NULL, fk_family_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, INDEX IDX_51B429A3A20781FA (fk_family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cities (id INT AUTO_INCREMENT NOT NULL, department_code VARCHAR(3) DEFAULT NULL, name VARCHAR(255) NOT NULL, zip_code VARCHAR(5) DEFAULT NULL, insee_code VARCHAR(5) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_D95DB16BD50F57CD (department_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaries (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT NOT NULL, posts_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATE NOT NULL, modification_date DATETIME DEFAULT NULL, INDEX IDX_4ED55CCB5741EEB9 (fk_user_id), INDEX IDX_4ED55CCBD5E258C5 (posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, image VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companies_addresses (id INT AUTO_INCREMENT NOT NULL, companies_id INT NOT NULL, cities_id INT NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_9E53F9446AE4741E (companies_id), INDEX IDX_9E53F944CAC75398 (cities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departments (code VARCHAR(3) NOT NULL, region_code VARCHAR(3) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_16AEB8D4AEB327AF (region_code), PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_animals (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, rooms_id VARCHAR(255) DEFAULT NULL, author_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATETIME NOT NULL, INDEX IDX_DB021E968E2368AB (rooms_id), INDEX IDX_DB021E96F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATE NOT NULL, keyword JSON DEFAULT NULL, state TINYINT(1) DEFAULT NULL, modification_date DATETIME DEFAULT NULL, INDEX IDX_885DBAFA5741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reactions (id INT AUTO_INCREMENT NOT NULL, posts_id INT DEFAULT NULL, users_id INT NOT NULL, commentaries_id INT DEFAULT NULL, emoji VARCHAR(50) NOT NULL, INDEX IDX_38737FB3D5E258C5 (posts_id), INDEX IDX_38737FB367B3B43D (users_id), INDEX IDX_38737FB31B0C88DC (commentaries_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (code VARCHAR(3) NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (fk_user_sender_id INT NOT NULL, fk_user_receiver_id INT NOT NULL, rating INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_6970EB0F83CAD790 (fk_user_sender_id), INDEX IDX_6970EB0F32224354 (fk_user_receiver_id), PRIMARY KEY(fk_user_sender_id, fk_user_receiver_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (reference VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, PRIMARY KEY(reference)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedules (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, animals_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_313BDC8E67B3B43D (users_id), INDEX IDX_313BDC8E132B9E58 (animals_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services_type_companies (services_type_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_78E76EF42CB74764 (services_type_id), INDEX IDX_78E76EF46AE4741E (companies_id), PRIMARY KEY(services_type_id, companies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, fk_company_id INT DEFAULT NULL, cities_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(100) NOT NULL, created_date DATE NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), INDEX IDX_1483A5E967F5D045 (fk_company_id), INDEX IDX_1483A5E9CAC75398 (cities_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD7BB031D6 FOREIGN KEY (fk_category_id) REFERENCES category_animals (id)');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316867B3B43D FOREIGN KEY (users_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE category_animals ADD CONSTRAINT FK_51B429A3A20781FA FOREIGN KEY (fk_family_id) REFERENCES family_animals (id)');
        $this->addSql('ALTER TABLE cities ADD CONSTRAINT FK_D95DB16BD50F57CD FOREIGN KEY (department_code) REFERENCES departments (code)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCB5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE commentaries ADD CONSTRAINT FK_4ED55CCBD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE companies_addresses ADD CONSTRAINT FK_9E53F9446AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE companies_addresses ADD CONSTRAINT FK_9E53F944CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id)');
        $this->addSql('ALTER TABLE departments ADD CONSTRAINT FK_16AEB8D4AEB327AF FOREIGN KEY (region_code) REFERENCES regions (code)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E968E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (reference)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96F675F31B FOREIGN KEY (author_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reactions ADD CONSTRAINT FK_38737FB3D5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE reactions ADD CONSTRAINT FK_38737FB367B3B43D FOREIGN KEY (users_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reactions ADD CONSTRAINT FK_38737FB31B0C88DC FOREIGN KEY (commentaries_id) REFERENCES commentaries (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F83CAD790 FOREIGN KEY (fk_user_sender_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F32224354 FOREIGN KEY (fk_user_receiver_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E67B3B43D FOREIGN KEY (users_id) REFERENCES `users` (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E132B9E58 FOREIGN KEY (animals_id) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE services_type_companies ADD CONSTRAINT FK_78E76EF42CB74764 FOREIGN KEY (services_type_id) REFERENCES services_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE services_type_companies ADD CONSTRAINT FK_78E76EF46AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E967F5D045 FOREIGN KEY (fk_company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE `users` ADD CONSTRAINT FK_1483A5E9CAC75398 FOREIGN KEY (cities_id) REFERENCES cities (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD7BB031D6');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD5741EEB9');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD316867B3B43D');
        $this->addSql('ALTER TABLE category_animals DROP FOREIGN KEY FK_51B429A3A20781FA');
        $this->addSql('ALTER TABLE cities DROP FOREIGN KEY FK_D95DB16BD50F57CD');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCB5741EEB9');
        $this->addSql('ALTER TABLE commentaries DROP FOREIGN KEY FK_4ED55CCBD5E258C5');
        $this->addSql('ALTER TABLE companies_addresses DROP FOREIGN KEY FK_9E53F9446AE4741E');
        $this->addSql('ALTER TABLE companies_addresses DROP FOREIGN KEY FK_9E53F944CAC75398');
        $this->addSql('ALTER TABLE departments DROP FOREIGN KEY FK_16AEB8D4AEB327AF');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E968E2368AB');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F675F31B');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA5741EEB9');
        $this->addSql('ALTER TABLE reactions DROP FOREIGN KEY FK_38737FB3D5E258C5');
        $this->addSql('ALTER TABLE reactions DROP FOREIGN KEY FK_38737FB367B3B43D');
        $this->addSql('ALTER TABLE reactions DROP FOREIGN KEY FK_38737FB31B0C88DC');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F83CAD790');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F32224354');
        $this->addSql('ALTER TABLE schedules DROP FOREIGN KEY FK_313BDC8E67B3B43D');
        $this->addSql('ALTER TABLE schedules DROP FOREIGN KEY FK_313BDC8E132B9E58');
        $this->addSql('ALTER TABLE services_type_companies DROP FOREIGN KEY FK_78E76EF42CB74764');
        $this->addSql('ALTER TABLE services_type_companies DROP FOREIGN KEY FK_78E76EF46AE4741E');
        $this->addSql('ALTER TABLE `users` DROP FOREIGN KEY FK_1483A5E967F5D045');
        $this->addSql('ALTER TABLE `users` DROP FOREIGN KEY FK_1483A5E9CAC75398');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE category_animals');
        $this->addSql('DROP TABLE cities');
        $this->addSql('DROP TABLE commentaries');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE companies_addresses');
        $this->addSql('DROP TABLE departments');
        $this->addSql('DROP TABLE family_animals');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE reactions');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE schedules');
        $this->addSql('DROP TABLE services_type');
        $this->addSql('DROP TABLE services_type_companies');
        $this->addSql('DROP TABLE `users`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
