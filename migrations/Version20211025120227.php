<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025120227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD titlear VARCHAR(255) DEFAULT NULL, ADD descriptionar LONGTEXT DEFAULT NULL, ADD source VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE brochure ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE other_resouce ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo_archive ADD namear VARCHAR(255) DEFAULT NULL, ADD source VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pledoyer ADD descriptionar VARCHAR(255) DEFAULT NULL, ADD titrear VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE programme ADD adressear VARCHAR(255) DEFAULT NULL, ADD titlear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projection_debat ADD titlear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE retombe_mediatique ADD legendear VARCHAR(255) DEFAULT NULL, ADD titlear VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE temoignage ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_archive ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_pledoyer ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_projection_debat ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_rm ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_temoignage ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP titlear, DROP descriptionar, DROP source');
        $this->addSql('ALTER TABLE brochure DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE other_resouce DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE photo_archive DROP namear, DROP source, DROP descriptionar');
        $this->addSql('ALTER TABLE pledoyer DROP descriptionar, DROP titrear');
        $this->addSql('ALTER TABLE programme DROP adressear, DROP titlear, DROP descriptionar');
        $this->addSql('ALTER TABLE projection_debat DROP titlear, DROP descriptionar');
        $this->addSql('ALTER TABLE rapport DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE retombe_mediatique DROP legendear, DROP titlear');
        $this->addSql('ALTER TABLE temoignage DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_archive DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_pledoyer DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_projection_debat DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_rm DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_temoignage DROP titrear, DROP descriptionar');
    }
}
