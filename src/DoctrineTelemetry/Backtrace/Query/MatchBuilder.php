<?php
namespace DoctrineTelemetry\Backtrace\Query;

class MatchBuilder
{
    protected $_classMapping;

    protected $_origin;

    public function setClassMapping(array $classMapping)
    {
        $this->_classMapping = $classMapping;
    }

    public function setOrigin(array $origin)
    {
        $this->_origin = $origin;
    }

    public function getMatch()
    {
        if ($this->_origin && $this->_classMapping) {
            return new Match($this->_origin, $this->_classMapping);
        }
    }
}