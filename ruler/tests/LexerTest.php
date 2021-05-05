<?php
	declare(strict_types=1);

	use PHPUnit\Framework\TestCase;

	use Ruler\Lexer\Lexer;
	use Ruler\Lexer\Tokens\Number;
	use Ruler\Lexer\Tokens\Quotes;
	use Ruler\Lexer\Tokens\Symbol;
	use Ruler\Lexer\Tokens\Identifier;

	final class LexerTest extends TestCase{
		public function testSimpleNumber():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('123');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Number::class, $tokens[0]);
			$this->assertEquals(123, $tokens[0]->getValue());
		}

		public function testFloatNumbers():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('3.1415');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Number::class, $tokens[0]);
			$this->assertEquals(3.1415, $tokens[0]->getValue());
		}

		public function testSimpleIdentifier(): void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('x');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Identifier::class, $tokens[0]);
		}

		public function testSimpleSymbol():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('>=');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Symbol::class, $tokens[0]);
		}

		public function testEmptyQuotes():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('""');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Quotes::class, $tokens[0]);
		}

		public function testSimpleQuotes():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('"There is something in here"');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Quotes::class, $tokens[0]);
			$this->assertEquals('There is something in here', $tokens[0]->getValue());
		}

		public function testConditionalRule1():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('3 < 4');
			$this->assertEquals(3, count($tokens));
			$this->assertInstanceOf(Number::class, $tokens[0]);
			$this->assertInstanceOf(Symbol::class, $tokens[1]);
			$this->assertInstanceOf(Number::class, $tokens[2]);
			$this->assertEquals(3, $tokens[0]->getValue());
			$this->assertEquals('<', $tokens[1]->getValue());
			$this->assertEquals(4, $tokens[2]->getValue());
		}

		public function testFuncRule1():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('module:func()');
			$this->assertEquals(4, count($tokens));
			$this->assertInstanceOf(Identifier::class, $tokens[0]);
			$this->assertInstanceOf(Symbol::class, $tokens[1]);
			$this->assertInstanceOf(Identifier::class, $tokens[2]);
			$this->assertInstanceOf(Symbol::class, $tokens[3]);
			$this->assertEquals('module', $tokens[0]->getValue());
			$this->assertEquals(':', $tokens[1]->getValue());
			$this->assertEquals('func', $tokens[2]->getValue());
			$this->assertEquals('()', $tokens[3]->getValue());
		}

		public function testFuncRule2():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('module:func(1)');
			$this->assertEquals(6, count($tokens));
			$this->assertInstanceOf(Identifier::class, $tokens[0]);
			$this->assertInstanceOf(Symbol::class, $tokens[1]);
			$this->assertInstanceOf(Identifier::class, $tokens[2]);
			$this->assertInstanceOf(Symbol::class, $tokens[3]);
			$this->assertInstanceOf(Number::class, $tokens[4]);
			$this->assertInstanceOf(Symbol::class, $tokens[5]);
			$this->assertEquals('module', $tokens[0]->getValue());
			$this->assertEquals(':', $tokens[1]->getValue());
			$this->assertEquals('func', $tokens[2]->getValue());
			$this->assertEquals('(', $tokens[3]->getValue());
			$this->assertEquals(1, $tokens[4]->getValue());
			$this->assertEquals(')', $tokens[5]->getValue());
		}

		public function testSimpleExpression():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('1 + 2');
			$this->assertEquals(3, count($tokens));
			$this->assertInstanceOf(Number::class, $tokens[0]);
			$this->assertInstanceOf(Symbol::class, $tokens[1]);
			$this->assertInstanceOf(Number::class, $tokens[2]);
			$this->assertEquals(1, $tokens[0]->getValue());
			$this->assertEquals('+', $tokens[1]->getValue());
			$this->assertEquals(2, $tokens[2]->getValue());
		}
	}