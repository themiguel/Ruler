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

		public function __construct(string $name){
			# Initialize the production
			$this->name  = $name;
			$this->rules = [];
		}

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
				# Matched the name
				return true;
			}

			# Check if the node has a class
			if( $node->hasToken() ){
				# The names do not match
				# Maybe the token class matches
				if( strcmp($matches['name'], $node->getTokenClass()) === 0 ){
					# Found the match on token class
					# Check if there's any parameters
					if( isset($matches['params']) ){
						# Check the parameters of the rule
						$params = array_map('trim', explode(',', $matches['params']));

						# Check if the value of the node is in the params
						if( in_array($node->getToken()->getValue(), $params) === false ){
							# No match found
							return false;
						}
					}

					# Found a match
					return true;
				}
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

		protected function replace(array $nodes, int &$idx, int $rules_idx): Node{
			# Create the new node
			$node = new Node($this->name);

			# Get the rule
			$rule       = $this->rules[$rules_idx];
			$rule_count = count($rule);

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
