<?php
namespace Conference\V1\Rest\Talk;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;

class TalkResourceFactory
{
    public function __invoke($services)
    {
        $resultSet = new HydratingResultSet();
        $resultSet->setObjectPrototype(new TalkEntity());

        return new TalkResource(new TalkMapper(new TableGateway(
            'talks',
            $services->get('conference'),
            null,
            $resultSet
        )));
    }
}
