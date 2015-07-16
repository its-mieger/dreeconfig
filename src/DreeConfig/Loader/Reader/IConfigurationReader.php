<?php

	namespace DreeConfig\Loader\Reader;

	interface IConfigurationReader
	{
		/**
		 * Reads the configured values
		 * @return IConfigurationValue[] The configured values
		 */
		public function readConfigurationValues();
	}