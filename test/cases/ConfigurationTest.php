<?php

	use DreeConfig\Configuration;
	use DreeConfig\Loader\ConfigurationLoader;

	include_once(__DIR__ . '/TestCase.php');

	class ConfigurationTest extends TestCase
	{
		public function testGet() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			$this->assertEquals('paypal@tecedo.de', $c->get('paypal.classic.username'));
		}

		public function testGetNotExisting() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			try {
				$c->get('paypal.classic.notexisting');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\InvalidConfigurationPathException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testGetDefault() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			$this->assertEquals('paypal@tecedo.de', $c->getDefault('paypal.classic.username', 'asd'));
		}

		public function testGetDefaultNotExisting() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			$this->assertEquals('asd', $c->getDefault('paypal.classic.notexist', 'asd'));
		}

		public function testSetDefaultEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setDefaultEnvironment($c);

			$this->assertEquals($c, Configuration::getDefaultEnvironment());

			Configuration::setDefaultEnvironment(null);
			$this->assertNull(Configuration::getDefaultEnvironment());
		}

		public function testSetNamedEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setNamedEnvironment('named', $c);

			$this->assertEquals($c, Configuration::getEnvironmentByName('named'));

			Configuration::setNamedEnvironment('named', null);
			try {
				$this->assertNull(Configuration::getEnvironmentByName('named'));
				$this->assertFalse(true);
			}
			catch (\DreeConfig\ConfigurationNotExistsException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testGetValueDefaultEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setDefaultEnvironment($c);

			$this->assertEquals('paypal@tecedo.de', Configuration::getValue('paypal.classic.username'));

			Configuration::setDefaultEnvironment(null);
			$this->assertNull(Configuration::getDefaultEnvironment());
		}

		public function testGetValueNamedEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setNamedEnvironment('name2', $c);

			$this->assertEquals('paypal@tecedo.de', Configuration::getValue('paypal.classic.username', 'name2'));

			Configuration::setNamedEnvironment('name2', null);
			try {
				$this->assertNull(Configuration::getEnvironmentByName('name2'));
				$this->assertFalse(true);
			}
			catch (\DreeConfig\ConfigurationNotExistsException $ex) {
				$this->assertFalse(false);
			}
		}


		public function testGetDefaultValueNamedEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setNamedEnvironment('name2', $c);

			$this->assertEquals('paypal@tecedo.de', Configuration::getDefaultValue('paypal.classic.username', 'x', 'name2'));

			Configuration::setNamedEnvironment('name2', null);
			try {
				$this->assertNull(Configuration::getEnvironmentByName('name2'));
				$this->assertFalse(true);
			}
			catch (\DreeConfig\ConfigurationNotExistsException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testGetDefaultValueNamedEnvironmentNotExisting() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setNamedEnvironment('name2', $c);

			$this->assertEquals('x', Configuration::getDefaultValue('paypal.classic.notexist', 'x', 'name2'));

			Configuration::setNamedEnvironment('name2', null);
			try {
				$this->assertNull(Configuration::getEnvironmentByName('name2'));
				$this->assertFalse(true);
			}
			catch (\DreeConfig\ConfigurationNotExistsException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testGetDefaultValueDefaultEnvironment() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setDefaultEnvironment($c);

			$this->assertEquals('paypal@tecedo.de', Configuration::getDefaultValue('paypal.classic.username', 'x'));

			Configuration::setDefaultEnvironment(null);
			$this->assertNull(Configuration::getDefaultEnvironment());
		}

		public function testGetDefaultValueDefaultEnvironmentNotExisting() {
			$rdr = new \DreeConfig\Loader\Reader\DreeConfigReader(file_get_contents(__DIR__ . '/../data/dree_config_reader_test.yaml'));


			$c = new Configuration(new ConfigurationLoader($rdr, array()));
			Configuration::setDefaultEnvironment($c);

			$this->assertEquals('x', Configuration::getDefaultValue('paypal.classic.notexist', 'x'));

			Configuration::setDefaultEnvironment(null);
			$this->assertNull(Configuration::getDefaultEnvironment());
		}
	}