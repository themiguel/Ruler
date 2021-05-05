<?php
	declare(strict_types=1);

	use PHPUnit\Framework\TestCase;

	use Ruler\Grammar\Grammar;
	use Ruler\Parser\Parser;

	class ParserTest extends TestCase{
		/**
		 * The grammar used for testing
		 * @var Grammar
		 */
		private $grammar;

		/**
		 * The parser used
		 * @var Parser
		 */
		private $parser;

		public function setUp():void{
			# Create a grammar
			$this->grammar = new Grammar();
			$this->grammar->production('term', 'Number | Identifier');

			# Create the parser
			$this->parser = new Parser($this->grammar);
		}

		public function testSimpleNumber():void{
			$nodes = $this->parser->parse('3');
			$this->assertEquals(1, count($nodes));
			$this->assertEquals('term', $nodes[0]->getName());
			$this->assertEquals(3, $nodes[0]->getValue());
		}
	}