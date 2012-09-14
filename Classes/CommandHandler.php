<?php
namespace Cqrs\Core;
use TYPO3\FLOW3\Annotations as FLOW3;

interface CommandHandler {

	/**
	 * @abstract
	 * @param Command $command
	 * @return void
	 */
	public function handle($command);

}
?>