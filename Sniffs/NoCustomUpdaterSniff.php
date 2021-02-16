<?php
namespace ET\ElegantThemes\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NoCustomUpdaterSniff implements Sniff{
	/**
	 * Returns the token types that this sniff is interested in.
	 * @return array(int)
	 */
	public function register() {
		return [ T_STRING ];
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
		if ( in_array( $tokens[ $stackPtr ]['content'], [ 'add_action', 'add_filter' ] ) ) {
			$line        = '';
			$linePointer = $stackPtr;
			while ( $tokens[ $linePointer ]['type'] !== 'T_CLOSE_PARENTHESIS' ) {
				if ( $tokens[ $linePointer ]['type'] === 'T_WHITESPACE' ) {
					$linePointer ++;
					continue;
				}
				$line .= $tokens[ $linePointer ]['content'];
				$linePointer ++;

			}
			if ( strpos( $line, 'plugins_api' ) !== false || strpos( $line, 'update_plugins' ) !== false
				 || strpos( $line, 'update_themes' ) !== false ) {
				$phpcsFile->addError( "Custom updaters are not allowed on the marketplace: $line)", $stackPtr, 'NoUpdater' );
			}
		}
	}

}