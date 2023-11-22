<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122171147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ALTER COLUMN id INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE car ALTER COLUMN car_id INT NOT NULL');
        $this->addSql('DROP INDEX [primary] ON car_make');
        $this->addSql('ALTER TABLE car_make ADD id INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE car_make DROP COLUMN  make_id');
        $this->addSql('ALTER TABLE car_make ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX [primary] ON car_model');
        $this->addSql('ALTER TABLE car_model ALTER COLUMN id INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE car_model ADD CONSTRAINT FK_83EF70ECFBF73EB FOREIGN KEY (make_id) REFERENCES car_make (id)');
        $this->addSql('CREATE INDEX IDX_83EF70ECFBF73EB ON car_model (make_id)');
        $this->addSql('ALTER TABLE car_model ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE car_type ALTER COLUMN id INT IDENTITY NOT NULL');
        $this->addSql('ALTER TABLE car_type ALTER COLUMN type_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('ALTER TABLE car_model DROP CONSTRAINT FK_83EF70ECFBF73EB');
        $this->addSql('DROP INDEX IDX_83EF70ECFBF73EB ON car_model');
        $this->addSql('DROP INDEX PK__tmp_ms_x__DC39CAF429AE0E59 ON car_model');
        $this->addSql('ALTER TABLE car_model ALTER COLUMN id INT');
        $this->addSql('ALTER TABLE car_model ADD PRIMARY KEY (model_id)');
        $this->addSql('ALTER TABLE car ALTER COLUMN id INT NOT NULL');
        $this->addSql('ALTER TABLE car ALTER COLUMN car_id INT');
        $this->addSql('ALTER TABLE car_type ALTER COLUMN id INT NOT NULL');
        $this->addSql('ALTER TABLE car_type ALTER COLUMN type_id INT');
        $this->addSql('DROP INDEX PK_car_make ON car_make');
        $this->addSql('ALTER TABLE car_make ADD  make_id INT NOT NULL');
        $this->addSql('ALTER TABLE car_make DROP COLUMN id');
        $this->addSql('ALTER TABLE car_make ADD PRIMARY KEY ( make_id)');
    }
}
