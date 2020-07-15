<?php

	namespace DreeConfig\Loader\Reader;

	use Exception;

	class InvalidPathSegmentException extends \Exception {

		protected $pathSegment;

		public function __construct($pathSegment, $message = "", $code = 0, Exception $previous = null) {

			$this->pathSegment = $pathSegment;

			if (empty($message))
				$message = 'Path segment "' .$pathSegment . '" is invalid.';

			parent::__construct($message, $code, $previous);
		}

		/**
		 * Gets the invalid path segment
		 * @return string The invalid path segment
		 */
		public function getPathSegment() {
			return $this->pathSegment;
		}




	}