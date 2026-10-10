<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710165303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP FOREIGN KEY FK_13CC40EA925031EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment DROP FOREIGN KEY FK_61E4DD5FA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ticket_payment
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_13CC40EA925031EF ON issued_ticket
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP ticket_payment_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ticket_payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', transaction_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL, INDEX IDX_61E4DD5FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket_payment ADD CONSTRAINT FK_61E4DD5FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD ticket_payment_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD CONSTRAINT FK_13CC40EA925031EF FOREIGN KEY (ticket_payment_id) REFERENCES ticket_payment (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13CC40EA925031EF ON issued_ticket (ticket_payment_id)
        SQL);
    }
}
