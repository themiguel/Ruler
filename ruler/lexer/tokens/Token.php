<?php
	namespace Ruler\Lexer\Tokens;

	class Token{
		/**
		 * The value of the token
		 * @var mixed
		 */
		protected $value;

		/**
		 * Token constructor.
		 * Initializes the token
		 * @param mixed $value The value of the token
		 */
		public function __construct($value){
			# Initialize the token
			$this->value = $value;
		}

		/**
		 * Returns the name of the token
		 * @return string
		 */
		final public function getName(): string{
			# Return the name of the class
			# This is some hacky way...
			return substr(get_class($this), strripos(get_class($this), '\\') + 1);
		}

		/**
		 * Returns the value on the token
		 * @return mixed
		 */
		public function getValue(){
			# Return the value
			return $this->value;
		}
	}