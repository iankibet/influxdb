<?php
namespace Iankibet\InfluxDb\Dto;
class InfluxDbPoint
{
    protected $measurement;
    protected $tags;
    protected $fields;
    protected $time;
    public function __construct($measurement, $tags, $fields, $time = null)
    {
        $this->measurement = $measurement;
        $this->tags = $tags;
        $this->fields = $fields;
        $this->time = $time ?? time();
    }
    public function getMeasurement()
    {
        return $this->measurement;
    }
    public function getTags()
    {
        return $this->tags;
    }
    public function getFields()
    {
        return $this->fields;
    }
    public function getTime()
    {
        return $this->time;
    }
    public function toArray()
    {
        return [
            'name' => $this->measurement,
            'tags' => $this->tags,
            'fields' => $this->fields,
            'time' => $this->time
        ];
    }

}
