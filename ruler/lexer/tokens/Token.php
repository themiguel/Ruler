<?php
	namespace Ruler\Lexer\Tokens;

	class Token{
		protected $value;

		public function __construct($value){
			# Initialize the token
			$this->value = $value;
		}

		public function getValue(){
			# Return the value
			return $this->value;
		}
	}