<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241208163342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constructor ADD category_id INT DEFAULT NULL, ADD current_season_id INT DEFAULT NULL, DROP category, DROP current_season');
        $this->addSql('ALTER TABLE constructor ADD CONSTRAINT FK_7DD91A3912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE constructor ADD CONSTRAINT FK_7DD91A3995E6B07D FOREIGN KEY (current_season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_7DD91A3912469DE2 ON constructor (category_id)');
        $this->addSql('CREATE INDEX IDX_7DD91A3995E6B07D ON constructor (current_season_id)');
        $this->addSql('ALTER TABLE pilot ADD category_id INT DEFAULT NULL, ADD current_season_id INT DEFAULT NULL, DROP category, DROP current_season');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F5212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE pilot ADD CONSTRAINT FK_8D1E5F5295E6B07D FOREIGN KEY (current_season_id) REFERENCES season (id)');
        $this->addSql('CREATE INDEX IDX_8D1E5F5212469DE2 ON pilot (category_id)');
        $this->addSql('CREATE INDEX IDX_8D1E5F5295E6B07D ON pilot (current_season_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE constructor DROP FOREIGN KEY FK_7DD91A3912469DE2');
        $this->addSql('ALTER TABLE constructor DROP FOREIGN KEY FK_7DD91A3995E6B07D');
        $this->addSql('DROP INDEX IDX_7DD91A3912469DE2 ON constructor');
        $this->addSql('DROP INDEX IDX_7DD91A3995E6B07D ON constructor');
        $this->addSql('ALTER TABLE constructor ADD category VARCHAR(255) NOT NULL, ADD current_season VARCHAR(255) NOT NULL, DROP category_id, DROP current_season_id');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F5212469DE2');
        $this->addSql('ALTER TABLE pilot DROP FOREIGN KEY FK_8D1E5F5295E6B07D');
        $this->addSql('DROP INDEX IDX_8D1E5F5212469DE2 ON pilot');
        $this->addSql('DROP INDEX IDX_8D1E5F5295E6B07D ON pilot');
        $this->addSql('ALTER TABLE pilot ADD category VARCHAR(255) NOT NULL, ADD current_season VARCHAR(255) NOT NULL, DROP category_id, DROP current_season_id');
    }
}
