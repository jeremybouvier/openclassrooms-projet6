<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190528193805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB281BE2E');
        $this->addSql('DROP INDEX IDX_6A2CA10CB281BE2E ON media');
        $this->addSql('ALTER TABLE media CHANGE trick_id trick_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB46B9EE8 FOREIGN KEY (trick_id_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CB46B9EE8 ON media (trick_id_id)');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EF717C8DA');
        $this->addSql('DROP INDEX IDX_D8F0A91EF717C8DA ON trick');
        $this->addSql('ALTER TABLE trick CHANGE group_name_id group_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E2F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E2F68B530 ON trick (group_id_id)');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAA76ED395');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAB281BE2E');
        $this->addSql('DROP INDEX IDX_659DF2AAA76ED395 ON chat');
        $this->addSql('DROP INDEX IDX_659DF2AAB281BE2E ON chat');
        $this->addSql('ALTER TABLE chat ADD user_id_id INT NOT NULL, ADD trick_id_id INT NOT NULL, DROP user_id, DROP trick_id');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAB46B9EE8 FOREIGN KEY (trick_id_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AA9D86650F ON chat (user_id_id)');
        $this->addSql('CREATE INDEX IDX_659DF2AAB46B9EE8 ON chat (trick_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AA9D86650F');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAB46B9EE8');
        $this->addSql('DROP INDEX IDX_659DF2AA9D86650F ON chat');
        $this->addSql('DROP INDEX IDX_659DF2AAB46B9EE8 ON chat');
        $this->addSql('ALTER TABLE chat ADD user_id INT NOT NULL, ADD trick_id INT NOT NULL, DROP user_id_id, DROP trick_id_id');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AAA76ED395 ON chat (user_id)');
        $this->addSql('CREATE INDEX IDX_659DF2AAB281BE2E ON chat (trick_id)');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CB46B9EE8');
        $this->addSql('DROP INDEX IDX_6A2CA10CB46B9EE8 ON media');
        $this->addSql('ALTER TABLE media CHANGE trick_id_id trick_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CB281BE2E ON media (trick_id)');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E2F68B530');
        $this->addSql('DROP INDEX IDX_D8F0A91E2F68B530 ON trick');
        $this->addSql('ALTER TABLE trick CHANGE group_id_id group_name_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EF717C8DA FOREIGN KEY (group_name_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91EF717C8DA ON trick (group_name_id)');
    }
}
