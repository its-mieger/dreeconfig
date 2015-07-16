<?php

	namespace DreeConfig\Loader;

	use DreeConfig\Loader\Compiler\ConfigurationCompiler;
	use DreeConfig\Loader\Compiler\IConfigurationCompiler;
	use DreeConfig\Loader\Reader\IConfigurationReader;

	/**
	 * Default configuration loader
	 * @package DreeConfig\Loader
	 */
	class ConfigurationLoader implements IConfigurationLoader
	{
		/**
		 * @var IConfigurationReader
		 */
		protected $reader;
		/**
		 * @var IConfigurationCompiler
		 */
		protected $compiler;


		/**
		 * Creates a new instance
		 * @param IConfigurationReader $reader The reader for reading the configuration
		 * @param array $parameters The parameters for compiling the read configuration. Only used if no compiler instance with specified parameters is passed
		 * @param IConfigurationCompiler $compiler The compiler for compiling the read configuration. If not passed, the default compiler with specified parameters is used
		 */
		public function __construct(IConfigurationReader $reader, array $parameters = array(), IConfigurationCompiler $compiler = null) {
			$this->reader = $reader;
			$this->compiler = ($compiler != null ? $compiler : new ConfigurationCompiler($parameters));
		}

		/**
		 * Gets the configured values as one dimensional array
		 * @return array The array. Full path as keys.
		 */
		public function getConfiguredValues() {

			return $this->compiler->compileConfiguration($this->reader);
		}

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters() {
			return $this->compiler->getParameters();
		}
	}