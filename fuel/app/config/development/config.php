<?php

return [
	'profiling'  => false,

	/**
	 * Logging Threshold.  Can be set to any of the following:
	 *
	 * Fuel::L_NONE
	 * Fuel::L_ERROR
	 * Fuel::L_WARNING
	 * Fuel::L_DEBUG
	 * Fuel::L_INFO
	 * Fuel::L_ALL
	 */
	'log_threshold' => Fuel::L_ALL,

	// allows you to create a custom error handler for Monolog
	// THIS WILL SEND ERRORS TO STDOUT, VISIBLE VIA `docker-compose log phpfpm`
	// doesnt work below php7.2
	'log_handler_factory'   => function($locals, $level){ return new \Monolog\Handler\ErrorLogHandler(); },

	'locale' => 'en_US.UTF-8', // PHP set_locale()
];
