<?php
	namespace Ruler\Grammar;

	use \Iterator;

	class Grammar implements Iterator{
		protected $prods;

		public function __construct(){
			# Initialize the grammar
			$this->prods = [];
		}

		public function production(string $name, string $definition): void{
			# Check if the production has already been added
			if( isset($this->prods[$name]) === false ){
				# Create the production
				$this->prods[$name] = new Production();
			}

			# Add the rule to the production
			$this->prods[$name]->add($definition);
		}

		public function current(): Production{
			# Return the current grammar
			return current($this->prods);
		}

		public function next(): void{
			# Move the pointer to the next production
			next($this->prods);
		}

		public function key(): string{
			# Return the current key
			return key($this->prods);
		}

		public function valid(): bool{
			# Return whether the production pointer is valid
			return key($this->prods) !== null;
		}

		public function rewind(): Production{
			# Reset the production pointer
			return reset($this->prods);
		}
	}
