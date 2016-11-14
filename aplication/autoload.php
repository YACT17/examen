<?php
function __autoload($className){
	require_once(ROOT."libs".DS.$className.".php");
}