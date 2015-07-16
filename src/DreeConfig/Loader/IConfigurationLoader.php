<?php

	namespace DreeConfig\Loader;

	interface IConfigurationLoader {

		/**
		 * Gets the configured values as one dimensional array
		 * @return array The array. Full path as keys.
		 */
		public function getConfiguredValues();

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters();
	}