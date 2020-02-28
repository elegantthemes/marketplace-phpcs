<?php
namespace ElegantThemes\Sniffs;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;

class DeprecatedSniff extends ForbiddenFunctionsSniff {

	public $forbiddenFunctions = [
		'et_sanitize_value_by_cap'     => 'et_core_sanitize_value_by_cap',
		'et_intentionally_unsanitized' => 'et_core_intentionally_unsanitized',
		'et_intentionally_unescaped'   => 'et_core_intentionally_unescaped',
		'et_esc_wp'                    => 'et_core_esc_wp',
		'et_esc_previously'            => 'et_core_esc_previously',
	];

	protected function addError( $phpcsFile, $stackPtr, $function, $pattern = null ) {
		if ( $pattern === null ) {
			$pattern = strtolower( $function );
		}
		$data   = [ $function ];
		$data[] = $this->forbiddenFunctions[ $pattern ];
		$error  = 'The function %s() is deprecated; Please use %s() instead';
		$phpcsFile->addError( $error, $stackPtr, 'FoundWithAlternative', $data );
	}
}