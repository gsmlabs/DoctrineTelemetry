<?php
namespace DoctrineTelemetry\Logger;

use Doctrine\DBAL\Logging\SQLLogger;

class QueryTypeLogger extends AbstractLogger implements SQLLogger
{
    private $_queryTypes = array(
                            'SELECT' => 0,
                            'INSERT' => 0,
                            'UPDATE' => 0,
                            'DELETE' => 0,
                            'MISC'   => 0,
                           );

    public function startQuery($sql, array $params = null, array $types = null)
    {
        $type = strtoupper(substr(trim($sql), 0, 6));
        $type = isset($this->_queryTypes[$type]) ? $type : 'MISC';
        ++$this->_queryTypes[$type];
    }

    public function stopQuery()
    {
    }

    public function getQueryTypes()
    {
        return $this->_queryTypes;
    }

    public function __destruct()
    {
        $this->dump(print_r($this->getQueryTypes(), 1));
    }
}
