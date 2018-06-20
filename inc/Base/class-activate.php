<?php 

/**
* PLUGIN ACTIVATION CLASS
*/
class MPFPopularPostActivate
{
	function __construct()
	{
		# code...
	}

	public static function activate() {

		flush_rewrite_rules();
	}
}
