<?php
	namespace Ruler\Environment;

	class Module{
		/**
		 * Runs an action in the module
		 * @param string $action The action to run
		 * @param array  $values The values to pass to the action
		 */
		public function run(string $action, array $values){
			# Virtual function
			# Does nothing by default
		}
	}