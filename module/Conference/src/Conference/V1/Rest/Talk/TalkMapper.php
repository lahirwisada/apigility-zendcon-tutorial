<?php
namespace Conference\V1\Rest\Talk;

use Exception;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbTableGateway;

class TalkMapper
{
    protected $adapter;

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
        return $rowset->current();
    }

    public function addTalk(array $talk)
    {
        try {
            $this->table->insert($talk);
        } catch (Exception $e) {
            return false;
        }
        $rowset = $this->table->select(array('id' => $this->table->lastInsertValue));
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
