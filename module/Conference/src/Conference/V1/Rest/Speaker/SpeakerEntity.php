<?php
namespace Conference\V1\Rest\Speaker;

class SpeakerEntity
{
    public $id;
    public $name;
    public $url;
    public $twitter;

    public function getArrayCopy()
    {
        return array(
            'id'      => $this->id,
            'name'    => $this->name,
            'url'     => $this->url,
            'twitter' => $this->twitter,
        );
    }

    public function exchangeArray(array $array)
    {
        foreach (['id', 'name', 'url', 'twitter'] as $key) {
            if (array_key_exists($key, $array)) {
                $this->{$key} = $array[$key];
            }
        }
    }
}
