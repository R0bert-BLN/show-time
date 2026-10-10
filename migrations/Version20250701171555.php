<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701171555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, picture VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, festival_id INT NOT NULL, user_id INT NOT NULL, expire_time DATETIME NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, quantity INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E00CEDDE8AEBAF57 (festival_id), INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE booking_ticket_type (booking_id INT NOT NULL, ticket_type_id INT NOT NULL, INDEX IDX_999E99D83301C60 (booking_id), INDEX IDX_999E99D8C980D5C1 (ticket_type_id), PRIMARY KEY(booking_id, ticket_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', status VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cart_history (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', status VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, ticket_type_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL, INDEX IDX_F0FE25271AD5CDBF (cart_id), INDEX IDX_F0FE2527C980D5C1 (ticket_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE festival (id INT AUTO_INCREMENT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, picture VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, INDEX IDX_57CF78964D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE festival_band (id INT AUTO_INCREMENT NOT NULL, festival_id INT NOT NULL, band_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, stage VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, INDEX IDX_92214B7C8AEBAF57 (festival_id), INDEX IDX_92214B7C49ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE issued_ticket (id INT AUTO_INCREMENT NOT NULL, ticket_type_id INT NOT NULL, ticket_payment_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, INDEX IDX_13CC40EAC980D5C1 (ticket_type_id), INDEX IDX_13CC40EA925031EF (ticket_payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE issued_ticket_user (issued_ticket_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D09C0FA7A09F51CB (issued_ticket_id), INDEX IDX_D09C0FA7A76ED395 (user_id), PRIMARY KEY(issued_ticket_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ticket_payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', transaction_id VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_61E4DD5FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ticket_payment_ticket_type (ticket_payment_id INT NOT NULL, ticket_type_id INT NOT NULL, INDEX IDX_1F8DA8C2925031EF (ticket_payment_id), INDEX IDX_1F8DA8C2C980D5C1 (ticket_type_id), PRIMARY KEY(ticket_payment_id, ticket_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE ticket_type (id INT AUTO_INCREMENT NOT NULL, festival_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, total_tickets INT NOT NULL, start_sale_date DATETIME NOT NULL, end_sale_date DATETIME NOT NULL, price NUMERIC(10, 2) NOT NULL, currency VARCHAR(3) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, INDEX IDX_BE0542118AEBAF57 (festival_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type ADD CONSTRAINT FK_999E99D83301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type ADD CONSTRAINT FK_999E99D8C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart_history (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival ADD CONSTRAINT FK_57CF78964D218E FOREIGN KEY (location_id) REFERENCES location (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_band ADD CONSTRAINT FK_92214B7C8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_band ADD CONSTRAINT FK_92214B7C49ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD CONSTRAINT FK_13CC40EAC980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD CONSTRAINT FK_13CC40EA925031EF FOREIGN KEY (ticket_payment_id) REFERENCES ticket_payment (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket_user ADD CONSTRAINT FK_D09C0FA7A09F51CB FOREIGN KEY (issued_ticket_id) REFERENCES issued_ticket (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket_user ADD CONSTRAINT FK_D09C0FA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment ADD CONSTRAINT FK_61E4DD5FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment_ticket_type ADD CONSTRAINT FK_1F8DA8C2925031EF FOREIGN KEY (ticket_payment_id) REFERENCES ticket_payment (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment_ticket_type ADD CONSTRAINT FK_1F8DA8C2C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type ADD CONSTRAINT FK_BE0542118AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type DROP FOREIGN KEY FK_999E99D83301C60
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type DROP FOREIGN KEY FK_999E99D8C980D5C1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527C980D5C1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival DROP FOREIGN KEY FK_57CF78964D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_band DROP FOREIGN KEY FK_92214B7C8AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE festival_band DROP FOREIGN KEY FK_92214B7C49ABEB17
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP FOREIGN KEY FK_13CC40EAC980D5C1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP FOREIGN KEY FK_13CC40EA925031EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket_user DROP FOREIGN KEY FK_D09C0FA7A09F51CB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket_user DROP FOREIGN KEY FK_D09C0FA7A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment DROP FOREIGN KEY FK_61E4DD5FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment_ticket_type DROP FOREIGN KEY FK_1F8DA8C2925031EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment_ticket_type DROP FOREIGN KEY FK_1F8DA8C2C980D5C1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_type DROP FOREIGN KEY FK_BE0542118AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE band
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking_ticket_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cart
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cart_history
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cart_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE festival
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE festival_band
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE issued_ticket
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE issued_ticket_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE location
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ticket_payment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ticket_payment_ticket_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ticket_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
