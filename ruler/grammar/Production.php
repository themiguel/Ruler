<?php
	namespace Ruler\Grammar;

	use Ruler\Parser\Node;

	class Production{
		/**
		 * The list of rules
		 * @var array
		 */
		protected $rules;

		public function __construct(){
			# Initialize the production
			$this->rules = [];
		}

		public function add(string $definition): void{
			# Split the definition
			$defs = array_map('trim', explode('|', $definition));

			# Loop through the definitions
			foreach($defs as $def){
				# Get each factor of the definition
				# Add it to the list of rules
				$this->rules[] = preg_split('/\s+/', $def);
			}
		}

		protected function matchNode(Node $node, string $rule): bool{
			# Get the data from the rule
			preg_match('/^(?<name>\w++)(\((?<params>.*)\))?$/', $rule, $matches);

			# Check the name
			if( strcmp($matches['name'], $node->getType()) === 0 ){
				# Matched the name
				return true;
			}

			# The names do not match
			# Maybe the token class matches
			if( strcmp($matches['name'], $node->getTokenClass()) === 0 ){
				# Found the match on token class
				# Check if there's any parameters
				if( isset($matches['params']) ){
					echo 'TODO';
				}

				# Found a match
				return true;
			}

			# No match found
			return false;
		}

		protected function matchRule(array $nodes, array $rules): bool{
			# Get the number of nodes
			$nodes_num = count($nodes);

			# The number of rules
			$rules_num = count($rules);

			# Loop through the nodes
			for( $i = 0; $i < $nodes_num; $i++ ){
				# Set the found flag
				$found = true;

				# Set the nodes counter
				$j = $i;

				# Reset the rules counters
				$r = 0;

				# Loop through the rules
				while( $r < $rules_num ){

					# Check if the current rule matches the current node
					if( $this->matchNode($nodes[$j], $rules[$r]) === false ){
						# Finish checking this
						$r = $rules_num;

						# Did not find a match
						$found = false;
					}

					# Increase the counts
					$r++;
					$j++;
				}

				# Check if the node was found
				if( $found ){
					# Found a match
					return true;
				}
			}

			# Does not match
			return false;
		}

		public function match(array $nodes): bool{
			# Loop through the rules
			foreach( $this->rules as $rule ){
				# Check the match of the rule
				if( $this->matchRule($nodes, $rule) ){
					# Found a match
					return true;
				}
			}

			# Does not match
			return false;
		}
	}
