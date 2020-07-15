<?php
	use DreeConfig\Loader\ValueParser\RawValueParser;

	include_once(__DIR__ . '/../../TestCase.php');

	class RawValueParserTest extends TestCase
	{
		public function testParse() {
			$vp = new RawValueParser();

			$this->assertEquals('string', $vp->parse('string', array()));
			$this->assertEquals(array('asd' => 2), $vp->parse(array('asd' => 2), array()));
		}
	}