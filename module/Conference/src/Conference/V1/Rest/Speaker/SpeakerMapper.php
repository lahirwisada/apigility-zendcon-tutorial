<?php
namespace Conference\V1\Rest\Speaker;

use Conference\V1\Rest\Talk\TalkMapper;
use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Adapter\DbTableGateway;

class SpeakerMapper
{
    protected $table;
    protected $talkMapper;

    public function __construct(TableGateway $table, TalkMapper $talkMapper)
    {
        $this->table      = $table;
        $this->talkMapper = $talkMapper;
    }

    public function getAllSpeakers()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        return new SpeakerCollection($dbTableGatewayAdapter);
    }

    public function getSpeakersByTalk($talkId)
    {
        $sql    = $this->table->getSql();
        $select = $sql->select();
        $select
            ->from('speakers')
            ->join('talks_speakers', 'talks_speakers.speaker_id = speakers.id')
            ->where(['talks_speakers.talk_id' => $talkId]);

        $paginatorAdapter = new DbSelect(
            $select,
            $this->table->adapter,
            $this->table->getResultSetPrototype()
        );
        return new SpeakerCollection($paginatorAdapter);
    }

    public function getSpeaker($speakerId)
    {
        $rowset  = $this->table->select(['id' => $speakerId]);
        $speaker = $rowset->current();
        $speaker->talks = $this->talkMapper->getTalksBySpeaker($speakerId);
        return $speaker;
    }

    public function addSpeaker(array $speaker)
    {
        try {
            $this->table->insert($speaker);
        } catch (Exception $e) {
            return false;
        }

        $rowset = $this->table->select(['id' => $this->table->lastInsertValue]);

        return $rowset->current();
    }

    public function updateSpeaker($id, array $speaker)
    {
        try {
            $this->table->update($data, ['id' => $id]);
        } catch (Exception $e) {
            return false;
        }

        $rowset = $this->table->select(['id' => $id]);
        return $rowset->current();
    }

    public function deleteSpeaker($id)
    {
        try {
            $result = $this->table->delete(['id' => $id]);
        } catch (Exception $e) {
            return false;
        }
        return ($result > 0);
    }
}
