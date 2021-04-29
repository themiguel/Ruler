<?php
	namespace Ruler\Parser;

	use Ruler\Grammar\Grammar;
	use Ruler\Grammar\Production;

	use Ruler\Lexer\Lexer;

	class Parser{
		/**
		 * The grammar that will be used
		 * @var Grammar
		 */
		protected $grammar;

		public function __construct(Grammar $grammar){
			# Initialize the parser
			$this->grammar = $grammar;
		}

		public function build(string $input): void{
			# Get the tokens of the input
			$lexer = new Lexer();
			$tokens = $lexer->tokenize($input);

			# The list of nodes
			# Convert all the tokens into nodes
			$nodes = array_map(function($tok){ return new Node($tok); }, $tokens);

			# Finished flag
			$finished = false;

			# Loop until we are finished
			while( $finished === false ){
				# Set the finished flag
				$finished = true;

				/**
				 * Loop through the grammar
				 * @var Production $prod
				 */
				foreach($this->grammar as $prod){
					# Check if the production matches
					if( $prod->match($nodes) ){
						echo 'Found a match<br>';
						echo "<pre>", print_r($prod, true), "</pre>";
						echo "<pre>", print_r($nodes, true), "</pre>";
						exit;
					}
				}
			}

//			echo "<pre>", print_r($nodes, true), "</pre>";
		}
	}