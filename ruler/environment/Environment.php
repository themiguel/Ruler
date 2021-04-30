<?php
	namespace Ruler\Environment;

	class Environment{
		/**
		 * The list of variables
		 * @var array
		 */
		protected $vars;

		/**
		 * Environment constructor.
		 * Initializes the environment
		 * @param array $vars The variables to set to
		 */
		public function __construct(array $vars = []){
			# Initialize the environment
			$this->vars = $vars;
		}

		/**
		 * Returns the value of a variable
		 * @param string $name The name of the variable
		 * @return mixed
		 */
		public function get(string $name){
			# Return the variable
			return $this->vars[$name];
		}

		/**
		 * Return whether the variable is set on the environment
		 * @param string $name The name of the variable
		 * @return bool
		 */
		public function has(string $name): bool{
			# Return whether the variable is set or not
			return isset($this->vars[$name]);
		}

		/**
		 * Sets a variable on the environment
		 * @param string $name  The name of the variable
		 * @param mixed  $value The value of the variable
		 */
		public function set(string $name, $value): void{
			# Set the value of the variable
			$this->vars[$name] = $value;
		}
	}