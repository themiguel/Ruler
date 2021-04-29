<?php
	namespace Ruler\Parser;

	use Ruler\Lexer\Tokens\Token;

	class Node{
		protected $children;

		protected $token;

		protected $type;

		public function __construct(Token $token){
			$this->token    = $token;
			$this->children = [];
			$this->type     = 'node';
		}

		public function getType(): string{
			# Return the type of the node
			return $this->type;
		}

		public function setType(string $type): void{
			# Set the type
			$this->type = $type;
		}

		public function getToken(): Token{
			return $this->token;
		}

		public function getTokenClass(): string{
			# Return the token class
			$cls = explode('\\', get_class($this->token));
			return array_pop($cls);
		}
	}