<?php

	namespace DreeConfig;

	/**
	 * Thrown if an accessed environment is does not exist
	 */
	class ConfigurationNotExistsException extends \Exception
	{

		protected $environmentName;
		protected $defaultEnvironment;

		public function __construct($environmentName, $defaultEnvironment = false, $message = "", $code = 0, \Exception $previous = null) {

			$this->environmentName = $environmentName;
			$this->defaultEnvironment = $defaultEnvironment;

			if (empty($message)) {
				if ($defaultEnvironment)
					$message = 'Default environment is not accessible';
				else
					$message = 'Environment "' . $environmentName . '" is not accessible';
			}

			parent::__construct($message, $code, $previous);
		}

		/**
		 * Gets if the default environment was tried to access
		 * @return boolean Tre if the default environment was tried to access
		 */
		public function isDefaultEnvironment() {
			return $this->defaultEnvironment;
		}

		/**
		 * Gets the name of the environment tried to access
		 * @return string|null The name of the environment tried to access
		 */
		public function getEnvironmentName() {
			return $this->environmentName;
		}




	}