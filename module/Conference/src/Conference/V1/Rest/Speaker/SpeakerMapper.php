<?php
namespace Conference\V1\Rest\Speaker;

use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;

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
        $rowset = $this->table->select(['id' => $speakerId]);
        return $rowset->current();
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
