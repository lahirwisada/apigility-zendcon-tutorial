<?php
namespace Conference\V1\Rest\Speaker;

use Conference\V1\Rest\Talk\TalkMapper;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;

class SpeakerMapperFactory
{
    public function __invoke($services)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new SpeakerEntity());

        return new SpeakerMapper(new TableGateway(
            'speakers',
            $services->get('conference'),
            null,
            $resultSet
        ), $services->get(TalkMapper::class));
    }
}
