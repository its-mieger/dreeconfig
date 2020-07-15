<?php

	use DreeConfig\Loader\Reader\DreeConfigReader;

	include_once(__DIR__ . '/../../TestCase.php');

	class ConfigurationCompilerTest extends TestCase
	{
		public function testCompileDefault() {

			$configSource = file_get_contents(__DIR__ . '/../../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			$cmp = new \DreeConfig\Loader\Compiler\ConfigurationCompiler();
			$compiled = $cmp->compileConfiguration($reader);

			$this->assertEquals(3, count($compiled));
			$this->assertEquals(false, $compiled['paypal.api']);
			$this->assertEquals('paypal@tecedo.de', $compiled['paypal.classic.username']);
			$this->assertEquals('password', $compiled['paypal.classic.password']);
		}

		public function testCompileParameters() {

			$configSource = file_get_contents(__DIR__ . '/../../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			// parse with configured params (one optional)
			$cmp      = new \DreeConfig\Loader\Compiler\ConfigurationCompiler(array('shop' => 2, 'lang' => 'en'));
			$compiled = $cmp->compileConfiguration($reader);

			$this->assertEquals(3, count($compiled));
			$this->assertEquals(false, $compiled['paypal.api']);
			$this->assertEquals('paypal2@tecedo.de', $compiled['paypal.classic.username']);
			$this->assertEquals('password2', $compiled['paypal.classic.password']);

		}

		public function testCompileParametersOptional() {

			$configSource = file_get_contents(__DIR__ . '/../../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			// parse with configured params (one optional)
			$cmp      = new \DreeConfig\Loader\Compiler\ConfigurationCompiler(array('shop' => 2, 'lang' => 'en'));
			$compiled = $cmp->compileConfiguration($reader);

			$this->assertEquals(3, count($compiled));
			$this->assertEquals(false, $compiled['paypal.api']);
			$this->assertEquals('paypal2@tecedo.de', $compiled['paypal.classic.username']);
			$this->assertEquals('password2', $compiled['paypal.classic.password']);
		}



		public function testCompileParametersFallbackToDefault() {

			$configSource = file_get_contents(__DIR__ . '/../../../data/configuration_compiler_test_1.yaml');

			$reader = new DreeConfigReader($configSource);


			// parse with configured params (fall back to default)
			$cmp      = new \DreeConfig\Loader\Compiler\ConfigurationCompiler(array('shop' => 3));
			$compiled = $cmp->compileConfiguration($reader);

			$this->assertEquals(3, count($compiled));
			$this->assertEquals(false, $compiled['paypal.api']);
			$this->assertEquals('paypal@tecedo.de', $compiled['paypal.classic.username']);
			$this->assertEquals('password', $compiled['paypal.classic.password']);
		}

		public function testCompileParametersNestedFallbackToDefault() {

			$configSource = file_get_contents(__DIR__ . '/../../../data/configuration_compiler_test_2.yaml');

			$reader = new DreeConfigReader($configSource);


			// parse with configured params (fall back to default)
			$cmp      = new \DreeConfig\Loader\Compiler\ConfigurationCompiler(array('x' => 2, 'y' => 3));
			$compiled = $cmp->compileConfiguration($reader);

			$this->assertEquals(1, count($compiled));
			$this->assertEquals('g', $compiled['root.level1.level2']);
		}
	}


