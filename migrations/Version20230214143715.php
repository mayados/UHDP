<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214143715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_memorial (id INT AUTO_INCREMENT NOT NULL, categorie_animal_id INT NOT NULL, auteur_id INT NOT NULL, nom VARCHAR(50) NOT NULL, sexe VARCHAR(10) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, date_deces DATETIME DEFAULT NULL, lieu VARCHAR(100) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, presentation LONGTEXT NOT NULL, choses_aimees LONGTEXT NOT NULL, choses_detestees LONGTEXT NOT NULL, histoire LONGTEXT NOT NULL, INDEX IDX_201B1CA923C92311 (categorie_animal_id), INDEX IDX_201B1CA960BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE belle_histoire (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, INDEX IDX_DA312DEA60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_animal (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_belle_histoire (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, belle_histoire_id INT NOT NULL, texte LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_D2723C2360BB6FE6 (auteur_id), INDEX IDX_D2723C23B3C0CA49 (belle_histoire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mot_commemoration (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, mot LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_9D6E7D4760BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, memorial_id INT NOT NULL, photo VARCHAR(255) NOT NULL, INDEX IDX_14B784187B40E4F7 (memorial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, topic_id INT NOT NULL, texte LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_5A8A6C8D60BB6FE6 (auteur_id), INDEX IDX_5A8A6C8D1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, verrouillage TINYINT(1) NOT NULL, INDEX IDX_9D40DE1B60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(50) NOT NULL, photo VARCHAR(255) DEFAULT NULL, bannir TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_memorial ADD CONSTRAINT FK_201B1CA923C92311 FOREIGN KEY (categorie_animal_id) REFERENCES categorie_animal (id)');
        // $this->addSql('ALTER TABLE animal_memorial ADD CONSTRAINT FK_201B1CA960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE belle_histoire ADD CONSTRAINT FK_DA312DEA60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_belle_histoire ADD CONSTRAINT FK_D2723C2360BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE comment_belle_histoire ADD CONSTRAINT FK_D2723C23B3C0CA49 FOREIGN KEY (belle_histoire_id) REFERENCES belle_histoire (id)');
        // $this->addSql('ALTER TABLE mot_commemoration ADD CONSTRAINT FK_9D6E7D4760BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784187B40E4F7 FOREIGN KEY (memorial_id) REFERENCES animal_memorial (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_memorial DROP FOREIGN KEY FK_201B1CA923C92311');
        $this->addSql('ALTER TABLE animal_memorial DROP FOREIGN KEY FK_201B1CA960BB6FE6');
        $this->addSql('ALTER TABLE belle_histoire DROP FOREIGN KEY FK_DA312DEA60BB6FE6');
        $this->addSql('ALTER TABLE comment_belle_histoire DROP FOREIGN KEY FK_D2723C2360BB6FE6');
        $this->addSql('ALTER TABLE comment_belle_histoire DROP FOREIGN KEY FK_D2723C23B3C0CA49');
        $this->addSql('ALTER TABLE mot_commemoration DROP FOREIGN KEY FK_9D6E7D4760BB6FE6');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784187B40E4F7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D60BB6FE6');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D1F55203D');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B60BB6FE6');
        $this->addSql('DROP TABLE animal_memorial');
        $this->addSql('DROP TABLE belle_histoire');
        $this->addSql('DROP TABLE categorie_animal');
        $this->addSql('DROP TABLE comment_belle_histoire');
        $this->addSql('DROP TABLE mot_commemoration');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
