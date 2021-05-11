<?php
	namespace Ruler;

	use Ruler\Environment\Environment;
	use Ruler\Grammar\Grammar;
	use Ruler\Parser\Parser;
	use Ruler\System\System;
	use \Exception;

	class Ruler{
		/**
		 * The environment used
		 * @var Environment
		 */
		protected $environment;

		/**
		 * The grammar used
		 * @var Grammar
		 */
		protected $grammar;

		/**
		 * Parser object
		 * @var Parser
		 */
		protected $parser;

		/**
		 * The system for evaluation
		 * @var System
		 */
		protected $system;

		/**
		 * Ruler constructor.
		 * Initializes the ruler
		 */
		public function __construct(){
			# Initialize the ruler
			$this->grammar     = new Grammar();
			$this->parser      = new Parser($this->grammar);
			$this->environment = new Environment();
			$this->system      = new System($this->environment);
		}

		/**
		 * Adds a list of values to the environment
		 * @param array $values The values to add, indexed by name
		 */
		public function add(array $values): void{
			# Add the values to the environment
			$this->environment->add($values);
		}

		/**
		 * Adds a new evaluator onto the system
		 * @param string $target The target node
		 * @param string $class  The evaluator class to add
		 * @throws \ReflectionException
		 */
		public function evaluator(string $target, string $class): void{
			# Create the reflection class
			$cls = new \ReflectionClass($class);

			# Add the evaluator
			$this->system->add($target, $cls->newInstance($this->system));
		}

		/**
		 * Loads a grammar configuration file
		 * @param string $file The file to load
		 * @throws Exception
		 */
		public function load(string $file): void{
			# Check the file
			if( is_file($file) === false ){
				# Cannot load
				throw new Exception('Ruler: cannot load `' . $file . '`, is not file');
			}

			# Create a closure for loading
			$closure = (function($grammar) use ($file){
				# Load the file
				require_once($file);
			});

			# Run the closure
			$closure($this->grammar);
		}

		/**
		 * Executes a given rule
		 * Returns the value of the parsed rule
		 * Throws exception if the rule could not be executed
		 * @param string $rule the rule to execute
		 * @return array
		 * @throws Exception
		 */
		public function exec(string $rule): array{
			# Parse the rule
			$nodes = $this->parser->parse($rule);

			# The list of nodes
			$lst = [];

			# Loop through the nodes
			foreach( $nodes as $node ){
				# Evaluate the node
				$lst[] = $this->system->evaluate($node);
			}

			# Return the list of nodes
			return $lst;
		}
	}