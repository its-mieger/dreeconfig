<?php

	namespace DreeConfig;

	/**
	 * Thrown if an accessed configuration path is invalid.
	 */
	class InvalidConfigurationPathException extends \Exception {

		protected $path;
		protected $fixtures;

		public function __construct($path, $fixtures = array(), $message = "", $code = 0, \Exception $previous = null) {

			$this->path = $path;
			$this->fixtures = $fixtures;

			if (empty($message)) {
				$message = 'Could not find configuration path "' . $path . '"';
			}

			parent::__construct($message, $code, $previous);
		}

		/**
		 * Gets the fixtures describing the environment the path is invalid in
		 * @return array The fixtures
		 */
		public function getFixtures() {
			return $this->fixtures;
		}

		/**
		 * Gets the invalid path
		 * @return string The invalid path
		 */
		public function getPath() {
			return $this->path;
		}



	}