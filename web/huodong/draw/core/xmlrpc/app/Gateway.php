<?php
define("AMFPHP_BASE", realpath(dirname(dirname(dirname(__FILE__)))) . "/");
require_once(AMFPHP_BASE . "shared/app/BasicGateway.php");
require_once(AMFPHP_BASE . "shared/util/MessageBody.php");
require_once(AMFPHP_BASE . "xmlrpc/app/Actions.php");

class Gateway extends BasicGateway
{
	function createBody()
	{
		$GLOBALS['amfphp']['encoding'] = 'xmlrpc';
		$body = & new MessageBody();
		$body->setValue($GLOBALS["HTTP_RAW_POST_DATA"]);
		return $body;
	}
	
	/**
	 * Create the chain of actions
	 */
	function registerActionChain()
	{
		$this->actions['deserialization'] = 'deserializationAction';
		$this->actions['classLoader'] = 'classLoaderAction';
		$this->actions['security'] = 'securityAction';
		$this->actions['exec'] = 'executionAction';
		$this->actions['debug'] = 'debugAction';
	}
}
?>