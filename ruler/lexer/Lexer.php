<?php
	namespace Ruler\Lexer;

	use \Exception;
	use Ruler\Lexer\Tokens\Quotes;
	use Ruler\Lexer\Xtring\Xtring;

	use Ruler\Lexer\Tokens\Token;
	use Ruler\Lexer\Tokens\Identifier;
	use Ruler\Lexer\Tokens\Number;
	use Ruler\Lexer\Tokens\Symbol;

	class Lexer{
		/**
		 * Extracts the identifier from the xtring
		 * @param Xtring $xtring The lexer string
		 * @return Identifier
		 */
		protected function extractIdentifier(Xtring $xtring){
			# Create the token string
			$token = $xtring->current();

			# Loop through the alphanumeric and _ values
			while( $xtring->regex('/[A-Za-z0-9_]/', true) && $xtring->next() ){
				# Add the token
				$token .= $xtring->current();
			}

			# Return the identifier
			return new Identifier($token);
		}

		/**
		 * Extracts the number from the xtring
		 * @param Xtring $xtring The lexer string
		 * @return Number|Token
		 */
		protected function extractNumber(Xtring $xtring){
			# The token
			$token = '';

			# Check the current character
			if( $xtring->is('.') ){
				# Add a zero
				$token .= '0';
			}

			# Add the current digit or dot
			$token .= $xtring->current();

			# Loop as long as we have digits
			while( ($xtring->isDigit(true) || $xtring->is('.', true)) && $xtring->next() ){
				# Add the token
				$token .= $xtring->current();
			}

			# Check the token
			if( is_numeric($token) === false ){
				# Return a token with the value
				return new Token($token);
			}

			# Return the number
			return new Number($token);
		}

		/**
		 * Extracts the quotes from the xtring
		 * @param Xtring $xtring The lexer string
		 * @return Quotes|Token
		 */
		protected function extractQuotes(Xtring $xtring){
			# The current token
			$token = '';

			# Check the peek character for empty string
			if( $xtring->is('"', true) ){
				# Go to the next token
				$xtring->next();

				# Return the empty quotes
				return new Quotes('');
			}

			# String is not empty
			# Loop until we find the next quote
			while( $xtring->is('"', true) === false && $xtring->next() ){
				# Add the token
				$token .= $xtring->current();
			}

			# Peek character should be a quote
			# Check to make make sure it is
			if( $xtring->is('"', true) === false ){
				# There was an error, either not ending the string
				# Return a simple token
				return new Token('"'.$token);
			}

			# Go to the next quotes
			$xtring->next();

			# Return the string token
			return new Quotes($token);
		}

		/**
		 * Extracts the symbol from the xtring
		 * @param Xtring $xtring The lexer string
		 * @return Symbol
		 */
		protected function extractSymbol(Xtring $xtring){
			# Add the symbol
			$token = $xtring->current();

			# Loop as long as we have symbols
			while( $xtring->isSymbol(true) && $xtring->next() ){
				# Add the token
				$token .= $xtring->current();
			}

			# Return the symbol
			return new Symbol($token);
		}

		/**
		 * Tokenize a given rule
		 * Return a list of token
		 * Throws an exception if rule couldn't be converted
		 * @param string $rule The rule to tokenize
		 * @return array
		 * @throws Exception
		 */
		public function tokenize(string $rule): array{
			# Create a xtring
			$xtring = new Xtring($rule);

			# The list of tokens
			$tokens = [];

			# Loop through the xtring
			do{
				# Check the current character
				if( $xtring->regex('/[A-Za-z_]/') ){
					# Extract the token
					$tokens[] = $this->extractIdentifier($xtring);
				}
				else if( $xtring->isSymbol() ){
					# Extract the symbol
					$tokens[] = $this->extractSymbol($xtring);
				}
				else if( $xtring->isDigit() || $xtring->is('.') ){
					# Extract the number
					$tokens[] = $this->extractNumber($xtring);
				}
				else if( $xtring->is('"') ){
					# Extract the quote
					$tokens[] = $this->extractQuotes($xtring);
				}
			} while( $xtring->next() );

			# Return the list of tokens
			return $tokens;
		}
	}