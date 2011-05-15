<?php
namespace DoctrineTelemetry\Backtrace\Query;

class Match
{
    protected $_classMapping;

    protected $_origin;

    public function __construct(array $origin, array $classMapping)
    {
        $this->_origin = $origin;
        $this->_classMapping = $classMapping;
    }

    public function getOrigin($field = null)
    {
        if ($field === null) {
            return $this->_origin;
        }

        return isset($this->_origin[$field]) ? $this->_origin[$field] : '<empty>';
    }

    public function getClassMapping($field)
    {
        if ($field === null) {
            return $this->_classMapping;
        }

        return isset($this->_classMapping[$field]) ? $this->_classMapping[$field] : '<empty>';
    }
}