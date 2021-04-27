<?php
	declare(strict_types=1);

	use PHPUnit\Framework\TestCase;

	use Ruler\Lexer\Lexer;

	final class LexerTest extends TestCase{
		public function testSimpleNumber():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('123');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Number::class, $tokens[0]);
			$this->assertEquals(123, $tokens[0]->getValue());
		}

		public function testFloatNumbers():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('3.1415');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Number::class, $tokens[0]);
			$this->assertEquals(3.1415, $tokens[0]->getValue());
		}

		public function testSimpleIdentifier(): void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('x');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Identifier::class, $tokens[0]);
		}

		public function testSimpleSymbol():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('>=');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Symbol::class, $tokens[0]);
		}

		public function testEmptyQuotes():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('""');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Quotes::class, $tokens[0]);
		}

		public function testSimpleQuotes():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('"There is something in here"');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Quotes::class, $tokens[0]);
			$this->assertEquals('There is something in here', $tokens[0]->getValue());
		}
	}