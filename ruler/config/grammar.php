<?php
	/**
	 * Define the grammar
	 * @var \Ruler\Grammar\Grammar $grammar
	 */
	$grammar->rule('term', ['Number']);
	$grammar->rule('expr', ['term', 'Symbol := +,-,*,/', 'term']);