<?php
namespace Conference\V1\Rest\Talk;

use Conference\V1\Rest\Speaker\SpeakerMapper;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;

class TalkMapperFactory
{
    public function __invoke($services)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new TalkEntity());

        return new TalkMapper(new TableGateway(
            'talks',
            $services->get('conference'),
            null,
            $resultSet
        ), $services->get(SpeakerMapper::class));
    }
}
