<?php
namespace DoctrineTelemetry\Backtrace\Query;

class LazyOneToOneQuery extends AbstractBacktraceQuery
{
    protected $_nextQuery;

    public function __construct(BacktraceQueryInterface $lastQuery = null)
    {
        parent::__construct($lastQuery);
        $this->_nextQuery = new CalleeQuery($this);
    }

    public function matchObject($object)
    {
        return $object instanceof \Doctrine\ORM\Persisters\BasicEntityPersister;
    }

    public function matchFunction($function)
    {
        return $function === 'loadOneToOneEntity';
    }

    public function matchFound(array $line)
    {
        $this->_matchBuilder->setClassMapping(reset($line['args']));
    }

    public function matchBack(array $line)
    {
        $this->_matchBuilder->setOrigin($line);
    }

    public function nextQuery()
    {
        return $this->_nextQuery;
    }
}