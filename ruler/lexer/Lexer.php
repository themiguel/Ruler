<?php
	namespace Ruler\Lexer;

	use \Exception;
	use Ruler\Lexer\Tokens\Quotes;
	use Ruler\Lexer\Xtring\Xtring;

	use Ruler\Lexer\Tokens\Identifier;
	use Ruler\Lexer\Tokens\Number;
	use Ruler\Lexer\Tokens\Symbol;

	class Lexer{
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
				if( $xtring->isAlphabet() ){
					# Add the character
					$token = $xtring->current();

					# Loop through the alphanumeric values
					while( $xtring->isAlphanumeric(true) && $xtring->next() ){
						# Add the token
						$token .= $xtring->current();
					}

					# Create the token
					$tokens[] = new Identifier($token);
				}
				else if( $xtring->isSymbol() ){
					# Add the symbol
					$token = $xtring->current();

					# Loop as long as we have symbols
					while( $xtring->isSymbol(true) && $xtring->next() ){
						# Add the token
						$token .= $xtring->current();
					}

					# Create the token
					$tokens[] = new Symbol($token);
				}
				else if( $xtring->isDigit() || $xtring->is('.') ){
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
						# Invalid float
						throw new Exception('Lexer: invalid numeric value `'.$token.'`');
					}

					# Create the token
					$tokens[] = new Number($token);
				}
				else if( $xtring->is('"') ){
					# The current token
					$token = '';

					# Check the peek character for empty string
					if( $xtring->is('"', true) ){
						# Got an empty quotes
						# Add an empty quotes
						$tokens[] = new Quotes('');

						# Go to the next token
						$xtring->next();
					}
					else{
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
							throw new Exception('Lexer: Missing closing quotes.');
						}

						# Go to the next quotes
						$xtring->next();

						# Create the string token
						$tokens[] = new Quotes($token);
					}
				}
			} while( $xtring->next() );

			# Return the list of tokens
			return $tokens;
		}
	}