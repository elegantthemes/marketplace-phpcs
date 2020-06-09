<?php

namespace ET\ElegantThemes\Sniffs;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;

class DeprecatedSniff extends ForbiddenFunctionsSniff {

	public $forbiddenFunctions = [
		'et_sanitize_value_by_cap'            => 'et_core_sanitize_value_by_cap()',
		'et_intentionally_unsanitized'        => 'et_core_intentionally_unsanitized()',
		'et_intentionally_unescaped'          => 'et_core_intentionally_unescaped()',
		'et_esc_wp'                           => 'et_core_esc_wp()',
		'et_esc_previously'                   => 'et_core_esc_previously()',
		'et_fb_enabled'                       => 'et_core_is_fb_enabled()',
		'et_pb_generate_responsive_css'       => 'et_pb_responsive_options()->generate_responsive_css()',
		'et_core_api_email_providers'         => 'ET_Core_API_Email_Providers::instance()',
		'et_pb_get_standard_post_types'       => 'ET_Builder_Library::built_for_post_types()',
		'et_pb_get_used_built_for_post_types' => 'ET_Builder_Library::built_for_post_types(\'all\')',
		'et_is_gutenberg_active'              => 'et_core_is_gutenberg_active()',
		'et_is_gutenberg_enabled'             => 'et_core_is_gutenberg_enabled()',
	];

	protected function addError( $phpcsFile, $stackPtr, $function, $pattern = null ) {
		if ( $pattern === null ) {
			$pattern = strtolower( $function );
		}
		$data   = [ $function ];
		$data[] = $this->forbiddenFunctions[ $pattern ];
		$error  = 'The function %s() is deprecated; Please use %s instead';
		$phpcsFile->addError( $error, $stackPtr, 'FoundWithAlternative', $data );
	}
}