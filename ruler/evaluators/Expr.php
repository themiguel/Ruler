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

			echo "<pre>", print_r($left, true), "</pre>";
			echo "<pre>", print_r($right, true), "</pre>";

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

			echo "<pre>", print_r($node, true), "</pre>";

			# Cannot handle this node
			throw new Exception('Expr: cannot handle node `' . $node->getName() . '`');
		}
	}