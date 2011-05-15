<?php
namespace DoctrineTelemetry\Logger;

use Doctrine\DBAL\Logging\SQLLogger;

class TelemetryLogger implements SQLLogger
{
    private $_loggers = array();

    public function __construct()
    {
        $this->_loggers['queryType'] = new QueryTypeLogger();
        $this->_loggers['lazyloading'] = new LazyLoadingLogger();
    }

    public function startQuery($sql, array $params = null, array $types = null)
    {
        foreach ($this->_loggers as $logger) {
            $logger->startQuery($sql, $params, $types);
        }
    }

    public function stopQuery()
    {
        foreach ($this->_loggers as $logger) {
            $logger->stopQuery();
        }
    }

    public function __destruct()
    {
        error_log(print_r($this->_loggers['queryType']->getQueryTypes(), 1));
    }
}
