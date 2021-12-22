<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211111143839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_pledoyer ADD CONSTRAINT FK_BC3703FE441C8146 FOREIGN KEY (pledoyer_id) REFERENCES pledoyer (id)');
        $this->addSql('ALTER TABLE photo_rapport ADD CONSTRAINT FK_8BD4B7111DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE photo_rm ADD CONSTRAINT FK_AE743FB2FB44446D FOREIGN KEY (retombe_mediatique_id) REFERENCES retombe_mediatique (id)');
        $this->addSql('ALTER TABLE photo_temoignage ADD CONSTRAINT FK_F1C9524EF2410A1E FOREIGN KEY (temoignage_id) REFERENCES temoignage (id)');
        $this->addSql('ALTER TABLE pledoyer ADD descriptionar VARCHAR(255) DEFAULT NULL, ADD titrear VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pledoyer ADD CONSTRAINT FK_2F0B1C74642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE programme ADD adressear VARCHAR(255) DEFAULT NULL, ADD titlear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE programme ADD CONSTRAINT FK_3DDCB9FF642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE projection_debat ADD titlear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE projection_debat ADD CONSTRAINT FK_2A4AF456642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rapport ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE retombe_mediatique ADD legendear VARCHAR(255) DEFAULT NULL, ADD titlear VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE retombe_mediatique ADD CONSTRAINT FK_F427845F642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE temoignage ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE temoignage ADD CONSTRAINT FK_BDADBC46642B8210 FOREIGN KEY (admin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE video_archive ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_p ADD CONSTRAINT FK_73C80EFB62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE video_pledoyer ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_projection_debat ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_rm ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE video_temoignage ADD titrear VARCHAR(255) DEFAULT NULL, ADD descriptionar VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo_pledoyer DROP FOREIGN KEY FK_BC3703FE441C8146');
        $this->addSql('ALTER TABLE photo_rapport DROP FOREIGN KEY FK_8BD4B7111DFBCC46');
        $this->addSql('ALTER TABLE photo_rm DROP FOREIGN KEY FK_AE743FB2FB44446D');
        $this->addSql('ALTER TABLE photo_temoignage DROP FOREIGN KEY FK_F1C9524EF2410A1E');
        $this->addSql('ALTER TABLE pledoyer DROP FOREIGN KEY FK_2F0B1C74642B8210');
        $this->addSql('ALTER TABLE pledoyer DROP descriptionar, DROP titrear');
        $this->addSql('ALTER TABLE programme DROP FOREIGN KEY FK_3DDCB9FF642B8210');
        $this->addSql('ALTER TABLE programme DROP adressear, DROP titlear, DROP descriptionar');
        $this->addSql('ALTER TABLE projection_debat DROP FOREIGN KEY FK_2A4AF456642B8210');
        $this->addSql('ALTER TABLE projection_debat DROP titlear, DROP descriptionar');
        $this->addSql('ALTER TABLE rapport DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE retombe_mediatique DROP FOREIGN KEY FK_F427845F642B8210');
        $this->addSql('ALTER TABLE retombe_mediatique DROP legendear, DROP titlear');
        $this->addSql('ALTER TABLE temoignage DROP FOREIGN KEY FK_BDADBC46642B8210');
        $this->addSql('ALTER TABLE temoignage DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_archive DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_p DROP FOREIGN KEY FK_73C80EFB62BB7AEE');
        $this->addSql('ALTER TABLE video_pledoyer DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_projection_debat DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_rm DROP titrear, DROP descriptionar');
        $this->addSql('ALTER TABLE video_temoignage DROP titrear, DROP descriptionar');
    }
}
