<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710173012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type DROP FOREIGN KEY FK_999E99D83301C60
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type DROP FOREIGN KEY FK_999E99D8C980D5C1
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking_ticket_type
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD cart_id INT DEFAULT NULL, DROP quantity
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart_history (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_E00CEDDE1AD5CDBF ON booking (cart_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE booking_ticket_type (booking_id INT NOT NULL, ticket_type_id INT NOT NULL, INDEX IDX_999E99D83301C60 (booking_id), INDEX IDX_999E99D8C980D5C1 (ticket_type_id), PRIMARY KEY(booking_id, ticket_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type ADD CONSTRAINT FK_999E99D83301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_ticket_type ADD CONSTRAINT FK_999E99D8C980D5C1 FOREIGN KEY (ticket_type_id) REFERENCES ticket_type (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE1AD5CDBF
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_E00CEDDE1AD5CDBF ON booking
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD quantity INT NOT NULL, DROP cart_id
        SQL);
    }
}
