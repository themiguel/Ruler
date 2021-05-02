<?php
	namespace Ruler\System;

	use Ruler\Api\Evaluator\Evaluator;

	use Ruler\Environment\Environment;
	use Ruler\Parser\Node;

	class System{
		/**
		 * The environment on the system
		 * @var Environment
		 */
		protected $environment;

		/**
		 * The list of evaluators
		 * @var array
		 */
		protected $evaluators;

		/**
		 * System constructor.
		 * Initializes the system
		 * @param Environment $env
		 */
		public function __construct(Environment $env){
			# Initialize the system
			$this->evaluators  = [];
			$this->environment = $env;
		}

		/**
		 * Adds a new evaluator
		 * @param Evaluator $evaluator The evaluator to add
		 */
		public function add(Evaluator $evaluator): void{
			# Add the evaluator
			$this->evaluators[] = $evaluator;
		}

		public function evaluate(Node $node){
			# Check if there's a evaluator for the node
			if( isset($this->evaluators[$node->getName()]) === false ){
				# No evaluator found
				throw new \Exception('Cannot evaluate token `'.$node->getName().'`');
			}

			# Evaluate the node
			return $this->evaluators[$node->getName()]->evalute($node);
		}
	}
