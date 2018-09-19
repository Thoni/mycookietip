<?php

 /**
  * Namespace
  */


if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    mycookietip
 * @license    LGPL
 * @filesource
 */



/**
 * Class myCookieTip
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    mycookietip
 */


class myCookieTip extends System
{

	public function checkCookie($strContent, $strTemplate)
	{
		global $objPage;
	    if ($strTemplate == 'fe_page')
	    {
			$this->import('Database');

// pruefen, ob fuer diese Seite ein Hinweis hinterlegt ist
			$sql = $this->Database->prepare("SELECT * FROM tl_mycookietip WHERE published=? AND site_control <> ?")
								->execute('1','1');
			$cookieID = 0;

			if($sql->next())
			{
				$cookieID = $sql->id;
				$cookieDays = $sql->runtime;
				$cookieText = $sql->text;
				$cookieButtonText = $sql->buttontext;
			} else
			{
				$sql = $this->Database->prepare("SELECT * FROM tl_mycookietip WHERE published=? AND site_control <> ?")
									->execute('1','0');
				while($sql->next() && $cookieID == 0)
				{
					if(in_array($objPage->layout,deserialize($sql->layouts)))
					{
						$cookieID = $sql->id;
						$cookieDays = $sql->runtime;
						$cookieText = $sql->text;
						$cookieButtonText = $sql->buttontext;
					}
				}
			}

// pruefen, ob der Cookie gesetzt werden muss
			if(\Input::post('setCookie') == 'y' && $cookieID != 0)
			{
				\System::setCookie('displayCookieConsent_'.$cookieID, 'y', time() + (86400 * $cookieDays));
// pruefen, ob der Hinweis ausgegeben werden muss
			} else if($cookieID != 0)
			{
				if(\Input::cookie('displayCookieConsent_'.$cookieID) != 'y')
				{
// Hinweis zusammensetzen
						$tipText = '<div id="mycookietip"><div class="inside">'.str_replace('#tage#',$cookieDays,$cookieText).'<form action="{{env::path}}{{env::request}}" method="post"><input type="hidden" name="ts" value="'.time().'"><input type="hidden" name="REQUEST_TOKEN" value="{{request_token}}"><input type="hidden" name="setCookie" value="y"><input type="submit" value="'.$cookieButtonText.'"></form></div></div>';

// Hinweis einsetzen

					preg_match('/(<body[^>]*>)/', $strContent, $bodyTag);
					$strContent = str_replace($bodyTag[0],$bodyTag[0].$tipText,$strContent);
					$GLOBALS['TL_CSS']['mycookietip'] = 'system/modules/mycookietip/assets/styles/stylesheet.css';
				}


			}
	    }
    return $strContent;
	}
}
?>
