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



/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_mycookietip'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'tables'                      => array('tl_mycookietip'),
		'onload_callback'             => array(),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index'
			)
		),
		'closed'                      => false,
		'switchToEdit'                => true,
		'enableVersioning'            => false
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('name'),
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('name','layouts:tl_layout.name'),
			'format'                  => '%s (%s)',
            'label_callback'           => array('tl_mycookietip','getLabel'),
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mycookietip']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mycookietip']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_mycookietip']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this,%s);"',
				'button_callback'     => array('tl_mycookietip', 'toggleIcon')
			)
		)
	),

    // select
    'select' => array
    (
    ),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('site_control'),
		'default'                     => '{label_start},name,text,buttontext,runtime;{label_control},site_control,published;'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'site_control'                     => 'layouts'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['name'],
			'inputType'               => 'text',
			'eval'					  => array('tl_class'=>' w50','maxlength'=>'255','mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'text' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['text'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr','mandatory'=>true),
			'sql'                     => "text NULL"
		),
		'buttontext' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['buttontext'],
			'inputType'               => 'text',
			'eval'					  => array('tl_class'=>' w50','maxlength'=>'255','mandatory'=>true),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'runtime' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['runtime'],
			'inputType'               => 'text',
			'eval'                    => array('tl_class'=>' w50','mandatory'=>true,'maxlength' => 4,'rgxp' => 'digit'),
			'sql'                     => "int(10) unsigned NOT NULL default '365'"
		),
		'site_control' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['site_control'],
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange' => true),
			'sql'                     => "char(1) NOT NULL default '1'"
		),
		'layouts' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['layouts'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'foreignKey'              => 'tl_layout.name',
			'eval'                    => array('multiple'=>true,'mandatory'=>true),
			'sql'                     => "blob NULL",
            'options_callback'           => array('tl_mycookietip','getLayouts'),
			'relation'                => array('type'=>'hasMany', 'load'=>'lazy')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_mycookietip']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'clr', 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		)
	)
);


/**
 * Class tl_dca_editor
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Frank Thonak www.thomkit.de
 * @author     Frank Thonak
 * @package    dca_editor
 */
class tl_mycookietip extends Backend
{

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
        {
	           $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1));
               $this->redirect($this->getReferer());
        }

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}

	/**
	 * Disable/enable
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		$this->import('dca_editor');
		// Update the database
		$this->Database->prepare("UPDATE tl_mycookietip SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);
        $this->dca_editor->generateAllFiles();
	}



	public function getLayouts()
	{

		$retVal = array();
		$objLayouts = $this->Database->execute("SELECT layouts FROM tl_mycookietip WHERE site_control = 0");
		if($objLayouts->next()) return $retVal;

		$layoutList = '0';
		$objLayouts = $this->Database->execute("SELECT layouts FROM tl_mycookietip WHERE id != ".\input::get('id')." AND site_control = 1 AND layouts != ''");
		while($objLayouts->next())
		{
			$layoutList .= ','.implode(',',deserialize($objLayouts->layouts));
		}

		$objLayouts = $this->Database->execute("SELECT id,name FROM tl_layout WHERE id NOT IN (".$layoutList.")");
		while($objLayouts->next())
		{
			$retVal[$objLayouts->id] = $objLayouts->name;
		}

		return $retVal;

	}


	public function getLabel($a)
	{
		$layouts = '<span style="color:#ff0000;">alle Layouts</span>';
		if($a[site_control] == 1)
		{
			$objLayouts = $this->Database->execute("SELECT name FROM tl_layout WHERE id IN(".implode(',',deserialize($a[layouts])).")");
			$layouts = "";
			while($objLayouts->next())
			{
				if($layouts != '') $layouts .= ', ';
				$layouts .= $objLayouts->name;
			}
		}

		return '<strong>'.$a[name].'</strong> --- <strong>'.$a[runtime].'</strong> Tage --- Layouts: <strong>'.$layouts.'</strong>';

	}

}



?>
