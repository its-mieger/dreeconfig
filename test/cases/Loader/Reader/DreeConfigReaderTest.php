<?php

	use DreeConfig\Loader\Reader\ConfigReadException;
	use DreeConfig\Loader\Reader\DreeConfigReader;

	include_once(__DIR__ . '/../../TestCase.php');

	class DreeConfigReaderTest extends TestCase
	{
		public function testReadError() {
			$reader = new DreeConfigReader('asd');

			try {
				$reader->readConfigurationValues();
				$this->assertFalse(true);
			}
			catch (ConfigReadException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testRead() {
			$configSource = file_get_contents(__DIR__ . '/../../../data/dree_config_reader_test.yaml');


			$reader = new DreeConfigReader($configSource);


			$values = $reader->readConfigurationValues();

			// node 1
			$this->assertEquals('paypal@tecedo.de', $values[0]->getValue());
			$this->assertEquals('paypal', $values[0]->getPath()->getKey());
			$this->assertEquals('classic', $values[0]->getPath()->getNext()->getKey());
			$this->assertEquals(array('shop' => 1, 'lang' => 'de'), $values[0]->getPath()->getNext()->getParameters());
			$this->assertEquals(array('default' => true,), $values[0]->getPath()->getNext()->getParsingOptions());
			$this->assertEquals('username', $values[0]->getPath()->getNext()->getNext()->getKey());

			// node 2
			$this->assertEquals('password', $values[1]->getValue());
			$this->assertEquals('paypal', $values[1]->getPath()->getKey());
			$this->assertEquals('classic', $values[1]->getPath()->getNext()->getKey());
			$this->assertEquals(array('shop' => 1, 'lang' => 'de'), $values[1]->getPath()->getNext()->getParameters());
			$this->assertEquals(array('default' => true,), $values[1]->getPath()->getNext()->getParsingOptions());
			$this->assertEquals('password', $values[1]->getPath()->getNext()->getNext()->getKey());
			$this->assertEquals(array('crypt' => true,), $values[1]->getPath()->getNext()->getNext()->getParsingOptions());

			// node 3
			$this->assertEquals('paypal2@tecedo.de', $values[2]->getValue());
			$this->assertEquals('paypal', $values[2]->getPath()->getKey());
			$this->assertEquals('classic', $values[2]->getPath()->getNext()->getKey());
			$this->assertEquals(array('shop' => 2), $values[2]->getPath()->getNext()->getParameters());
			$this->assertEmpty($values[2]->getPath()->getNext()->getParsingOptions());
			$this->assertEquals('username', $values[2]->getPath()->getNext()->getNext()->getKey());

			// node 4
			$this->assertEquals('password2', $values[3]->getValue());
			$this->assertEquals('paypal', $values[3]->getPath()->getKey());
			$this->assertEquals('classic', $values[3]->getPath()->getNext()->getKey());
			$this->assertEquals(array('shop' => 2), $values[3]->getPath()->getNext()->getParameters());
			$this->assertEmpty($values[3]->getPath()->getNext()->getParsingOptions());
			$this->assertEquals('password', $values[3]->getPath()->getNext()->getNext()->getKey());
			$this->assertEquals(array('crypt' => true,), $values[3]->getPath()->getNext()->getNext()->getParsingOptions());
		}
	}