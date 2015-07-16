<?php

	namespace DreeConfig\Loader\Reader;

	use Symfony\Component\Yaml\Yaml;

	class DreeConfigReader implements IConfigurationReader
	{

		protected $source;

		/**
		 * Creates a new instance
		 * @param string $source The configuration source to read
		 */
		public function __construct($source) {
			$this->source = $source;
		}

		/**
		 * Reads the configured values
		 * @throws ConfigReadException
		 * @throws InvalidPathSegmentException
		 * @return IConfigurationValue[] The configured values
		 */
		public function readConfigurationValues() {
			try {
				$yArray = Yaml::parse($this->source);

				if (!is_array($yArray))
					throw new ConfigReadException('Configuration is a literal not an object');

				$config = $this->flattenConfigArray($yArray);

				$ret = array();
				foreach ($config as $path => $value) {

					$ret[] = new ConfigurationValue(PathSegment::parseString($path), $value);

				}

				return $ret;
			}
			catch (\Exception $ex) {
				throw new ConfigReadException('Could not parse configuration', 0, $ex);
			}
		}


		/**
		 * This function converts a multidimensional YAML array to a one dimensional configuration array
		 * @param array $array The multidimensional YAML array
		 * @param string $prefix Only for internal usage
		 * @return array The one dimensional configuration array
		 */
		protected function flattenConfigArray($array, $prefix = '') {
			$result = array();
			foreach ($array as $key => $value) {
				$key = preg_replace('/^([^\\(]+[\\)])/', '($1', $key);
				$key = preg_replace('/^([^\\{]+[\\}])/', '{$1', $key);

				if (is_array($value)) {
					$result = $result + $this->flattenConfigArray($value, preg_replace('/\\.(\\(|\\{)/', '$1', $prefix . $key . '.'));
				}
				else {
					$result[preg_replace('/\\.(\\(|\\{)/', '$1', $prefix . $key)] = $value;
				}
			}

			return $result;
		}


	}