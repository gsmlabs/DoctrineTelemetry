<?php
namespace DoctrineTelemetry\Logger;

use Doctrine\DBAL\Logging\SQLLogger;

class LazyLoadingLogger extends AbstractLogger implements SQLLogger
{
    protected $_matcher;

    public function __construct()
    {
        $this->_matcher = new \DoctrineTelemetry\Backtrace\Matcher\Matcher(
            array(
             new \DoctrineTelemetry\Backtrace\Query\LazyCollectionQuery(),
             new \DoctrineTelemetry\Backtrace\Query\LazyOneToOneQuery(),
            )
        );
    }

    public function startQuery($sql, array $params = null, array $types = null)
    {
        foreach ($this->_matcher->match(debug_backtrace()) as $match) {
            $this->dump(self::formatMessage($match));
        }
    }

    /**
     * @param \DoctrineTelemetry\Backtrace\Query\Match $match
     */
    protected static function formatMessage($match) {
        return (
            sprintf(
                '%s:%d, %s%s%s(): Lazy loading detected of %s (from %s->%s)'.PHP_EOL,
                $match->getOrigin('file'),
                $match->getOrigin('line'),
                $match->getOrigin('class'),
                $match->getOrigin('type'),
                $match->getOrigin('function'),
                $match->getClassMapping('targetEntity'),
                $match->getClassMapping('sourceEntity'),
                $match->getClassMapping('fieldName')
            )
        );
    }

    public function stopQuery()
    {
    }
}
