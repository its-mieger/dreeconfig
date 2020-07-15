<?php

	use DreeConfig\Loader\Reader\PathSegment;

	include_once(__DIR__ . '/../../TestCase.php');

	class PathSegmentTest extends TestCase {


		public function testParseSegmentSimple() {

			$ps = PathSegment::parseString('simpleNode');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentSimpleEmpty() {

			try {
				PathSegment::parseString('');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\Loader\Reader\InvalidPathSegmentException $ex) {
				$this->assertFalse(false);
			}

			try {
				PathSegment::parseString('()');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\Loader\Reader\InvalidPathSegmentException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testParseSegmentSimpleInvalidCharacter() {

			try {
				PathSegment::parseString('simple$');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\Loader\Reader\InvalidPathSegmentException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testParseSegmentWithEmptyParameter() {

			$ps = PathSegment::parseString('simpleNode()');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array(), $ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithParameterEmpty() {

			$ps = PathSegment::parseString('simpleNode(g=)');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('g' => ''), $ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithInvalidParameter() {

			try {
				PathSegment::parseString('simpleNode{=}');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\Loader\Reader\InvalidPathSegmentException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testParseSegmentWithSingleOption() {

			$ps = PathSegment::parseString('simpleNode{name = asd}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('name' => 'asd'), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithSingleParameter() {

			$ps = PathSegment::parseString('simpleNode(name = asd)');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('name' => 'asd'), $ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithMultipleParameters() {

			$ps = PathSegment::parseString('simpleNode(name = asd, test = 67)');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('name' => 'asd', 'test' => 67),$ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithBooleanParameter() {

			$ps = PathSegment::parseString('simpleNode(name)');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('name' => true), $ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithMixedBooleanParameter() {

			$ps = PathSegment::parseString('simpleNode(test=67, name, x=9, y)');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('test' => 67, 'name' => true, 'x' => 9, 'y' => true), $ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}


		public function testParseSegmentWithEmptyOptions() {

			$ps = PathSegment::parseString('simpleNode{}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array(), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithOptionEmpty() {

			$ps = PathSegment::parseString('simpleNode{g=}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('g' => ''), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithInvalidOption() {

			try {
				PathSegment::parseString('simpleNode{=}');
				$this->assertFalse(true);
			}
			catch (\DreeConfig\Loader\Reader\InvalidPathSegmentException $ex) {
				$this->assertFalse(false);
			}
		}

		public function testParseSegmentWithMultipleOptions() {

			$ps = PathSegment::parseString('simpleNode{name = asd , test = 67}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('name' => 'asd', 'test' => 67), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithBooleanOption() {

			$ps = PathSegment::parseString('simpleNode{name}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('name' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentWithMixedBooleanOptions() {

			$ps = PathSegment::parseString('simpleNode{test=67, name, x=9, y}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('test' => 67, 'name' => true, 'x' => 9, 'y' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentParameterOptionsEmpty() {
			$ps = PathSegment::parseString('simpleNode(){}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentParameterOptions() {
			$ps = PathSegment::parseString('simpleNode(asd=8, name){x,y=0, z}');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('asd' => 8, 'name' => true), $ps->getParameters());
			$this->assertEquals(array('x' => true, 'y' => 0, 'z' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParsePathSimple() {
			$ps = PathSegment::parseString('simpleNode1.simpleNode2');

			$this->assertEquals('simpleNode1', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEmpty($ps->getParsingOptions());

			$this->assertEquals('simpleNode2', $ps->getNext()->getKey());
			$this->assertEmpty($ps->getNext()->getParameters());
			$this->assertEmpty($ps->getNext()->getParsingOptions());
			$this->assertEmpty($ps->getNext()->getNext());
		}

		public function testParsePathParameterOptions() {
			$ps = PathSegment::parseString('simpleNode1(asd=8, name){x,y=0, z}.simpleNode2(j=1){d = 0}.end');

			$this->assertEquals('simpleNode1', $ps->getKey());
			$this->assertEquals(array('asd' => 8, 'name' => true), $ps->getParameters());
			$this->assertEquals(array('x' => true, 'y' => 0, 'z' => true), $ps->getParsingOptions());

			$this->assertEquals('simpleNode2', $ps->getNext()->getKey());
			$this->assertEquals(array('j' => 1), $ps->getNext()->getParameters());
			$this->assertEquals(array('d' => 0), $ps->getNext()->getParsingOptions());

			$this->assertEquals('end', $ps->getNext()->getNext()->getKey());
			$this->assertEmpty($ps->getNext()->getNext()->getNext());
		}

		public function testParseSegmentDefault() {

			$ps = PathSegment::parseString('simpleNode*');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('default' => true),$ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentDefaultParameters() {

			$ps = PathSegment::parseString('simpleNode(id=1, test)*');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('id' => 1, 'test' => true), $ps->getParameters());
			$this->assertEquals(array('default' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentDefaultOptions() {

			$ps = PathSegment::parseString('simpleNode{id=1, test}*');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEmpty($ps->getParameters());
			$this->assertEquals(array('id' => 1, 'test' => true, 'default' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentDefaultParametersOptions() {

			$ps = PathSegment::parseString('simpleNode(x=1, y){id=1, test}*');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('x' => 1, 'y' => true), $ps->getParameters());
			$this->assertEquals(array('id' => 1, 'test' => true, 'default' => true), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}

		public function testParseSegmentDefaultParametersOptionsOverwrite() {

			$ps = PathSegment::parseString('simpleNode(x=1, y){default=false, test}*');

			$this->assertEquals('simpleNode', $ps->getKey());
			$this->assertEquals(array('x' => 1, 'y' => true), $ps->getParameters());
			$this->assertEquals(array('test' => true, 'default' => false), $ps->getParsingOptions());
			$this->assertEmpty($ps->getNext());
		}
	}