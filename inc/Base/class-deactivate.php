<?php 

/**
* PLUGIN DEACTIVATION CLASS
*/
class MPFPopularPostDeactivate
{
	function __construct()
	{
		# code...
	}

	public static function deactivate() {

		flush_rewrite_rules();

	}

}
