<?php
namespace DoctrineTelemetry\Backtrace\Query;

class AbstractBacktraceQuery implements BacktraceQueryInterface
{
    protected $_lastQuery;

    protected $_matchBuilder;

    public function __construct(BacktraceQueryInterface $lastQuery = null)
    {
        $this->_lastQuery = $lastQuery;
        $this->_matchBuilder = new MatchBuilder();
    }

    public function matchFile($file)
    {
        return true;
    }

    public function matchLine($line)
    {
        return true;
    }

    public function matchObject($object)
    {
        return true;
    }

    public function matchFunction($function)
    {
        return true;
    }

    public function matchClass($class)
    {
        return true;
    }

    public function matchType($type)
    {
        return true;
    }

    public function matchArgs(array $args)
    {
        return true;
    }

    public function visit(array $line)
    {
    }

    public function matchFound(array $line)
    {
        if ($this->lastQuery()) {
            $this->lastQuery()->matchBack($line);
        }
    }

    public function matchBack(array $line)
    {
    }

    public function nextQuery()
    {
    }

    public function lastQuery()
    {
        return $this->_lastQuery;
    }

    public function getMatch()
    {
        return $this->_matchBuilder->getMatch();
    }

    public function __clone()
    {
        $this->_matchBuilder = clone $this->_matchBuilder;
    }
}
