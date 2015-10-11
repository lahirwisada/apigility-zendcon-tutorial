<?php
namespace Conference\V1\Rest\Speaker;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;

class SpeakerResourceFactory
{
    public function __invoke($services)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new SpeakerEntity());

        $mapper = new SpeakerMapper(new TableGateway(
            'speakers',
            $services->get('conference'),
            null,
            $resultSet
        ));

        return new SpeakerResource($mapper);
    }
}
