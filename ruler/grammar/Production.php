<?php
	namespace Ruler\Grammar;

	use Ruler\Parser\Node;

	class Production{
		/**
		 * The name of the production
		 * @var string
		 */
		protected $name;

		/**
		 * The list of rules
		 * @var array
		 */
		protected $rules;

		/**
		 * Production constructor.
		 * Initializes the production
		 * @param string $name The name of the production
		 */
		public function __construct(string $name){
			# Initialize the production
			$this->name  = $name;
			$this->rules = [];
		}

		/**
		 * Checks if any of the definitions matches against the nodes given
		 * Returns index of the which matched it, or -1 if none matched it
		 * @param array $nodes The list of nodes to check against
		 * @param int   $nodes_count The number of nodes in $nodes
		 * @param int   $idx The index to start checking against
		 * @return int
		 */
		protected function match(array $nodes, int $nodes_count, int $idx): int{
			# Loop through the rules
			foreach( $this->rules as $rule_idx => $rule ){
				# Check if the rule matches the current nodes
				if( $this->matchRule($nodes, $nodes_count, $idx, $rule) ){
					# Found a match
					return $rule_idx;
				}
			}

			# Did not find a match
			return -1;
		}

		protected function matchNode(Node $node, string $rule): bool{
			# Get the data from the rule
			preg_match('/^(?<name>\w++)(\((?<params>.*)\))?$/', $rule, $matches);

			# Check the name
			if( strcmp($matches['name'], $node->getName()) === 0 ){
				# Check if they're any parameters set
				if( isset($matches['params']) ){
					# Check the parameters of the rule
					$params = array_map('trim', explode(',', $matches['params']));

					# Check if the value of the node is in the params
					if( $node->hasValue() === false || in_array($node->getValue(), $params) === false ){
						# No match found
						return false;
					}
				}

				# Matched by the name
				return true;
			}

			# No match found
			return false;
		}

		protected function matchRule(array $nodes, int $nodes_count, int $idx, array $rule): bool{
			# Count the rule length
			$rule_count = count($rule);

			# Check the counts
			if( ($nodes_count - $idx) < $rule_count ){
				# The rule is too big for the number of nodes
				return false;
			}

			# Loop through the rule
			for( $i = 0; $i < $rule_count; $i++ ){
				# Check if the nodes match
				if( $this->matchNode($nodes[$idx + $i], $rule[$i]) === false ){
					# Does not match
					return false;
				}
			}

			# Found a match
			return true;
		}

		/**
		 * Replaces a node with a rule node
		 * Will create the rule indexed by $rules_idx starting at $idx on $nodes
		 * Return the new nodes
		 * @param array $nodes The list of nodes
		 * @param int   $idx The index of the starting node
		 * @param int   $rules_idx The index of the rule node to create
		 * @return Node
		 */
		protected function replace(array $nodes, int &$idx, int $rules_idx): Node{
			# Get the rule
			$rule       = $this->rules[$rules_idx];
			$rule_count = count($rule);

			# Check the rule count
			if( $rule_count === 1 ){
				# This just replaces the current node with the new node
				# Instead of creating a new lone child node
				# Create the node with the value of the current node
				$node = new Node($this->name, $nodes[$idx]->getValue());

				# Return the node
				return $node;
			}
			else{
				# Create the new node
				$node = new Node($this->name);

				# Loop through the rule
				for( $i = 0; $i < $rule_count; $i++ ){
					# Add the node as a child
					$node->addChild($nodes[$i + $idx]);
				}

				# Increment the index
				$idx += $rule_count - 1;

				# Return the node
				return $node;
			}
		}

		/**
		 * Adds a new production definition
		 * @param string $definition The definition to add
		 */
		public function add(string $definition): void{
			# Split the definition
			$defs = array_map('trim', explode('|', $definition));

			# Loop through the definitions
			foreach( $defs as $def ){
				# Get each factor of the definition
				# Add it to the list of rules
				$this->rules[] = preg_split('/\s+/', $def);
			}
		}

		/**
		 * Tries to reduce the number of nodes
		 * Checks the rules against the nodes, if any match
		 * replaces the nodes with the new node
		 * Returns true of there was any replacement
		 * @param array $nodes The list of nodes
		 * @return bool
		 */
		public function reduce(array &$nodes): bool{
			# Reduced flag
			$reduced = false;

			# Loop through the rules
			foreach( $this->rules as $rule_idx => $rule ){
				# The current list
				$lst = [];

				# Get the current number of nodes
				$nodes_count = count($nodes);

				# Loop through the nodes
				for( $i = 0; $i < $nodes_count; $i++ ){
					# Check if the current rule matches the nodes at the current position
					if( $this->matchRule($nodes, $nodes_count, $i, $rule) ){
						# Found a rule match
						# Replace the nodes
						$lst[] = $this->replace($nodes, $i, $rule_idx);

						# Update the flag
						$reduced = true;
					}
					else{
						# Add the node to the list
						$lst[] = $nodes[$i];
					}
				}

				# Update the nodes
				$nodes = $lst;
			}

			# Return whether reduced or not
			return $reduced;
		}
	}
