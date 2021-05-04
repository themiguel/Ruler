<?php
	namespace Ruler\Parser;

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
		 * The value on the node
		 * @var mixed
		 */
		protected $value;

		/**
		 * Node constructor.
		 * Initializes the node
		 * @param string $name  The name of the node
		 * @param null   $value The value of the node, if any
		 */
		public function __construct(string $name, $value = null){
			# Initialize the node
			$this->name     = $name;
			$this->value    = $value;
			$this->children = [];
		}

		/**
		 * Adds a new child node to the tree
		 * @param Node $node The child node to add
		 */
		public function addChild(Node $node): void{
			# Add the child node
			$this->children[] = $node;
		}

		/**
		 * Returns the child node based on index
		 * @param int $idx The index of the child node
		 * @return Node
		 */
		public function getChild(int $idx): Node{
			# Return child node
			return $this->children[$idx];
		}

		/**
		 * Returns the total number of child nodes
		 * @return int
		 */
		public function getChildrenCount(): int{
			# Return the count of children
			return count($this->children);
		}

		/**
		 * Returns the name of the node
		 * @return string
		 */
		public function getName(): string{
			# Return the name of the node
			return $this->name;
		}

		/**
		 * Returns the value of the node, or null if none
		 * @return mixed|null
		 */
		public function getValue(){
			# Return the value of the node
			return $this->value;
		}

		/**
		 * Returns whether the node has any children or not
		 * @return bool
		 */
		public function hasChildren(): bool{
			# Return whether the node has children
			return empty($this->children) === false;
		}

		/**
		 * Returns whether the node has a value or not
		 * @return bool
		 */
		public function hasValue(): bool{
			# Check if the token was set
			return is_null($this->value) === false;
		}
	}