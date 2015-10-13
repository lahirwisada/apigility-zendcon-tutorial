<?php
namespace Conference\V1\Rest\Talk;

class TalkEntity
{
    public $id;
    public $title;
    public $abstract;
    public $day;
    public $start_time;

    public function getArrayCopy()
    {
        return array(
            'id'         => $this->id,
            'title'      => $this->title,
            'abstract'   => $this->abstract,
            'day'        => $this->day,
            'start_time' => $this->start_time,
        );
    }

    public function exchangeArray(array $array)
    {
        foreach (['id', 'title', 'abstract', 'day', 'start_time'] as $key) {
            if (array_key_exists($key, $array)) {
                $this->{$key} = $array[$key];
            }
        }
    }
}
