<?php
namespace Conference\V1\Rest\Talk;

use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Sql;
use Conference\V1\Rest\Speaker\SpeakerEntity;
use Conference\V1\Rest\Speaker\SpeakerCollection;
use Zend\Stdlib\Hydrator\ArraySerializable;

class TalkMapper
{
    protected $table;

    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    public function getAllTalks()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        return new TalkCollection($dbTableGatewayAdapter);
    }

    public function getTalk($talkId)
    {
        $rowset = $this->table->select(['id' => $talkId]);
        $talk   = $rowset->current();

        // get the spakers from the talks_speakers table
        $sql = new Sql($this->table->adapter);
        $select = $sql->select();
        $select
            ->from('speakers')
            ->join('talks_speakers', 'talks_speakers.speaker_id = speakers.id')
            ->where(['talks_speakers.talk_id' => $talkId]);

        // build the SpeakerCollection based on $select
        $resultSet = new HydratingResultSet(
            new ArraySerializable(),
            new SpeakerEntity()
        );
        $paginatorAdapter = new DbSelect($select, $this->table->adapter, $resultSet);
        $talk->speakers = new SpeakerCollection($paginatorAdapter);

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
