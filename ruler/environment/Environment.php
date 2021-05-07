<?php
	namespace Ruler\Environment;

	class Environment{
		/**
		 * The list of modules
		 * @var
		 */
		protected $modules;

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
			$this->vars    = $vars;
			$this->modules = [];
		}

		/**
		 * Adds an array of values to the environment
		 * @param array $values The values to add, indexed by name
		 */
		public function add(array $values): void{
			# Merge the arrays
			$this->vars = array_merge($this->vars, $values);
		}

		/**
		 * Adds a new module on the environment
		 * @param string $name   The name of the module
		 * @param Module $module The module object
		 */
		public function addModule(string $name, Module $module): void{
			# Add the module to the list
			$this->modules[$name] = $module;
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
		 * Returns the module in the environment
		 * @param string $name The name of the module
		 * @return Module
		 */
		public function getModule(string $name): Module{
			# Return the module in the environment
			return $this->modules[$name];
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
		 * Returns whether the module is in the environment
		 * @param string $name The module to check
		 * @return bool
		 */
		public function hasModule(string $name): bool{
			# Return whether the module is in the environment
			return isset($this->modules[$name]);
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