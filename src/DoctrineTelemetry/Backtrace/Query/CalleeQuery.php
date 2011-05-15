<?php
namespace DoctrineTelemetry\Backtrace\Query;

class CalleeQuery extends AbstractBacktraceQuery
{
    protected $_matched = false;

    public function matchClass($class)
    {
        if ($this->_matched) {
            return false;
        }

        return strpos($class, 'Doctrine') === false;
    }

    public function matchFound(array $line)
    {
        $this->_matched = true;
        parent::matchFound($line);
    }
}