<?php
namespace Conference\V1\Rest\Speaker;

class SpeakerEntity
{
    public $id;
    public $name;
    public $url;
    public $twitter;
    public $talks;

    public function getArrayCopy()
    {
        return array(
            'id'      => $this->id,
            'name'    => $this->name,
            'url'     => $this->url,
            'twitter' => $this->twitter,
            'talks'   => $this->talks,
        );
    }

    public function exchangeArray(array $array)
    {
        foreach (['id', 'name', 'url', 'twitter', 'talks'] as $key) {
            if (array_key_exists($key, $array)) {
                $this->{$key} = $array[$key];
            }
        }
    }
}
