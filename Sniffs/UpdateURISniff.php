<?php

namespace ET\ElegantThemes\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class UpdateURISniff implements Sniff {

	/**
	 * Returns the token types that this sniff is interested in.
	 * @return mixed[]
	 */
	public function register() {
		return [ T_COMMENT, T_DOC_COMMENT_STRING ];
	}

	/**
	 * Processes the tokens that this sniff is interested in.
	 *
	 * @param File $phpcsFile The file where the token was found.
	 * @param int  $stackPtr  The position in the stack where the token was found.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		if ( ! $this->isETUpdateURI( $tokens[ $stackPtr ]['content'] ) ) {
			$phpcsFile->addError( "Invalid plugin update URI. Plugins submitted to Elegant Themes Marketplace should use https://elegantthemes.com to avoid conflict with plugins sold on seller's website.", $stackPtr, 'InvalidUpdateURI' );
		}
	}

	/**
	 * Checks if the 'Update URI' header is empty or set to ET's.
	 *
	 * @param string $content Comment content.
	 *
	 * @return bool
	 */
	public function isETUpdateURI( $content ) {
		return ( 0 === preg_match( '/Update URI\s*:/i', $content ) )
			|| ( 1 === preg_match( '/Update URI\s*:\s*(https?:\/\/)?([a-z0-9]+\.)*elegantthemes.com/i', $content ) );
	}
}