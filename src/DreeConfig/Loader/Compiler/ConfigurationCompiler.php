<?php

	namespace DreeConfig\Loader\Compiler;

	use DreeConfig\Loader\Reader\IConfigurationReader;
	use DreeConfig\Loader\Reader\PathSegment;
	use DreeConfig\Loader\ValueParser\IValueParser;
	use DreeConfig\Loader\ValueParser\RawValueParser;

	/**
	 * A compiler class for configurations
	 * @package DreeConfig\Loader\Compiler
	 */
	class ConfigurationCompiler implements IConfigurationCompiler
	{
		protected $parameters = array();
		protected $valueParser;

		/**
		 * Creates a new instance
		 * @param array $parameters The compilation parameters
		 * @param IValueParser $valueParser The parser for configuration values. If null value will be parsed raw
		 */
		public function __construct(array $parameters = array(), IValueParser $valueParser = null) {
			if ($valueParser == null)
				$valueParser = new RawValueParser();

			$this->parameters = $parameters;
			$this->valueParser = $valueParser;
		}


		/**
		 * Compiles a set configuration values
		 * @param IConfigurationReader $reader The reader to read configuration values from
		 * @return array The compiled configuration values as one dimensional associative array
		 */
		public function compileConfiguration(IConfigurationReader $reader) {
			$compiledValues = array();

			$values = $reader->readConfigurationValues();

			// read all default values
			foreach($values as $currValue) {
				if ($this->matchDefaultPath($currValue->getPath(), $this->parameters))
					$compiledValues[$currValue->getPath()->pathToString()] = $this->parseValue($currValue->getPath()->getLeaf()->getParsingOptions(), $currValue->getValue());
			}

			// read all values matching parameters to overwrite and complement default values
			foreach ($values as $currValue) {
				if ($this->matchPath($currValue->getPath(), $this->parameters))
					$compiledValues[$currValue->getPath()->pathToString()] = $this->parseValue($currValue->getPath()->getLeaf()->getParsingOptions(), $currValue->getValue());
			}

			return $compiledValues;
		}

		/**
		 * Parses a raw value using specified parsing options
		 * @param array $parsingOptions The parsing options
		 * @param mixed $rawValue The raw value
		 * @return mixed The parse value
		 */
		protected function parseValue(array $parsingOptions, $rawValue) {
			return $this->valueParser->parse($rawValue, $parsingOptions);
		}

		/**
		 * Checks if a specified path matches parameters
		 * @param PathSegment $path The path
		 * @param array $parameters The parameters
		 * @return bool True if matches. Else false
		 */
		protected function matchPath(PathSegment $path, array $parameters) {
			$pathParameters = $path->getParameters();

			foreach($pathParameters as $name => $expectedValue) {
				if (!array_key_exists($name, $parameters) || $parameters[$name] != $expectedValue)
					return false;
			}

			if ($path->getNext())
				return $this->matchPath($path->getNext(), $parameters);
			else
				return true;
		}

		/**
		 * Checks if a specified path matches parameters or default parsing option
		 * @param PathSegment $path The path
		 * @param array $parameters The parameters
		 * @return bool True if matches. Else false
		 */
		protected function matchDefaultPath(PathSegment $path, array $parameters) {
			$pathParameters = $path->getParameters();
			$parsingOptions = $path->getParsingOptions();

			foreach ($pathParameters as $name => $expectedValue) {
				if ((!array_key_exists($name, $parameters) || $parameters[$name] != $expectedValue) && empty($parsingOptions['default']))
					return false;
			}

			if ($path->getNext())
				return $this->matchDefaultPath($path->getNext(), $parameters);
			else
				return true;
		}

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters() {
			return $this->parameters;
		}
	}