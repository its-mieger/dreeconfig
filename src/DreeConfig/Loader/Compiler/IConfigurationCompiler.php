<?php

	namespace DreeConfig\Loader\Compiler;

	use DreeConfig\Loader\Reader\IConfigurationReader;

	interface IConfigurationCompiler
	{
		/**
		 * Compiles a set configuration values
		 * @param IConfigurationReader $reader The reader to read configuration values from
		 * @return array The compiled configuration values as on dimensional associative array
		 */
		public function compileConfiguration(IConfigurationReader $reader);

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters();
	}