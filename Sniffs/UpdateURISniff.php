<?php

namespace ET\ElegantThemes\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class UpdateURISniff implements Sniff {

	/**
	 * Returns the token types that this sniff is interested in.
	 * @return array(int)
	 */
	public function register() {
		return [ T_COMMENT ];
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

		if ( ! $this->isETUpdateURI( $tokens[ $stackPtr ]['content'] ) ) {
			$phpcsFile->addError( "Invalid plugin update URI", $stackPtr, 'InvalidUpdateURI' );
		}
    }

    public function isETUpdateURI( $content ) {
        return ( 0 === preg_match( '/Update URI\s*:/i', $content ) )
            || ( 1 === preg_match( '/Update URI\s*:\s*(https?:\/\/)?([a-z0-9]+\.)*elegantthemes.com/i', $content ) );
    }
}