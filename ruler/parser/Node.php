<?php
	namespace Ruler\Parser;

	use Ruler\Lexer\Tokens\Token;

	class Node{
		/**
		 * The list of children nodes
		 * @var array
		 */
		protected $children;

		/**
		 * The name of the node
		 * @var string
		 */
		protected $name;

		/**
		 * The token of the node if any
		 * @var Token|null
		 */
		protected $token;

		public function __construct(string $name, ?Token $token = null){
			# Initialize the node
			$this->name     = $name;
			$this->token    = $token;
			$this->children = [];
		}

		public function addChild(Node $node): void{
			# Add the child node
			$this->children[] = $node;
		}

		public function getName(): string{
			# Return the name of the node
			return $this->name;
		}

		public function getToken(): Token{
			# Return the token if any
			return $this->token;
		}

		public function getTokenClass(): string{
			# Return the token class
			$cls = explode('\\', get_class($this->token));
			return array_pop($cls);
		}

		public function hasChildren(): bool{
			# Return whether the node has children
			return empty($this->children) === false;
		}

		public function hasToken(): bool{
			# Check if the token was set
			return is_null($this->token) === false;
		}
	}