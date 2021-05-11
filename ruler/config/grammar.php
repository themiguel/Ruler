<?php
	/**
	 * Define the grammar
	 * @var \Ruler\Grammar\Grammar $grammar
	 */
	$grammar->production('expr', 'Number | Identifier');
	$grammar->production('expr', 'Symbol(() expr Symbol())');
	$grammar->production('expr', 'expr Symbol(*,/) expr');
	$grammar->production('expr', 'expr Symbol(+,-) expr');