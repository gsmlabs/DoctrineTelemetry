DoctrineTelemetry
=================

Mission: Helps to debug issues when using Doctrine as an ORM

If you love minefields, just set `DoctrineTelemetry\Logger\TelemetryLogger` as your SQL logger in
`Doctrine\ORM\Configuration`

n+1 Issue Finding:
------------------

 - Detect lazy loading collections
 - Detect after-query loaded 1:1 relations


Queries:
--------
 - Detect duplicated queries
 - Sum how many queries of which type (SELECT, UPDATE, DELETE, ...) where executed


TODOs:
------
 - Third-party logger support (Zend Framework, Symfony, some web console)
 - Code, code, code