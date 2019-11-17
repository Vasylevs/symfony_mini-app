<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117194315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX date ON orders (date)');
        $this->addSql('CREATE INDEX status_user ON orders (status, user_id)');
        $this->addSql('CREATE INDEX date_status_user ON orders (date, status, user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX date ON orders');
        $this->addSql('DROP INDEX status_user ON orders');
        $this->addSql('DROP INDEX date_status_user ON orders');
        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT NOT NULL');
    }
}
