<?php

	namespace DreeConfig\Loader\ValueParser;

	/**
	 * A value parser simply returning the raw value
	 * @package DreeConfig\Loader\ValueParse
	 */
	class RawValueParser implements IValueParser
	{

		/**
		 * Parses a specified value using specified parsing options
		 * @param mixed $value The input value
		 * @param array $parsingOptions The parsing options
		 * @return mixed The parsed value
		 */
		public function parse($value, array $parsingOptions) {
			return $value;
		}
	}