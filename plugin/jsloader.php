<?php
/**
 * @version		$Id: jsloader.php 2010-10-19 esteban
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

/**
 * This plugin is a helper to load the javascript in some better ways
 */

// Check to ensure this file is included in Joomla!
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

//$mainframe->registerEvent( 'onAfterRender', 'plgContenJsLoader' );

/**
 * Example Content Plugin
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 		1.5
 */
class plgSystemJsLoader extends JPlugin
{
	static $filelist = array();
	static $jsparts = array();

	function plgSystemJsLoader (& $subject, $config) {
		parent::__construct($subject, $config);
	}

	function onJsLoad($file=null, $content=null) {		
		global $mainframe;
		if( !empty($file) && empty($this->filelist[$file]) ) {
			$this->filelist[$file] = 1;
			$this->jsparts[] = '<script type="text/javascript" charset="utf-8" src="'.$file.'" ></script>';
		}
		if( !empty($content) ) {
			$this->jsparts[] = $content; 				
		}
		
	}

	
	function onAfterRender() {
		global $mainframe;
		
		if( empty($this->jsparts) || !is_array($this->jsparts)) return;
		
		$document	=& JFactory::getDocument();
		$doctype	= $document->getType();

		// Only render for HTML output
		if ( $doctype !== 'html' ) { return; }

		$body = JResponse::getBody();
		$body = str_replace('</body>', implode("\n", $this->jsparts).'</body>', $body);
		JResponse::setBody($body);
		
	}

}
