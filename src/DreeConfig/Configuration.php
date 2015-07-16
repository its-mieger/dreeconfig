<?php

	namespace DreeConfig;

	use DreeConfig\Loader\IConfigurationLoader;

	/**
	 * Implements a configuration environment allowing to read configured values. Fixtures describe the
	 * configuration values to use.
	 *
	 * Configured values may be read from an instance or statically using a default or named
	 * environment.
	 */
	class Configuration {

		/**
		 * @var Configuration The default environment
		 */
		protected static $defaultEnvironment = null;
		/**
		 * @var Configuration[] The named environments
		 */
		protected static $namedEnvironments = array();

		/**
		 * Sets the default environment for static usage
		 * @param Configuration|null $environment The default environment
		 */
		public static function setDefaultEnvironment(self $environment = null) {
			self::$defaultEnvironment = $environment;
		}

		/**
		 * Sets a named environment for static usage
		 * @param string $name The name for the environment
		 * @param Configuration|null $environment
		 */
		public static function setNamedEnvironment($name, self $environment = null) {
			self::$namedEnvironments[$name] = $environment;
		}

		/**
		 * Gets the default environment
		 * @return Configuration|null The default environment or null if not existing
		 */
		public static function getDefaultEnvironment() {
			try {
				return self::getEnvironmentByName(null);
			}
			catch(ConfigurationNotExistsException $ex) {
				return null;
			}
		}

		/**
		 * Gets the default or a named environment by name
		 * @param null|string $name The name of the environment to get. Null to get default environment
		 * @return Configuration The environment instance
		 * @throws ConfigurationNotExistsException Thrown if not existing
		 */
		public static function getEnvironmentByName($name = null) {
			if ($name == null) {
				// default environment
				if (self::$defaultEnvironment)
					return self::$defaultEnvironment;

				throw new ConfigurationNotExistsException(null, true);
			}
			else {
				// named environment
				if (self::$namedEnvironments[$name])
					return self::$namedEnvironments[$name];

				throw new ConfigurationNotExistsException($name, false);
			}
		}

		/**
		 * Gets a configured value. This is the static implementation of self::get()
		 * @param string $path The path of the value to get
		 * @param string|null $environmentName The name of the environment to get the value from. Null to use default environment
		 * @return mixed The value
		 * @throws ConfigurationNotExistsException Thrown if environment does not exist
		 * @throws InvalidConfigurationPathException Thrown if requested path does not exist
		 */
		public static function getValue($path, $environmentName = null) {
			return self::getEnvironmentByName($environmentName)->get($path);
		}

		/**
		 * Gets a configured value but returns a passed default value if not existing. This is the static implementation of self::getDefault()
		 * @param string $path The path of the value to get
		 * @param mixed $defaultValue The default value to get if invalid path
		 * @param string|null $environmentName The name of the environment to get the value from. Null to use default environment
		 * @throws ConfigurationNotExistsException
		 * @return mixed The value
		 */
		public static function getDefaultValue($path, $defaultValue = null, $environmentName = null) {
			return self::getEnvironmentByName($environmentName)->getDefault($path, $defaultValue);
		}


		/**
		 * @var array The environment data. Full path as key
		 */
		public $data = array();
		/**
		 * @var array The fixtures describing the environment
		 */
		public $parameters = array();


		/**
		 * Creates a new environment
		 * @param IConfigurationLoader $configurationLoader The loader for the environment values
		 */
		public function __construct(IConfigurationLoader $configurationLoader) {

			$this->parameters = $configurationLoader->getParameters();
			$this->data = $configurationLoader->getConfiguredValues();
		}


		/**
		 * Gets the parameters describing the environment
		 * @return array The parameters
		 */
		public function getParameters() {
			return $this->getParameters();
		}

		/**
		 * Gets a configured value
		 * @param string $path The path of the value to get
		 * @return mixed The value
		 * @throws InvalidConfigurationPathException Thrown if requested path does not exist
		 */
		public function get($path) {
			if (!array_key_exists($path, $this->data))
				throw new InvalidConfigurationPathException($path, $this->parameters);

			return $this->data[$path];
		}

		/**
		 * Gets a configured value but returns a passed default value if not existing
		 * @param string $path The path of the value to get
		 * @param mixed $defaultValue The default value to get if invalid path
		 * @return mixed The value
		 */
		public function getDefault($path, $defaultValue = null) {
			if (!array_key_exists($path, $this->data))
				return $defaultValue;

			return $this->data[$path];
		}

	}