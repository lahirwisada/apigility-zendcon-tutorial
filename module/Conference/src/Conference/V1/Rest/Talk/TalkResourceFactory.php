<?php
namespace Conference\V1\Rest\Talk;

class TalkResourceFactory
{
    public function __invoke($services)
    {
        return new TalkResource($services->get(TalkMapper::class));
    }
}
