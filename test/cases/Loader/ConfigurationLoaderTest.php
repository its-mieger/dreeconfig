<?php
	use DreeConfig\Loader\Compiler\ConfigurationCompiler;
	use DreeConfig\Loader\ConfigurationLoader;
	use DreeConfig\Loader\Reader\DreeConfigReader;

	include_once(__DIR__ . '/../TestCase.php');

	class ConfigurationLoaderTest extends TestCase
	{
		public function testConstruct() {

			$configSource = file_get_contents(__DIR__ . '/../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);

			$cmp = new ConfigurationCompiler(array('shop' => 2, 'lang' => 'en'));

			$loader = new ConfigurationLoader($reader, array(), $cmp);

			$this->assertEquals(array('shop' => 2, 'lang' => 'en'), $loader->getParameters());
		}

		public function testGetConfiguredValuesDefault() {

			$configSource = file_get_contents(__DIR__ . '/../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			$loader = new ConfigurationLoader($reader, array());

			$values = $loader->getConfiguredValues();

			$this->assertEquals(3, count($values));
			$this->assertEquals(false, $values['paypal.api']);
			$this->assertEquals('paypal@tecedo.de', $values['paypal.classic.username']);
			$this->assertEquals('password', $values['paypal.classic.password']);
		}

		public function testGetConfiguredValuesParameters() {

			$configSource = file_get_contents(__DIR__ . '/../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			$loader = new ConfigurationLoader($reader, array('shop' => 2, 'lang' => 'en'));

			$values = $loader->getConfiguredValues();

			$this->assertEquals(3, count($values));
			$this->assertEquals(false, $values['paypal.api']);
			$this->assertEquals('paypal2@tecedo.de', $values['paypal.classic.username']);
			$this->assertEquals('password2', $values['paypal.classic.password']);
		}

		public function testGetConfiguredValuesInstance() {

			$configSource = file_get_contents(__DIR__ . '/../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);

			$cmp = new ConfigurationCompiler(array('shop' => 2, 'lang' => 'en'));

			$loader = new ConfigurationLoader($reader, array(), $cmp);

			$values = $loader->getConfiguredValues();

			$this->assertEquals(3, count($values));
			$this->assertEquals(false, $values['paypal.api']);
			$this->assertEquals('paypal2@tecedo.de', $values['paypal.classic.username']);
			$this->assertEquals('password2', $values['paypal.classic.password']);
		}
	}