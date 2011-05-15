<?php
namespace DoctrineTelemetry\Logger;

use Doctrine\DBAL\Logging\SQLLogger;

class LazyLoadingLogger implements SQLLogger
{
    protected $_matcher;

    public function __construct()
    {
        $this->_matcher = new \DoctrineTelemetry\Backtrace\Matcher\Matcher(
            array(
             new \DoctrineTelemetry\Backtrace\Query\CollectionLoadingQuery()
            )
        );
    }

    public function startQuery($sql, array $params = null, array $types = null)
    {
        foreach ($this->_matcher->match(debug_backtrace()) as $match) {
            error_log(
                sprintf(
                    '%s:%d: Lazy loading detected of a collection of %s (from %s->%s) %s%s%s',
                    $match->getOrigin('file'),
                    $match->getOrigin('line'),
                    $match->getClassMapping('targetEntity'),
                    $match->getClassMapping('sourceEntity'),
                    $match->getClassMapping('fieldName'),
                    $match->getOrigin('class'),
                    $match->getOrigin('type'),
                    $match->getOrigin('function')
                )
            );
        }
    }

    public function stopQuery()
    {
    }
}
