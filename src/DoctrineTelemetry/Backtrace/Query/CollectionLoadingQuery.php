<?php
namespace DoctrineTelemetry\Backtrace\Query;

class CollectionLoadingQuery extends AbstractBacktraceQuery
{
    protected $_nextQuery;

    public function __construct(BacktraceQueryInterface $lastQuery = null)
    {
        parent::__construct($lastQuery);
        $this->_nextQuery = new CalleeQuery($this);
    }

    public function matchObject($object)
    {
        return $object instanceof \Doctrine\ORM\PersistentCollection;
    }

    public function matchFunction($function)
    {
        return $function === 'initialize';
    }

    public function matchFound(array $line)
    {
        parent::matchFound($line);
        $this->_matchBuilder->setClassMapping($line['object']->getMapping());
    }

    public function matchBack(array $line)
    {
        parent::matchBack($line);
        $this->_matchBuilder->setOrigin($line);
    }

    public function nextQuery()
    {
        return $this->_nextQuery;
    }
}
