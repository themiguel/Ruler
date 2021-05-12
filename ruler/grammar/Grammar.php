<?php
	namespace Ruler\Grammar;

	use \Iterator;

	class Grammar implements Iterator{
		/**
		 * The list of productions
		 * @var array
		 */
		protected $prods;

		/**
		 * The separator character
		 * @var string
		 */
		protected $separator;

		/**
		 * Grammar constructor.
		 * Initializes the grammar
		 */
		public function __construct(){
			# Initialize the grammar
			$this->prods     = [];
			$this->separator = '';
		}

		/**
		 * Returns the current production
		 * @return Production
		 */
		public function current(): Production{
			# Return the current grammar
			return current($this->prods);
		}

		/**
		 * Returns the separator string
		 * @return string
		 */
		public function getSeparator(): string{
			# Return the separator
			return $this->separator;
		}

		/**
		 * Returns whether the grammar has a separator
		 * @return bool
		 */
		public function hasSeparator(): bool{
			# Return whether the grammar has a separator
			return empty($this->separator) === false;
		}

		/**
		 * Returns the current key
		 * @return string
		 */
		public function key(): string{
			# Return the current key
			return key($this->prods);
		}

		/**
		 * Moves the iterator to the next production
		 */
		public function next(): void{
			# Move the pointer to the next production
			next($this->prods);
		}

		/**
		 * Adds a new production rule to the grammar
		 * @param string $name       The name of the rule
		 * @param string $definition The definition of the production
		 */
		public function production(string $name, string $definition): void{
			# Check if the production has already been added
			if( isset($this->prods[$name]) === false ){
				# Create the production
				$this->prods[$name] = new Production($name);
			}

			# Add the rule to the production
			$this->prods[$name]->add($definition);
		}

		/**
		 * Rewinds the iterator
		 * Returns the first production
		 * @return Production
		 */
		public function rewind(): Production{
			# Reset the production pointer
			return reset($this->prods);
		}

		/**
		 * Sets the separator character
		 * Takes the first character of $char
		 * @param string $char The separator string
		 */
		public function setSeparator(string $char): void{
			# Set the separator
			$this->separator = $char[0];
		}

		/**
		 * Returns whether the current production is valid
		 * @return bool
		 */
		public function valid(): bool{
			# Return whether the production pointer is valid
			return key($this->prods) !== null;
		}
	}
