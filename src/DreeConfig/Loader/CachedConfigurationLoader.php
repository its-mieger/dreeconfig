<?php

	namespace DreeConfig\Loader;


	/**
	 * Configuration loader caching compiled configuration in file
	 * @package DreeConfig\Loader
	 */
	class CachedConfigurationLoader implements IConfigurationLoader
	{
		protected static $cacheDir = '/tmp/';

		/**
		 * Sets the directory for file cache
		 * @param string $cacheDir The cache directory
		 */
		public static function setCacheDir($cacheDir) {
			self::$cacheDir = $cacheDir;
		}

		/**
		 * Gets the directory for file cache
		 * @return string The directory for file cache
		 */
		public static function getCacheDir() {
			return self::$cacheDir;
		}


		/**
		 * @var IConfigurationLoader
		 */
		protected $fallbackLoader;

		private $cacheKey;


		/**
		 * Creates a new instance
		 * @param IConfigurationLoader $fallBackLoader The loader used if no cache hit
		 */
		public function __construct(IConfigurationLoader $fallBackLoader) {
			$this->fallbackLoader = $fallBackLoader;
		}

		/**
		 * Gets the configured values as one dimensional array
		 * @return array The array. Full path as keys.
		 */
		public function getConfiguredValues() {

			$values = $this->readFromCache();

			// read from fallback if no cache hit
			if (empty($values)) {
				$values = $this->fallbackLoader->getConfiguredValues();

				// write to cache
				$this->writeToCache($values);
			}

			return $values;
		}

		/**
		 * Gets the parameters for the configuration
		 * @return array The parameters values
		 */
		public function getParameters() {
			return $this->fallbackLoader->getParameters();
		}

		/**
		 * Clears the cache
		 */
		public function clearCache() {
			if (file_exists(self::getCacheDir() . $this->getCacheKey()))
				unlink(self::getCacheDir() . $this->getCacheKey());
		}


		/**
		 * Reads the configuration from cache
		 * @return array|null The configured values
		 */
		protected function readFromCache() {
			$fc = @file_get_contents(self::getCacheDir() . $this->getCacheKey());

			if (!empty($fc)) {
				$d = unserialize($fc);

				if (is_array($d))
					return $d;
			}

			return null;
		}

		/**
		 * Writes the configuration to cache
		 * @param array $configuredValues The configured values
		 */
		protected function writeToCache(array $configuredValues) {
			file_put_contents(self::getCacheDir() . $this->getCacheKey(), serialize($configuredValues));
		}

		/**
		 * Gets the key for caching the data of this instance
		 * @return string The cache key
		 */
		protected function getCacheKey() {

			if (!empty($this->cacheKey))
				return $this->cacheKey;

			$params = $this->fallbackLoader->getParameters();

			$this->cacheKey = 'dree_config_' . preg_replace('/[^A-z0-9]/', '_', get_class($this->fallbackLoader)) . '__' . sha1(serialize($params));

			return $this->cacheKey;
		}
	}