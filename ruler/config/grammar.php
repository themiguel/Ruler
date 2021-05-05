<?php
	/**
	 * Define the grammar
	 * @var \Ruler\Grammar\Grammar $grammar
	 */
	$grammar->production('term', 'Number | Identifier');
	$grammar->production('expr', 'term Symbol(*,/) term');
	$grammar->production('expr', 'term Symbol(+,-) term');
	$grammar->production('expr', 'term Symbol(*,/) expr');
	$grammar->production('expr', 'term Symbol(+,-) expr');