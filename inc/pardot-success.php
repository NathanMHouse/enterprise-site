<?php
/**
 * Pardot Success (dist)
 *
 * Provides success endpoint for JSONP AJAX call (used w/i Pardot form handler).
 *
 * @package Enterprise-Site
 * @since   1.0.0
 */

header( 'content-type: application/json; charset=utf-8' );

exit( 'pardotCallback({"status":"success"})' );
