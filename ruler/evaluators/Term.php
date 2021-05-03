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

			# Get the actual node
			$node = $node->getchild(0);

			# Get the node
			$token = $node->getToken();

			# Check the node type
			if( $node->getTokenClass() === 'Identifier' ){
				# Check the environment
				if( $env->has($token->getValue()) === false ){
					# No identifier with that name found
					throw new Exception('Term: no identifier `'.$node->getName().'` found');
				}

				# Return the value of the identifier
				return $env->get($token->getValue());
			}
			else if( $node->getTokenClass() === 'Number' ){
				# Return the number of the token
				return $token->getValue();
			}

			# Cannot handle this
			throw new Exception('Term: cannot handle node `'.$node->getName().'`');
		}
	}