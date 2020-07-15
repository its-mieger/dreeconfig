<?php
	use DreeConfig\Loader\IConfigurationLoader;

	include_once(__DIR__ . '/../TestCase.php');

	class CachedConfigurationLoaderTest extends TestCase
	{
		public function testGetConfiguredValuesCached() {

			$arr = array(
				'k1' => 'v1',
				'k2' => 'v2',
			);

			$loader = new \DreeConfig\Loader\CachedConfigurationLoader(new OneTimeConfigLoader());

			// read to create cache
			$this->assertEquals($arr, $loader->getConfiguredValues());

			// now should be read from cache (loader only returns data on first load)
			$this->assertEquals($arr, $loader->getConfiguredValues());

		}

		public function testGetClearCache() {

			$arr = array(
				'k1' => 'v1',
				'k2' => 'v2',
			);

			$loader = new \DreeConfig\Loader\CachedConfigurationLoader(new OneTimeConfigLoader());

			// read to create cache
			$this->assertEquals($arr, $loader->getConfiguredValues());

			$loader->clearCache();

			// now should be be empty since cache is empty and loader only returns data on first load
			$this->assertEmpty($loader->getConfiguredValues());

		}
	}


	class OneTimeConfigLoader implements IConfigurationLoader {

		private $counter = 0;

		private $ts;

		public function __construct() {
			$this->ts = microtime(true);
		}


		/**
		 * Gets the configured values as one dimensional array
		 * @return array The array. Full path as keys.
		 */
		public function getConfiguredValues() {
			if ($this->counter++ == 0) {
				return array(
					'k1' => 'v1',
					'k2' => 'v2',
				);
			}

			return array();
		}

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters() {
			return array('ts' => $this->ts);
		}
	}