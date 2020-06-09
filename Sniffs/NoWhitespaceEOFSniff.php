<?php
/**
 * Checks for unneeded whitespace.
 * Checks that no whitespace precedes the first content of the file, exists
 * after the last content of the file, resides after content on any line, or
 * are two empty lines in functions.
 * Modified version to only search for spaces before opening php tags at the start of file or whitespaces after the last closing tag.
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

namespace ET\ElegantThemes\Sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class NoWhitespaceEOFSniff implements Sniff {
	/**
	 * A list of tokenizers this sniff supports.
	 * @var array
	 */
	public $supportedTokenizers = [
		'PHP',
	];

	/**
	 * Returns an array of tokens this test wants to listen for.
	 * @return array
	 */
	public function register() {
		return [
			T_OPEN_TAG,
			T_CLOSE_TAG,
			T_WHITESPACE,
		];

	}//end register()

	/**
	 * Processes this sniff, when one of its tokens is encountered.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
	 * @param int                         $stackPtr  The position of the current token in the
	 *                                               stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		if ( $tokens[ $stackPtr ]['code'] === T_OPEN_TAG ) {
			/*
				Check for start of file whitespace.
			*/

			// If it's the first token, then there is no space.
			if ( $stackPtr === 0 ) {
				return;
			}

			$beforeOpen = '';

			for ( $i = ( $stackPtr - 1 ); $i >= 0; $i -- ) {
				// If we find something that isn't inline html then there is something previous in the file.
				if ( $tokens[ $i ]['type'] !== 'T_INLINE_HTML' ) {
					return;
				}

				$beforeOpen .= $tokens[ $i ]['content'];
			}

			// If we have ended up with inline html make sure it isn't just whitespace.
			if ( preg_match( '`^[\pZ\s]+$`u', $beforeOpen ) !== 1 ) {
				return;
			}


			$fix = $phpcsFile->addFixableError( 'Additional whitespace found at start of file', $stackPtr, 'StartFile' );
			if ( $fix === true ) {
				$phpcsFile->fixer->beginChangeset();
				for ( $i = 0; $i < $stackPtr; $i ++ ) {
					$phpcsFile->fixer->replaceToken( $i, '' );
				}

				$phpcsFile->fixer->endChangeset();
			}
		} elseif ( $tokens[ $stackPtr ]['code'] === T_CLOSE_TAG ) {
			/*
				Check for end of file whitespace.
			*/

			if ( $phpcsFile->tokenizerType === 'PHP' ) {
				if ( isset( $tokens[ ( $stackPtr + 1 ) ] ) === false ) {
					// The close PHP token is the last in the file.
					return;
				}

				$afterClose = '';

				for ( $i = ( $stackPtr + 1 ); $i < $phpcsFile->numTokens; $i ++ ) {
					// If we find something that isn't inline HTML then there
					// is more to the file.
					if ( $tokens[ $i ]['type'] !== 'T_INLINE_HTML' ) {
						return;
					}

					$afterClose .= $tokens[ $i ]['content'];
				}

				// If we have ended up with inline html make sure it isn't just whitespace.
				if ( preg_match( '`^[\pZ\s]+$`u', $afterClose ) !== 1 ) {
					return;
				}
			} else {
				// The last token is always the close tag inserted when tokenized
				// and the second last token is always the last piece of content in
				// the file. If the second last token is whitespace, there was
				// whitespace at the end of the file.
				$stackPtr --;

				// The pointer is now looking at the last content in the file and
				// not the fake PHP end tag the tokenizer inserted.
				if ( $tokens[ $stackPtr ]['code'] !== T_WHITESPACE ) {
					return;
				}

				// Allow a single newline at the end of the last line in the file.
				if ( $tokens[ ( $stackPtr - 1 ) ]['code'] !== T_WHITESPACE && $tokens[ $stackPtr ]['content'] === $phpcsFile->eolChar ) {
					return;
				}
			}//end if

			$fix = $phpcsFile->addFixableError( 'Additional whitespace found at end of file', $stackPtr, 'EndFile' );
			if ( $fix === true ) {
				if ( $phpcsFile->tokenizerType !== 'PHP' ) {
					$prev     = $phpcsFile->findPrevious( T_WHITESPACE, ( $stackPtr - 1 ), null, true );
					$stackPtr = ( $prev + 1 );
				}

				$phpcsFile->fixer->beginChangeset();
				for ( $i = ( $stackPtr + 1 ); $i < $phpcsFile->numTokens; $i ++ ) {
					$phpcsFile->fixer->replaceToken( $i, '' );
				}

				$phpcsFile->fixer->endChangeset();
			}
		}
	}//end process()
}//end class
