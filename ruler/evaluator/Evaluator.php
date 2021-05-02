<?php
	namespace Ruler\Evaluator;

	use Ruler\System\System;

	abstract class Evaluator implements \Ruler\Api\Evaluator\Evaluator{
		/**
		 * The system
		 * @var System
		 */
		protected $system;

		final public function __construct(System $system){
			# Initialize the evaluator
			$this->system = $system;
		}
	}