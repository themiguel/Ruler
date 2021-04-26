<?php
	namespace Ruler\Lexer;

	use Ruler\Lexer\Xtring\Xtring;

	use Ruler\Lexer\Tokens\Identifier;
	use Ruler\Lexer\Tokens\Number;
	use Ruler\Lexer\Tokens\Symbol;

	class Lexer{

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
					while( $xtring->next() && $xtring->isAlphanumeric() ){
						# Add the token
						$token .= $xtring->current();
					}

					# Create the token
					$tokens[] = new Identifier($token);
				}
				else if( $xtring->isSymbol() ){
					# Add the symbol
					$token = $xtring->current();

					# Check the peek character
					if( $xtring->isSymbol(true) ){
						# The peek is a symbol as well
						# Add the peek then go to the next
						$token .= $xtring->peek();
						$xtring->next();
					}

					# Create the token
					$tokens[] = new Symbol($token);
				}
				else if( $xtring->isDigit() ){
					# Add the current digit
					$token = $xtring->current();

					# Loop as long as we have digits
					while( $xtring->next() && $xtring->isDigit() ){
						# Add the token
						$token .= $xtring->current();
					}

					# Create the token
					$tokens[] = new Number($token);
				}
			} while( $xtring->next() );

			# Return the list of tokens
			return $tokens;
		}
	}