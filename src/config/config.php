<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
 * @license    GPL
 * @filesource
 */

/*
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 *
 */

array_insert(
    $GLOBALS['BE_MOD'], 10, array(
        'system' => array(
            'cookie_tip' => array(
                'icon'   => 'system/modules/mycookietip/assets/images/extension.gif',
                'tables' => array('tl_mycookietip')
            )
        )
    )
);

/*
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 *
 */


if (TL_MODE == 'FE') $GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('myCookieTip','checkCookie');


/*
 * -------------------------------------------------------------------------
 * CSS
 * -------------------------------------------------------------------------
 *
 */

//$GLOBALS['TL_CSS']['mycookietip'] = 'system/modules/mycookietip/assets/styles/stylesheet.css';

?>