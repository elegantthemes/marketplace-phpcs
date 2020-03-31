<?php

namespace ElegantThemesJS\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ComparisonsSniff implements Sniff {

	/**
	 * A list of tokenizers this sniff supports.
	 * @var array
	 */
	public $supportedTokenizers = [ 'JS' ];

	/**
	 * Returns the token types that this sniff is interested in.
	 * @return array(int)
	 */
	public function register() {
		return [ T_IS_EQUAL, T_IS_NOT_EQUAL ];
	}

	/**
	 * Processes the tokens that this sniff is interested in.
	 *
	 * @param File $phpcsFile                 The file where the token was found.
	 * @param int  $stackPtr                  The position in the stack where
	 *                                        the token was found.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();
		$use    = $tokens[ $stackPtr ]['type'] == 'T_IS_EQUAL' ? '===' : '!==';
		$error  = 'Found: ' . $tokens[ $stackPtr ]['content'] . " use $use instead to avoid unexpected type coercion.";
		$phpcsFile->addError( $error, $stackPtr, 'ET_Comparison' );
	}
}
