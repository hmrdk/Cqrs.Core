<?php
namespace Cqrs\Core\Exception;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * @FLOW3\Proxy(false)
 */
class NoAggregateFoundException extends \Exception {}
?>