<?php
namespace Conference\V1\Rest\Talk;

use Conference\V1\Rest\Speaker\SpeakerMapper;
use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Adapter\DbTableGateway;

class TalkMapper
{
    protected $speakerMapper;
    protected $table;

    public function __construct(TableGateway $table, SpeakerMapper $speakerMapper)
    {
        $this->table         = $table;
        $this->speakerMapper = $speakerMapper;
    }

    public function getAllTalks()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        return new TalkCollection($dbTableGatewayAdapter);
    }

    public function getTalksBySpeaker($speakerId)
    {
        $sql    = $this->table->getSql();
        $select = $sql->select();
        $select
            ->from('talks')
            ->join('talks_speakers', 'talks_speakers.talk_id = talks.id')
            ->where(['talks_speakers.speaker_id' => $speakerId]);

        $paginatorAdapter = new DbSelect(
            $select,
            $this->table->adapter,
            $this->table->getResultSetPrototype()
        );
        return new TalkCollection($paginatorAdapter);
    }

    public function getTalk($talkId)
    {
        $rowset = $this->table->select(['id' => $talkId]);
        $talk   = $rowset->current();
        $talk->speakers = $this->speakerMapper->getSpeakersByTalk($talkId);
        return $talk;
    }

    public function addTalk(array $talk)
    {
        try {
            $this->table->insert($talk);
        } catch (Exception $e) {
            return false;
        }
        $rowset = $this->table->select(['id' => $this->table->lastInsertValue]);
        return $rowset->current();
    }

    public function updateTalk($id, array $talk)
    {
        try {
            $this->table->update($talk, ['id' => $id]);
        } catch (Exception $e) {
            return false;
        }
        $rowset = $this->table->select(['id' => $id]);
        return $rowset->current();
    }

    public function deleteTalk($id)
    {
        try {
            $result = $this->table->delete(['id' => $id]);
        } catch (Exception $e) {
            return false;
        }
        return ($result > 0);
    }
}
