<?php

	namespace DreeConfig\Loader\Reader;


	class PathSegment {


		public static function parseString($string) {

			// there might be more than one segment
			$segments = explode('.', $string, 2);


			// parse parts of curr path segment
			$currKey = preg_replace('/^([^\\(\\{\\s\\*]+)(.*)$/', '$1' , trim($segments[0]));
			$paramList = trim(preg_replace('/^([^\\(]*)((\\()([^\\)]*)(\\))(.*))?$/', '$4' , $segments[0]));
			$optionList = trim(preg_replace('/^([^\\{]*)((\\{)([^\\}]*)(\\})(.*))?$/', '$4', $segments[0]));
			$isDefault = preg_match('/[^\\*]+\\*$/', $segments[0]);

			// check for validity
			if (!preg_match('/^[A-Za-z0-9_\\-]+?$/', $currKey))
				throw new InvalidPathSegmentException($segments[0]);


			// parse parameters
			$currParameters = array();
			if (!empty($paramList)) {
				$paramDefinitions = explode(',', $paramList);

				foreach($paramDefinitions as $currDef) {
					$nv = explode('=', $currDef, 2);

					if (trim($nv[0]) == '')
						throw new InvalidPathSegmentException($segments[0]);


					if (count($nv) == 2) {
						switch(trim($nv[1])) {
							case 'true':
								$currParameters[trim($nv[0])] = true;
								break;
							case 'false':
								$currParameters[trim($nv[0])] = false;
								break;
							default:
								$currParameters[trim($nv[0])] = trim($nv[1]);
						}
					}
					else {
						$currParameters[trim($nv[0])] = true;
					}
				}
			}


			// parse parsing options
			$currOptions = array();
			if ($isDefault)
				$currOptions['default'] = true;
			if (!empty($optionList)) {
				$optionDefinitions = explode(',', $optionList);

				foreach ($optionDefinitions as $currDef) {
					$nv = explode('=', $currDef, 2);

					if (trim($nv[0]) == '')
						throw new InvalidPathSegmentException($segments[0]);

					if (count($nv) == 2) {
						switch (trim($nv[1])) {
							case 'true':
								$currOptions[trim($nv[0])] = true;
								break;
							case 'false':
								$currOptions[trim($nv[0])] = false;
								break;
							default:
								$currOptions[trim($nv[0])] = trim($nv[1]);
						}
					}
					else {
						$currOptions[trim($nv[0])] = true;
					}
				}
			}

			// next segment?
			$currNext = null;
			if (count($segments) == 2)
				$currNext = self::parseString($segments[1]);


			return new self($currKey, $currParameters, $currOptions, $currNext);
		}


		protected $key;
		protected $parameters;
		protected $parsingOptions;
		protected $next;


		protected function __construct($key, array $parameters, array $parsingOptions, self $next = null) {
			$this->key            = $key;
			$this->next           = $next;
			$this->parameters     = $parameters;
			$this->parsingOptions = $parsingOptions;
		}

		/**
		 * Gets the current path segment key
		 * @return string The current path segment key
		 */
		public function getKey() {
			return $this->key;
		}

		/**
		 * Gets the following path segment
		 * @return PathSegment The following path segment
		 */
		public function getNext() {
			return $this->next;
		}

		/**
		 * Gets the parameters for the current path segment
		 * @return array The parameters for the current path segment
		 */
		public function getParameters() {
			return $this->parameters;
		}

		/**
		 * Gets the parsing options for the current path segment
		 * @return array The parsing options for the current path segment
		 */
		public function getParsingOptions() {
			return $this->parsingOptions;
		}

		/**
		 * Gets the leaf of the path
		 * @return PathSegment The leaf
		 */
		public function getLeaf() {
			if (empty($this->next))
				return $this;

			return $this->next->getLeaf();
		}

		/**
		 * Gets the path as string (only key names)
		 * @return string The path as string
		 */
		public function pathToString() {
			return $this->key . ($this->next ? '.' . $this->next->pathToString() : '');
		}

	}