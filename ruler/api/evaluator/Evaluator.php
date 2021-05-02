<?php
	namespace Ruler\Api\Evaluator;

	use Ruler\Parser\Node;
	use Ruler\Environment\Environment;

	interface Evaluator{
		/**
		 * Evaluates a current node
		 * @param Environment $env The environment to evaluate with
		 * @param Node $node The node to evaluate
		 * @return mixed
		 */
		public function evaluate(Environment $env, Node $node);
	}