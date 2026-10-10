<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710102144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_history ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_history ADD CONSTRAINT FK_DC60B84CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DC60B84CA76ED395 ON cart_history (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_history DROP FOREIGN KEY FK_DC60B84CA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_DC60B84CA76ED395 ON cart_history
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cart_history DROP user_id
        SQL);
    }
}
