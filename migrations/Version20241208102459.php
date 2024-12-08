<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208102459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F529D066842');
        $this->addSql('DROP INDEX IDX_8D1E5F529D066842 ON pilot');
        $this->addSql('ALTER TABLE pilot CHANGE categoty_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F5212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8D1E5F5212469DE2 ON pilot (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F5212469DE2');
        $this->addSql('DROP INDEX IDX_8D1E5F5212469DE2 ON pilot');
        $this->addSql('ALTER TABLE pilot CHANGE category_id categoty_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F529D066842 FOREIGN KEY (categoty_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8D1E5F529D066842 ON pilot (categoty_id)');
    }
}
