<?php
namespace Conference\V1\Rest\Speaker;

use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Sql\Sql;
use Conference\V1\Rest\Talk\TalkEntity;
use Conference\V1\Rest\Talk\TalkCollection;
use Zend\Stdlib\Hydrator\ArraySerializable;

class SpeakerMapper
{
    protected $table;

    public function __construct(TableGateway $table)
    {
        $this->table = $table;
    }

    public function getAllSpeakers()
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->table);
        return new SpeakerCollection($dbTableGatewayAdapter);
    }

    public function getSpeaker($speakerId)
    {
        $rowset  = $this->table->select(['id' => $speakerId]);
        $speaker = $rowset->current();

        // get the spakers from the talks_speakers table
        $sql = new Sql($this->table->adapter);
        $select = $sql->select();
        $select
            ->from('talks')
            ->join('talks_speakers', 'talks_speakers.talk_id = talks.id')
            ->where(['talks_speakers.speaker_id' => $speakerId]);

        // build the SpeakerCollection based on $select
        $resultSet = new HydratingResultSet(
            new ArraySerializable(),
            new TalkEntity()
        );
        $paginatorAdapter = new DbSelect($select, $this->table->adapter, $resultSet);
        $speakers->talks = new TalkCollection($paginatorAdapter);

        return $speakers;
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
