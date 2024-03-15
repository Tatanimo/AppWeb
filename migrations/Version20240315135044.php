<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315135044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agenda (id INT AUTO_INCREMENT NOT NULL, fk_user_1_id INT NOT NULL, fk_user_2_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_2CEDC877EB0BC7A3 (fk_user_1_id), INDEX IDX_2CEDC877F9BE684D (fk_user_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animals (id INT AUTO_INCREMENT NOT NULL, fk_category_id INT NOT NULL, fk_user_id INT NOT NULL, name VARCHAR(50) NOT NULL, race VARCHAR(50) DEFAULT NULL, weight INT DEFAULT NULL, birthdate DATE DEFAULT NULL, death TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, INDEX IDX_966C69DD7BB031D6 (fk_category_id), INDEX IDX_966C69DD5741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(50) DEFAULT NULL, publication_date DATE DEFAULT NULL, state TINYINT(1) DEFAULT NULL, keyword VARCHAR(50) DEFAULT NULL, modification_date DATE DEFAULT NULL, slug VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis_user (id INT AUTO_INCREMENT NOT NULL, fk_user_sender_id INT NOT NULL, fk_user_receiver_id INT NOT NULL, note INT NOT NULL, INDEX IDX_42223E4883CAD790 (fk_user_sender_id), INDEX IDX_42223E4832224354 (fk_user_receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_animals (id INT AUTO_INCREMENT NOT NULL, fk_family_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, INDEX IDX_51B429A3A20781FA (fk_family_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentary (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT NOT NULL, fk_publication_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATE NOT NULL, number_like INT DEFAULT NULL, INDEX IDX_1CAC12CA5741EEB9 (fk_user_id), INDEX IDX_1CAC12CA4DBCFE4E (fk_publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, fk_type_id INT NOT NULL, name VARCHAR(50) NOT NULL, type VARCHAR(30) NOT NULL, adress VARCHAR(100) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, image VARCHAR(50) DEFAULT NULL, INDEX IDX_4FBF094F3563B1BF (fk_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE family_animals (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, rooms_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATE NOT NULL, author INT NOT NULL, INDEX IDX_DB021E968E2368AB (rooms_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, fk_user_id INT NOT NULL, content LONGTEXT NOT NULL, publication_date DATE NOT NULL, keyword VARCHAR(50) DEFAULT NULL, number_like INT DEFAULT NULL, state TINYINT(1) DEFAULT NULL, INDEX IDX_AF3C67795741EEB9 (fk_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, fk_user1_id INT NOT NULL, fk_user2_id INT NOT NULL, INDEX IDX_7CA11A9664866755 (fk_user1_id), INDEX IDX_7CA11A967633C8BB (fk_user2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_company (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, fk_company_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, adress VARCHAR(100) DEFAULT NULL, postal_code VARCHAR(10) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, image VARCHAR(50) DEFAULT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64967F5D045 (fk_company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877EB0BC7A3 FOREIGN KEY (fk_user_1_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE agenda ADD CONSTRAINT FK_2CEDC877F9BE684D FOREIGN KEY (fk_user_2_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD7BB031D6 FOREIGN KEY (fk_category_id) REFERENCES category_animals (id)');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE avis_user ADD CONSTRAINT FK_42223E4883CAD790 FOREIGN KEY (fk_user_sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE avis_user ADD CONSTRAINT FK_42223E4832224354 FOREIGN KEY (fk_user_receiver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE category_animals ADD CONSTRAINT FK_51B429A3A20781FA FOREIGN KEY (fk_family_id) REFERENCES family_animals (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT FK_1CAC12CA4DBCFE4E FOREIGN KEY (fk_publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F3563B1BF FOREIGN KEY (fk_type_id) REFERENCES type_company (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E968E2368AB FOREIGN KEY (rooms_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67795741EEB9 FOREIGN KEY (fk_user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A9664866755 FOREIGN KEY (fk_user1_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rooms ADD CONSTRAINT FK_7CA11A967633C8BB FOREIGN KEY (fk_user2_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64967F5D045 FOREIGN KEY (fk_company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877EB0BC7A3');
        $this->addSql('ALTER TABLE agenda DROP FOREIGN KEY FK_2CEDC877F9BE684D');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD7BB031D6');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD5741EEB9');
        $this->addSql('ALTER TABLE avis_user DROP FOREIGN KEY FK_42223E4883CAD790');
        $this->addSql('ALTER TABLE avis_user DROP FOREIGN KEY FK_42223E4832224354');
        $this->addSql('ALTER TABLE category_animals DROP FOREIGN KEY FK_51B429A3A20781FA');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA5741EEB9');
        $this->addSql('ALTER TABLE commentary DROP FOREIGN KEY FK_1CAC12CA4DBCFE4E');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F3563B1BF');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E968E2368AB');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67795741EEB9');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A9664866755');
        $this->addSql('ALTER TABLE rooms DROP FOREIGN KEY FK_7CA11A967633C8BB');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64967F5D045');
        $this->addSql('DROP TABLE agenda');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE avis_user');
        $this->addSql('DROP TABLE category_animals');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE family_animals');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE type_company');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
