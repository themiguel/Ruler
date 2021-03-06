<?php
	namespace Ruler\Parser;

	use Ruler\Grammar\Grammar;
	use Ruler\Grammar\Production;

	use Ruler\Lexer\Lexer;
	use Ruler\Lexer\Tokens\Token;

	class Parser{
		/**
		 * The grammar that will be used
		 * @var Grammar
		 */
		protected $grammar;

		/**
		 * Parser constructor.
		 * Initializes the constructor
		 * @param Grammar $grammar The grammar to parse with
		 */
		public function __construct(Grammar $grammar){
			# Initialize the parser
			$this->grammar = $grammar;
		}

		/**
		 * Parses a input to an AST
		 * Returns a list of parent nodes of the AST
		 * @param string $input The input to parse
		 * @return array
		 * @throws \Exception
		 */
		public function parse(string $input): array{
			# Check if there's a separator
			if( $this->grammar->hasSeparator() ){
				# Get the inputs
				$inputs = array_map('trim', explode($this->grammar->getSeparator(), $input));
			}
			else{
				# Use the entire input
				$inputs = [$input];
			}

			# The root nodes
			$roots = [];

			# Create the lexer
			$lexer  = new Lexer();

			# Loop through the inputs
			foreach( $inputs as $input ){
				# Get the tokens of the input
				$tokens = $lexer->tokenize($input);

				# The list of nodes
				# Convert all the tokens into nodes
				$nodes = array_map(function(Token $token){
					return new Node($token->getName(), $token->getValue());
				}, $tokens);

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
					foreach( $this->grammar as $prod ){
						# Check if the production matches
						# Find and replace
						if( $prod->reduce($nodes) ){
							# Did a replace
							$finished = false;
						}
					}
				}

				# Add the root node into the roots list
				$roots[] = $nodes[0];
			}

			# Return the roots
			return $roots;
		}
	}