<?php
	namespace Ruler\Lexer\Xtring;

	/**
	 * Class Xtring
	 * Lexer String string
	 * @package Ruler\Lexer\Xtring
	 */
	class Xtring{
		/**
		 * The current position
		 * @var int
		 */
		protected $curr;

		/**
		 * The string length
		 * @var int
		 */
		protected $length;

		/**
		 * The string or xtring
		 * @var string
		 */
		protected $string;

		/**
		 * Xtring constructor.
		 * Initializes the string
		 * @param string $string The string value
		 * @param int    $start  The starting position
		 */
		public function __construct(string $string, int $start = 0){
			# Initialize the xtring
			$this->string = $string;
			$this->curr   = $start;
			$this->length = strlen($string);
		}

		/**
		 * Returns the current character
		 * @return string
		 */
		public function current(): string{
			# Return the current value
			return $this->string[$this->curr];
		}

		/**
		 * Returns the current character code
		 * @return int
		 */
		public function currentCode(): int{
			# Return the current code
			return mb_ord($this->string[$this->curr], 'utf-8');
		}

		public function is(string $char, bool $peek = false): bool{
			# Check the peek
			if( $peek ){
				# Use the peek
				return $char == $this->peek();
			}

			# Return whether the current matches the char
			return $char == $this->string[$this->curr];
		}

		/**
		 * Return whether the current or peek character is a letter
		 * @param bool $peek Whether the use peek or not
		 * @return bool
		 */
		public function isAlphabet(bool $peek = false): bool{
			# Get the current code
			$code = $peek ? $this->peekCode() : $this->currentCode();

			# Return whether the code is alphabet or not
			return ($code >= 65 && $code <= 90) || ($code >= 97 && $code <= 122);
		}

		/**
		 * Return whether the current or peek character is alphanumeric or not
		 * @param bool $peek Whether the use peek or not
		 * @return bool
		 */
		public function isAlphanumeric(bool $peek = false): bool{
			# Return whether we have a alphabet or digit
			return $this->isAlphabet($peek) || $this->isDigit($peek);
		}

		/**
		 * Returns whether the current character is a digit or not
		 * @param bool $peek Whether the check peek character or not
		 * @return bool
		 */
		public function isDigit(bool $peek = false): bool{
			# Get the current code
			$code = $peek ? $this->peekCode() : $this->currentCode();

			# Return whether the current code is a digit or not
			return ($code >= 48 && $code <= 57);
		}

		/**
		 * Returns whether the character is a symbol or not
		 * @param bool $peek Whether the check peek character or not
		 * @return bool
		 */
		public function isSymbol(bool $peek = false): bool{
			# Get the current character
			$char = $peek ? $this->peek() : $this->current();

			# Check if the character a symbol
			return in_array($char, ['{', '}', '(', ')', '>', '<', '=', ';', ':', '?', '+', '-', '*', '/']);
		}

		/**
		 * Goes to the next character
		 * Returns whether the xtring is valid or not
		 * @return bool
		 */
		public function next(): bool{
			# Increase the counter
			$this->curr++;

			# Return whether we are still valid
			return $this->curr < $this->length;
		}

		/**
		 * Returns the peek character
		 * Returns empty string if no peek is there
		 * @return string
		 */
		public function peek(): string{
			# Return the peek, if available
			return $this->curr + 1 < $this->length ? $this->string[$this->curr + 1] : '';
		}

		/**
		 * Return the peek character code
		 * Return 0 if no peek is there
		 * @return int
		 */
		public function peekCode(): int{
			# Return the peek code, if available
			return $this->curr + 1 < $this->length ? mb_ord($this->string[$this->curr + 1], 'utf-8') : 0;
		}

		/**
		 * Resets the counter value
		 * @param int $value The value to set it to
		 */
		public function reset(int $value = 0): void{
			# Set the current value
			$this->curr = $value;
		}

		/**
		 * Return whether the current position is less than length or not
		 * @return bool
		 */
		public function valid(): bool{
			# Return whether we are still valid
			return $this->curr < $this->length;
		}
	}