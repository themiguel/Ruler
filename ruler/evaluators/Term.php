<?php
	namespace Ruler\Evaluators;

	use Ruler\Evaluator\Evaluator;
	use Ruler\Environment\Environment;
	use Ruler\Parser\Node;
	use \Exception;

	class Term extends Evaluator{
		public function evaluate(Environment $env, Node $node){
			# Check the node name
			if( $node->getName() !== 'term' ){
				# Cannot handle this node
				throw new Exception('Term: cannot handle node `'.$node->getName().'`');
			}

			# Check the value of the node
			if( is_numeric($node->getValue()) ){
				# Simply return the value
				return $node->getValue();
			}

			# Check the environment
			if( $env->has($node->getValue()) === false ){
				# No identifier with that name found
				throw new Exception('Term: no identifier `'.$node->getValue().'` found');
			}

			# Return the value of the identifier
			return $env->get($node->getValue());
		}
	}