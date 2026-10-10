<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710171002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8AEBAF57
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E00CEDDE8AEBAF57 ON booking
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD transaction_id VARCHAR(255) NOT NULL, DROP festival_id, DROP expire_time
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD booking_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket ADD CONSTRAINT FK_13CC40EA3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_13CC40EA3301C60 ON issued_ticket (booking_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD festival_id INT NOT NULL, ADD expire_time DATETIME NOT NULL, DROP transaction_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8AEBAF57 FOREIGN KEY (festival_id) REFERENCES festival (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E00CEDDE8AEBAF57 ON booking (festival_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP FOREIGN KEY FK_13CC40EA3301C60
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_13CC40EA3301C60 ON issued_ticket
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE issued_ticket DROP booking_id
        SQL);
    }
}
