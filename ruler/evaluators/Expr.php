<?php
	namespace Ruler\Evaluators;

	use Ruler\Environment\Environment;
	use Ruler\Evaluator\Evaluator;
	use Ruler\Parser\Node;
	use Exception;

	class Expr extends Evaluator{
		public function evaluate(Environment $env, Node $node){
			# Check the node name
			if( $node->getName() !== 'expr' ){
				# Cannot handle this node
				throw new Exception('Expr: cannot handle node `' . $node->getName() . '`');
			}

			# Get the nodes
			$left   = $node->getChild(0);
			$action = $node->getChild(1)->getToken();
			$right  = $node->getChild(2);

			# Check the action
			if( $action->getValue() === '*' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) * $this->system->evaluate($right);
			}
			else if( $action->getValue() === '/' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) / $this->system->evaluate($right);
			}
			else if( $action->getValue() === '+' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) + $this->system->evaluate($right);
			}
			else if( $action->getValue() === '-' ){
				# Return the multiplication of the node
				return $this->system->evaluate($left) - $this->system->evaluate($right);
			}

			# Cannot handle this node
			throw new Exception('Expr: cannot handle node `' . $node->getName() . '`');
		}
	}