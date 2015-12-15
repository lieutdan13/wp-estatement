<?php

class BonsaiError {

	public $errors;

	function __construct() {
		$this->hasError = false;
		$this->errors = array();
	}

	function addError( $title, $message, $context, $line, $exception = null ) {
		$error = array( 'title' => $title, 'message' => $message, 'context' => $context, 'line' => $line, 'exception' => $exception );
		if( !in_array( $error, $this->errors ) ){
			array_push( $this->errors, $error );
		}
	}

	function hasError() {
		if( count( $this->errors ) === 0 ) {
			return false;
		}

		return true;
	}

	function countErrors() {
		return count( $this->errors );
	}

	function debugInformation() {
		if( $this->hasError() ) {
			$output = '<ol>';
			foreach( $this->errors as $error ) {
				$output .= '
					<li style="margin:0 0 16px 0;">
						<h1 style="margin:0 0 4px 0;font-size:16px;">' . $error['title'] . ' <span style="font-size:11px; font-weight:300; color:#999">' . $error['context'] . ' |  <span style="color: #ea241c">#' . $error['line'] . '</span></span></h1>

						<div style="line-height:21px">' . $error['message'] . '</div>
					</li>
				';
			}
			$output .= '</ol>';
		}
		else {
			$output = 'There are no errors';
		}
		return $output;

	}


	function errorInformation() {
		if( $this->hasError() ) {
			$output = '<ol class="errors">';
			foreach( $this->errors as $error ) {
				$output .= '
					<li>
						<h4>' . $error['title'] . '</h4>

						<p>' . $error['message'] . '</p>
					</li>
				';
			}
			$output .= '</ol>';
		}
		else {
			$output = 'There are no errors';
		}
		return $output;

	}


}

?>