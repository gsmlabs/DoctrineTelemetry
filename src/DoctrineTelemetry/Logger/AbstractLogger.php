<?php
namespace DoctrineTelemetry\Logger;

use Doctrine\DBAL\Logging\SQLLogger;

/**
 * Convenience class that handles how messages are outputted (dumped).
 * 
 * @author Adam Brodziak <adam@globalsportsmedia.com>
 */
abstract class AbstractLogger implements SQLLogger
{
    private $_dumper;
    
    /**
     * Passes a message to dumper, which should handle it (i.e. print).
     * 
     * @param string $message
     */
    public function dump($message)
    {
        $dumper = $this->getDumper();
        $dumper($message);
    }
    
    private function getDumper() {
        if (!isset($this->_dumper)) {
            $this->setDumper($this->getDefaultDumper());
        }
        return $this->_dumper;
    }
    
    /**
     * Default dumper is just an echo wrapped in closure.
     * 
     * It's a convenience function to provide more config options.
     */
    protected function getDefaultDumper() {
        return function($message) { echo $message; };
    }
    
    /**
     * Sets dumper, which must be a callable.
     * @param callable $dumper
     * @throws RuntimeException When param is not callable.
     */
    public function setDumper($dumper) {
        if (is_callable($dumper)) {
            $this->_dumper = $dumper;
        } else {
            throw new RuntimeException('Expected callable as param.');
        }
    }
}
