<?php
namespace DoctrineTelemetry\Backtrace\Matcher;

class Matcher
{
    /**
     * @var \DoctrineTelemetry\Backtrace\Query\BacktraceQueryInterface[]
     */
    protected $_queries;

    public function __construct(array $queries)
    {
        $this->_queries = $queries;
    }

    public function match(array $backtrace)
    {
        $queries = $this->_deepCopyQueries();

        foreach ($backtrace as $line) {
            $queryStack = $queries;

            /** @var $query \DoctrineTelemetry\Backtrace\Query\BacktraceQueryInterface */
            while ($query = array_pop($queryStack)) {

                $query->visit($line);

                /** Let the trace line decide which match methods are called */
                foreach (array_keys($line) as $key) {
                    $method = 'match' . $key;

                    /** If query returns false, jump to the next query */
                    if (!$query->{$method}($line[$key])) {
                        continue 2;
                    }
                }

                $query->matchFound($line);

                $nextQuery = $query->nextQuery();
                if ($nextQuery) {
                    $this->_queries[] = $nextQuery;
                    $queryStack[] = $nextQuery;
                }
            }
        }

        $matches = array_map(function($query) { return $query->getMatch();}, $queries);
        $matches = array_filter($matches);

        return $matches;
    }

    protected function _deepCopyQueries()
    {
        $queries = array();
        foreach ($this->_queries as $query) {
            $queries[] = clone $query;
        }
        return $queries;
    }
}