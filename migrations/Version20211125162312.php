<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125162312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE answer ADD update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE answer ALTER create_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE answer ALTER create_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN answer.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN answer.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE question ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE question DROP create_at');
        $this->addSql('ALTER TABLE question DROP category');
        $this->addSql('ALTER TABLE question ALTER update_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE question ALTER update_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN question.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN question.update_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6F7494E12469DE2 ON question (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494E12469DE2');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_B6F7494E12469DE2');
        $this->addSql('ALTER TABLE question ADD create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE question ADD category VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE question DROP category_id');
        $this->addSql('ALTER TABLE question DROP created_at');
        $this->addSql('ALTER TABLE question ALTER update_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE question ALTER update_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN question.update_at IS NULL');
        $this->addSql('ALTER TABLE answer DROP update_at');
        $this->addSql('ALTER TABLE answer ALTER create_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE answer ALTER create_at DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN answer.create_at IS NULL');
    }
}
