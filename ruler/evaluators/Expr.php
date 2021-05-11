<?php
	namespace Ruler\Evaluators;

	use Ruler\Environment\Environment;
	use Ruler\Evaluator\Evaluator;
	use Ruler\Parser\Node;
	use Exception;

	class Expr extends Evaluator{
		/**
		 * Evaluates a expr term
		 * @param Environment $env Environment of execution
		 * @param Node        $node The expr node
		 * @return float|int|mixed|null
		 * @throws Exception
		 */
		public function evaluate(Environment $env, Node $node){
			# Check the node name
			if( $node->getName() !== 'expr' ){
				# Cannot handle this node
				throw new Exception('Expr: cannot handle node `' . $node->getName() . '`');
			}

			# Check the number of children
			if( $node->getChildrenCount() == 0 ){
				# There are no children
				# We can assume this is either a number or identifier
				# Check the value
				$value = $node->getValue();

				# Check if it's numeric
				if( is_numeric($value) ){
					# Return the numeric value
					return $value;
				}

				# Check if the value if in the environment
				if( $env->has($value) === false ){
					# The environment does not hold the value
					# Throw an exception
					throw new Exception('Expr: variable `'.$value.'` is not declared before use.');
				}

				# Return the value in the environment
				return $env->get($value);
			}

			# Get the child nodes
			$left  = $node->getChild(0);
			$mid   = $node->getChild(1);
			$right = $node->getChild(2);

			# Check the middle node
			if( $mid->getName() === 'expr' ){
				# Have another expression
				# Simply handle the middle expression
				return $this->system->evaluate($mid);
			}

			# Get the action
			$action = $mid->getValue();

			# Check the action
			if( $action === '*' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) * $this->system->evaluate($right);
			}
			else if( $action === '/' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) / $this->system->evaluate($right);
			}
			else if( $action === '+' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) + $this->system->evaluate($right);
			}
			else if( $action === '-' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) - $this->system->evaluate($right);
			}

			# Cannot handle this node
			throw new Exception('Expr: cannot handle node `' . $node->getName() . '`');
		}
	}