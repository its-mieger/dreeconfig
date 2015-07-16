<?php

	namespace DreeConfig\Loader\Reader;

	/**
	 * Represents a configured value
	 * @package DreeConfig\Loader\Reader
	 */
	class ConfigurationValue implements IConfigurationValue
	{

		/** @var  PathSegment */
		protected $path;
		/** @var  mixed */
		protected $value;


		/**
		 * Creates a new instance
		 * @param PathSegment $path The configuration value's instance
		 * @param mixed $value The value
		 */
		public function __construct(PathSegment $path, $value) {
			$this->path  = $path;
			$this->value = $value;
		}

		/**
		 * Gets the path for the configuration value
		 * @return PathSegment The root path segment
		 */
		public function getPath() {
			return $this->path;
		}

		/**
		 * Gets the configured value
		 * @return mixed The configured value
		 */
		public function getValue() {
			return $this->value;
		}


	}