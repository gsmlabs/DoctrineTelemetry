<?php
namespace DoctrineTelemetry\Backtrace\Query;

interface BacktraceQueryInterface
{
    public function visit(array $line);

    public function matchFile($file);

    public function matchLine($line);

    public function matchObject($object);

    public function matchFunction($function);

    public function matchClass($class);

    public function matchType($type);

    public function matchArgs(array $args);

    public function matchFound(array $line);

    public function matchBack(array $line);

    public function nextQuery();

    public function lastQuery();
}