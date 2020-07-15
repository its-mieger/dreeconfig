<?php

	namespace DreeConfig\Loader\Reader;

	interface IConfigurationValue
	{

		/**
		 * Gets the path for the configuration value
		 * @return PathSegment The root path segment
		 */
		public function getPath();

		/**
		 * Gets the configured value
		 * @return mixed The configured value
		 */
		public function getValue();
	}