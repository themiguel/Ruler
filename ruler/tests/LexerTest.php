<?php
	declare(strict_types=1);

	use PHPUnit\Framework\TestCase;

	use Ruler\Lexer\Lexer;

	final class LexerTest extends TestCase{
		public function testSingleDigitTokenizer():void{
			$lexer = new Lexer();
			$tokens = $lexer->tokenize('3');
			$this->assertEquals(1, count($tokens));
			$this->assertInstanceOf(Ruler\Lexer\Tokens\Number::class, $tokens[0]);
		}
	}