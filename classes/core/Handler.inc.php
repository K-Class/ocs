<?php

/**
 * @file Handler.inc.php
 *
 * Copyright (c) 2000-2007 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @package core
 * @class Handler
 *
 * Base request handler class.
 *
 * $Id$
 */

class Handler {

	/**
	 * Fallback method in case request handler does not implement index method.
	 */
	function index() {
		header('HTTP/1.0 404 Not Found');
		fatalError('404 Not Found');
	}
	
	/**
	 * Perform request access validation based on security settings.
	 * @param $requiresConference boolean
	 */
	function validate($requiresConference = false, $requiresSchedConf = false) {
		if (Config::getVar('security', 'force_ssl') && Request::getProtocol() != 'https') {
			// Force SSL connections site-wide
			Request::redirectSSL();
		}
		
		$conference = &Request::getConference();
		$schedConf = &Request::getSchedConf();

		if($requiresConference) {
			if ($conference == null) {
				// Requested page is only allowed when a conference is provided
				Request::redirect(null, null, 'about');
			}
		}

		if($requiresSchedConf) {
			if ($schedConf == null) {
				// Requested page is only allowed when a scheduled conference is provided
				Request::redirect(null, null, 'about');
			}
		}

		// Extraneous checks, just to make sure we aren't being fooled
		if ($conference && $schedConf) {
			if($schedConf->getConferenceId() != $conference->getConferenceId())
				Request::redirect(null, null, 'about');
		}
		
		return array($conference, $schedConf);
	}

	/**
	 * Return the DBResultRange structure and misc. variables describing the current page of a set of pages.
	 * @param $rangeName string Symbolic name of range of pages; must match the Smarty {page_list ...} name.
	 * @return array ($pageNum, $dbResultRange)
	 */
	function &getRangeInfo($rangeName) {
		$conference = &Request::getConference();
		$conferenceSettingsDao = &DAORegistry::getDAO('ConferenceSettingsDAO');

		$pageNum = Request::getUserVar($rangeName . 'Page');
		if (empty($pageNum)) $pageNum=1;

		if ($conference) $count = $conferenceSettingsDao->getSetting($conference->getConferenceId(), 'itemsPerPage');
		if (!isset($count)) $count = Config::getVar('interface', 'items_per_page');

		import('db.DBResultRange');

		if (isset($count)) $returner = &new DBResultRange($count, $pageNum);
		else $returner = &new DBResultRange(-1, -1);

		return $returner;
	}
}
?>
