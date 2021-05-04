<?php
	/**
	 * Define the grammar
	 * @var \Ruler\Grammar\Grammar $grammar
	 */
	$grammar->production('expr', 'Symbol(() expr Symbol())');
	$grammar->production('expr', 'term Symbol(*,/) expr');
	$grammar->production('expr', 'term Symbol(+,-) expr');
	$grammar->production('expr', 'term Symbol(*,/) term');
	$grammar->production('expr', 'term Symbol(+,-) term');
	$grammar->production('term', 'Number | Identifier');