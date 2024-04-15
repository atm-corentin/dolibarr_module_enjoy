<?php
/* Copyright (C) 2004-2018  Laurent Destailleur     <eldy@users.sourceforge.net>
 * Copyright (C) 2018-2019  Nicolas ZABOURI         <info@inovea-conseil.com>
 * Copyright (C) 2019-2020  Frédéric France         <frederic.france@netlogic.fr>
 * Copyright (C) 2021 SuperAdmin
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * 	\defgroup   clienjoyholidays     Module EnjoyHolidays
 *  \brief      EnjoyHolidays module descriptor.
 *
 *  \file       htdocs/clienjoyholidays/core/modules/modCliEnjoyHolidays.class.php
 *  \ingroup    clienjoyholidays
 *  \brief      Description and activation file for module EnjoyHolidays
 */
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

/**
 *  Description and activation class for module EnjoyHolidays
 */
class modClienjoyHolidays extends DolibarrModules
{
	/**
	 * Constructor. Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db Database handler
	 */
	public function __construct($db)
	{
		global $langs, $conf;
		$this->db = $db;

		// Id for module (must be unique).
		// Use here a free id (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 104199; // TODO Go on page https://wiki.dolibarr.org/index.php/List_of_modules_id to reserve an id number for your module

		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'clienjoyholidays';

		// Family can be 'base' (core modules),'crm','financial','hr','projects','products','ecm','technic' (transverse modules),'interface' (link with external tools),'other','...'
		// It is used to group modules by family in module setup page
		$this->family = "ATM Consulting";

		// Module position in the family on 2 digits ('01', '10', '20', ...)
		$this->module_position = '90';

		// Gives the possibility for the module, to provide his own family info and position of this family (Overwrite $this->family and $this->module_position. Avoid this)
		//$this->familyinfo = array('myownfamily' => array('position' => '01', 'label' => $langs->trans("MyOwnFamily")));
		// Module label (no space allowed), used if translation string 'ModuleclienjoyholidaysName' not found (clienjoyholidays is name of module).
		$this->name = preg_replace('/^mod/i', '', get_class($this));

		// Module description, used if translation string 'ModuleenjoyholidaysDesc' not found (Enjoyholidays is name of module).
		$this->description = "CEH_description";
		// Used only if file README.md and README-LL.md not found.
		$this->descriptionlong = "CEH_description";

		// Author
		$this->editor_name = 'ATM Consulting';
		$this->editor_url = 'https://www.atm-consulting.fr';

		// Possible values for version are: 'development', 'experimental', 'dolibarr', 'dolibarr_deprecated' or a version string like 'x.y.z'

		$this->version = '1.0.1';

		// Url to the file with your last numberversion of this module
		/*require_once __DIR__ . '/../../class/techatm.class.php';
		$this->url_last_version = \clienjoyholidays\TechATM::getLastModuleVersionUrl($this);*/

		// Key used in llx_const table to save module status enabled/disabled (where clienjoyholidays is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);

		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png, use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png, use this->picto='pictovalue@module'
		// To use a supported fa-xxx css style of font awesome, use this->picto='xxx'
		$this->picto = 'clienjoyholidaysmodule@clienjoyholidays';

		// Define some features supported by module (triggers, login, substitutions, menus, css, etc...)
		$this->module_parts = array(
			// Set this to 1 if module has its own login method file (core/login)
			'login' => 0,
			// Set this to 1 if module has its own substitution function file (core/substitutions)
			'substitutions' => 0,
			// Set this to 1 if module has its own menus handler directory (core/menus)
			'menus' => 0,
			// Set this to 1 if module overwrite template dir (core/tpl)
			'tpl' => 0,
			// Set this to 1 if module has its own printing directory (core/modules/printing)
			'printing' => 0,
			// Set this to 1 if module has its own theme directory (theme)
			'theme' => 0,
			// Set this to relative path of css file if module has its own css file
			'css' => array(
				//    '/clienjoyholidays/css/clienjoyholidays.css.php',
			),
			// Set this to relative path of js file if module must load a js on all pages
			'js' => array(
				//   '/clienjoyholidays/js/clienjoyholidays.js.php',
			),
			// Set here all hooks context managed by module. To find available hook context, make a "grep -r '>initHooks(' *" on source code. You can also set hook context to 'all'
			'hooks' => array(
			),
			// Set this to 1 if features of module are opened to external users
			'moduleforexternal' => 0,
		);

		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/clienjoyholidays/temp","/clienjoyholidays/subdir");
		$this->dirs = array("/clienjoyholidays/temp");

		// Config pages. Put here list of php page, stored into clienjoyholidays/admin directory, to use to setup module.
		//$this->config_page_url = array("setup.php@clienjoyholidays");

		// Dependencies
		// A condition to hide module
		$this->hidden = false;
		// List of module class names as string that must be enabled if this module is enabled. Example: array('always1'=>'modModuleToEnable1','always2'=>'modModuleToEnable2', 'FR1'=>'modModuleToEnableFR'...)
		$this->depends = array();
		$this->requiredby = array(); // List of module class names as string to disable if this one is disabled. Example: array('modModuleToDisable1', ...)
		$this->conflictwith = array(); // List of module class names as string this module is in conflict with. Example: array('modModuleToDisable1', ...)

		// The language file dedicated to your module
		$this->langfiles = array("clienjoyholidays@clienjoyholidays");

		// Prerequisites
		$this->phpmin = array(7, 6); // Minimum version of PHP required by module
		$this->need_dolibarr_version = array(19, -3); // Minimum version of Dolibarr required by module

		// Messages at activation
		$this->warnings_activation = array(); // Warning to show when we activate module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		$this->warnings_activation_ext = array(); // Warning to show when we activate an external module. array('always'='text') or array('FR'='textfr','ES'='textes'...)
		//$this->automatic_activation = array('FR'=>'EnjoyHolidaysWasAutomaticallyActivatedBecauseOfYourCountryChoice');
		//$this->always_enabled = true;								// If true, can't be disabled

		// Constants
		// List of particular constants to add when module is enabled (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		// Example: $this->const=array(1 => array('ENJOYHOLIDAYS_MYNEWCONST1', 'chaine', 'myvalue', 'This is a constant to add', 1),
		//                             2 => array('ENJOYHOLIDAYS_MYNEWCONST2', 'chaine', 'myvalue', 'This is another constant to add', 0, 'current', 1)
		// );
		$this->const = array();

		// Example:
		// $this->tabs[] = array('data'=>'objecttype:+tabname1:Title1:mylangfile@clienjoyholidays:$user->rights->clienjoyholidays->read:/clienjoyholidays/mynewtab1.php?id=__ID__');  					// To add a new tab identified by code tabname1
		// $this->tabs[] = array('data'=>'objecttype:+tabname2:SUBSTITUTION_Title2:mylangfile@clienjoyholidays:$user->rights->othermodule->read:/clienjoyholidays/mynewtab2.php?id=__ID__',  	// To add another new tab identified by code tabname2. Label will be result of calling all substitution functions on 'Title2' key.
		// $this->tabs[] = array('data'=>'objecttype:-tabname:NU:conditiontoremove');                                                     										// To remove an existing tab identified by code tabname
		//
		// Where objecttype can be
		// 'categories_x'	  to add a tab in category view (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// 'contact'          to add a tab in contact view
		// 'contract'         to add a tab in contract view
		// 'group'            to add a tab in group view
		// 'intervention'     to add a tab in intervention view
		// 'invoice'          to add a tab in customer invoice view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'member'           to add a tab in fundation member view
		// 'opensurveypoll'	  to add a tab in opensurvey poll view
		// 'order'            to add a tab in customer order view
		// 'order_supplier'   to add a tab in supplier order view
		// 'payment'		  to add a tab in payment view
		// 'payment_supplier' to add a tab in supplier payment view
		// 'product'          to add a tab in product view
		// 'propal'           to add a tab in propal view
		// 'project'          to add a tab in project view
		// 'stock'            to add a tab in stock view
		// 'thirdparty'       to add a tab in third party view
		// 'user'             to add a tab in user view

		// Dictionaries

		$this->dictionaries=array(
			'langs'=>'clienjoyholidays@clienjoyhoidays',
			'tabname'=>array("c_transport_mod"),// List of tables we want to see into dictonnary editor
			'tablib'=>array("Mode de transports"),// Label of tables
			'tabsql'=>array('SELECT rowid,entity,code, label, active FROM '.MAIN_DB_PREFIX.'c_transport_mod'),// Request to select fields
			'tabsqlsort'=>array("code ASC"),// Sort order
			'tabfield'=>array("code,label"),// List of fields (result of select to show dictionary)
			'tabfieldvalue'=>array("code,label"), // List of fields (list of fields to edit a record)
			'tabfieldinsert'=>array("code,label"),// List of fields (list of fields for insert)
			'tabrowid'=>array("rowid"),	// Name of columns with primary key (try to always name it 'rowid')
			'tabcond'=>array($conf->clienjoyholidays->enabled),	// Condition to show each dictionary
			'tabhelp' => array(array())
		);


		// Boxes/Widgets
		// Add here list of php file(s) stored in clienjoyholidays/core/boxes that contains a class to show a widget.
		$this->boxes = array(
		);

		// Cronjobs (List of cron jobs entries to add when module is enabled)
		// unit_frequency must be 60 for minute, 3600 for hour, 86400 for day, 604800 for week
		$this->cronjobs = array(
		);
		// Example: $this->cronjobs=array(
		//    0=>array('label'=>'My label', 'jobtype'=>'method', 'class'=>'/dir/class/file.class.php', 'objectname'=>'MyClass', 'method'=>'myMethod', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>2, 'unitfrequency'=>3600, 'status'=>0, 'test'=>'$conf->clienjoyholidays->enabled', 'priority'=>50),
		//    1=>array('label'=>'My label', 'jobtype'=>'command', 'command'=>'', 'parameters'=>'param1, param2', 'comment'=>'Comment', 'frequency'=>1, 'unitfrequency'=>3600*24, 'status'=>0, 'test'=>'$conf->clienjoyholidays->enabled', 'priority'=>50)
		// );

		// Permissions provided by this module
		$this->rights = array();
		$r = 0;
		// Add here entries to declare new permissions
		/* BEGIN MODULEBUILDER PERMISSIONS */
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = $langs->trans("ReadobjectsofCliEnjoyHolidays"); // Permission label
		$this->rights[$r][4] = 'clienjoyholidays';
		$this->rights[$r][5] = 'read'; // In php code, permission will be checked by test if ($user->rights->clienjoyholidays->clienjoyholidays->read)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = $langs->trans("CreateUpdateobjectsofCliEnjoyHolidays"); // Permission label
		$this->rights[$r][4] = 'clienjoyholidays';
		$this->rights[$r][5] = 'write'; // In php code, permission will be checked by test if ($user->rights->clienjoyholidays->clienjoyholidays->write)
		$r++;
		$this->rights[$r][0] = $this->numero . sprintf("%02d", $r + 1); // Permission id (must not be already used)
		$this->rights[$r][1] = $langs->trans("DeleteobjectsofCliEnjoyHolidays"); // Permission label
		$this->rights[$r][4] = 'clienjoyholidays';
		$this->rights[$r][5] = 'delete'; // In php code, permission will be checked by test if ($user->rights->clienjoyholidays->clienjoyholidays->delete)
		//$r++;
		/* END MODULEBUILDER PERMISSIONS */

		// Main menu entries to add
		$this->menu = array();
		$r = 0;
		// Add here entries to declare new menus
		/* BEGIN MODULEBUILDER TOPMENU */

		$this->menu[$r++] = array(
			'fk_menu'=>'', // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'top', // This is a Top menu entry
			'titre'=>'ModuleEnjoyholidaysName',
			'prefix' => img_picto('', $this->picto, 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'clienjoyholidaysmain',
			'leftmenu'=>'clienjoyholidays',
			'url'=>'/clienjoyholidays/clienjoyholidays_list.php',
			'langs'=>'clienjoyholidays@clienjoyholidays', // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000 + $r,
			'enabled'=>'$conf->clienjoyholidays->enabled', // Define condition to show or hide menu entry. Use '$conf->clienjoyholidays->enabled' if entry must be visible if module is enabled.
			'perms'=>'1', // Use 'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2, // 0=Menu for internal users, 1=external users, 2=both
		);
		/* END MODULEBUILDER TOPMENU */

		// BEGIN MODULEBUILDER LEFTMENU CLIENJOYHOLIDAYS
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=clienjoyholidaysmain',      // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',                          // This is a Top menu entry
			'titre'=>'Formule de voyage',
			'prefix' => img_picto('', $this->picto, 'class="paddingright pictofixedwidth valignmiddle"'),
			'mainmenu'=>'clienjoyholidaysmain',
			'leftmenu'=>'clienjoyholidays',
			'url'=>'/clienjoyholidays/clienjoyholidays_list.php',
			'langs'=>'clienjoyholidays@clienjoyholidays',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->clienjoyholidays->enabled',  // Define condition to show or hide menu entry. Use '$conf->chiffrage->enabled' if entry must be visible if module is enabled.
			'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read',			                // Use 'perms'=>'$user->rights->chiffrage->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'prefix' => '<span class="fas fa-comment-dollar em092 pictofixedwidth clienjoyholidays-left-menu-picto" style="color: #7e7772;"></span>',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
		);


        $this->menu[$r++]=array(
            'fk_menu'=>'fk_mainmenu=clienjoyholidaysmain,fk_leftmenu=clienjoyholidays',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
            'type'=>'left',			                // This is a Left menu entry
            'titre'=>'New',
            'mainmenu'=>'clienjoyholidaysmain',
            'leftmenu'=>'clienjoyholidays_clienjoyholidays_new',
            'url'=>'/clienjoyholidays/clienjoyholidays_card.php?action=create',
            'langs'=>'clienjoyholidays@clienjoyholidays',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
            'position'=>1000+$r,
            'enabled'=>'$conf->clienjoyholidays->enabled',  // Define condition to show or hide menu entry. Use '$conf->clienjoyholidays->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
            'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read',			                // Use 'perms'=>'$user->rights->clienjoyholidays->level1->level2' if you want your menu with a permission rules
            'target'=>'',
            'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
        );

		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=clienjoyholidaysmain,fk_leftmenu=clienjoyholidays',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Liste',
			'mainmenu'=>'clienjoyholidaysmain',
			'leftmenu'=>'clienjoyholidays_clienjoyholidays_list',
			'url'=>'/clienjoyholidays/clienjoyholidays_list.php',
			'langs'=>'clienjoyholidays@clienjoyholidays',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->clienjoyholidays->enabled',  // Define condition to show or hide menu entry. Use '$conf->clienjoyholidays->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read',			                // Use 'perms'=>'$user->rights->clienjoyholidays->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2,				                // 0=Menu for internal users, 1=external users, 2=both
		);


		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=clienjoyholidaysmain,fk_leftmenu=clienjoyholidays_clienjoyholidays_list',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Brouillon',
			'mainmenu'=>'clienjoyholidaysmain',
			'leftmenu'=>'clienjoyholidays_clienjoyholidays_list_draft',
			'url'=>'/clienjoyholidays/clienjoyholidays_list.php?leftmenu=clienjoyholidays&search_status=0',
			'langs'=>'clienjoyholidays@clienjoyholidays',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->clienjoyholidays->enabled',  // Define condition to show or hide menu entry. Use '$conf->clienjoyholidays->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read',			                // Use 'perms'=>'$user->rights->clienjoyholidays->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2,		                // 0=Menu for internal users, 1=external users, 2=both
		);
		$this->menu[$r++]=array(
			'fk_menu'=>'fk_mainmenu=clienjoyholidaysmain,fk_leftmenu=clienjoyholidays_clienjoyholidays_list',	    // '' if this is a top menu. For left menu, use 'fk_mainmenu=xxx' or 'fk_mainmenu=xxx,fk_leftmenu=yyy' where xxx is mainmenucode and yyy is a leftmenucode
			'type'=>'left',			                // This is a Left menu entry
			'titre'=>'Valide',
			'mainmenu'=>'clienjoyholidaysmain',
			'leftmenu'=>'clienjoyholidays_clienjoyholidays_list_verified',
			'url'=>'/clienjoyholidays/clienjoyholidays_list.php?leftmenu=clienjoyholidays&search_status=1',
			'langs'=>'clienjoyholidays@clienjoyholidays',	        // Lang file to use (without .lang) by module. File must be in langs/code_CODE/ directory.
			'position'=>1000+$r,
			'enabled'=>'$conf->clienjoyholidays->enabled',  // Define condition to show or hide menu entry. Use '$conf->clienjoyholidays->enabled' if entry must be visible if module is enabled. Use '$leftmenu==\'system\'' to show if leftmenu system is selected.
			'perms'=>'$user->rights->clienjoyholidays->clienjoyholidays->read',			                // Use 'perms'=>'$user->rights->clienjoyholidays->level1->level2' if you want your menu with a permission rules
			'target'=>'',
			'user'=>2,		                // 0=Menu for internal users, 1=external users, 2=both
		);






		/* END MODULEBUILDER LEFTMENU CLIENJOYHOLIDAYS */
		// Exports profiles provided by this module
		$r = 1;
		/* BEGIN MODULEBUILDER EXPORT CLIENJOYHOLIDAYS */
		/*
		$langs->load("clienjoyholidays@clienjoyholidays");
		$this->export_code[$r]=$this->rights_class.'_'.$r;
		$this->export_label[$r]='CliEnjoyHolidaysLines';	// Translation key (used only if key ExportDataset_xxx_z not found)
		$this->export_icon[$r]='clienjoyholidays@clienjoyholidays';
		// Define $this->export_fields_array, $this->export_TypeFields_array and $this->export_entities_array
		$keyforclass = 'CliEnjoyHolidays'; $keyforclassfile='/clienjoyholidays/class/clienjoyholidays.class.php'; $keyforelement='clienjoyholidays@clienjoyholidays';
		include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		//$this->export_fields_array[$r]['t.fieldtoadd']='FieldToAdd'; $this->export_TypeFields_array[$r]['t.fieldtoadd']='Text';
		//unset($this->export_fields_array[$r]['t.fieldtoremove']);
		//$keyforclass = 'CliEnjoyHolidaysLine'; $keyforclassfile='/clienjoyholidays/class/clienjoyholidays.class.php'; $keyforelement='clienjoyholidaysline@clienjoyholidays'; $keyforalias='tl';
		//include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		$keyforselect='clienjoyholidays'; $keyforaliasextra='extra'; $keyforelement='clienjoyholidays@clienjoyholidays';
		include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$keyforselect='clienjoyholidaysline'; $keyforaliasextra='extraline'; $keyforelement='clienjoyholidaysline@clienjoyholidays';
		//include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		//$this->export_dependencies_array[$r] = array('clienjoyholidaysline'=>array('tl.rowid','tl.ref')); // To force to activate one or several fields if we select some fields that need same (like to select a unique key if we ask a field of a child to avoid the DISTINCT to discard them, or for computed field than need several other fields)
		//$this->export_special_array[$r] = array('t.field'=>'...');
		//$this->export_examplevalues_array[$r] = array('t.field'=>'Example');
		//$this->export_help_array[$r] = array('t.field'=>'FieldDescHelp');
		$this->export_sql_start[$r]='SELECT DISTINCT ';
		$this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'clienjoyholidays as t';
		//$this->export_sql_end[$r]  =' LEFT JOIN '.MAIN_DB_PREFIX.'clienjoyholidays_line as tl ON tl.fk_clienjoyholidays = t.rowid';
		$this->export_sql_end[$r] .=' WHERE 1 = 1';
		$this->export_sql_end[$r] .=' AND t.entity IN ('.getEntity('clienjoyholidays').')';
		$r++; */
		/* END MODULEBUILDER EXPORT CLIENJOYHOLIDAYS */

		// Imports profiles provided by this module
		$r = 1;
		/* BEGIN MODULEBUILDER IMPORT CLIENJOYHOLIDAYS */
		/*
		 $langs->load("clienjoyholidays@clienjoyholidays");
		 $this->export_code[$r]=$this->rights_class.'_'.$r;
		 $this->export_label[$r]='CliEnjoyHolidaysLines';	// Translation key (used only if key ExportDataset_xxx_z not found)
		 $this->export_icon[$r]='clienjoyholidays@clienjoyholidays';
		 $keyforclass = 'CliEnjoyHolidays'; $keyforclassfile='/clienjoyholidays/class/clienjoyholidays.class.php'; $keyforelement='clienjoyholidays@clienjoyholidays';
		 include DOL_DOCUMENT_ROOT.'/core/commonfieldsinexport.inc.php';
		 $keyforselect='clienjoyholidays'; $keyforaliasextra='extra'; $keyforelement='clienjoyholidays@clienjoyholidays';
		 include DOL_DOCUMENT_ROOT.'/core/extrafieldsinexport.inc.php';
		 //$this->export_dependencies_array[$r]=array('mysubobject'=>'ts.rowid', 't.myfield'=>array('t.myfield2','t.myfield3')); // To force to activate one or several fields if we select some fields that need same (like to select a unique key if we ask a field of a child to avoid the DISTINCT to discard them, or for computed field than need several other fields)
		 $this->export_sql_start[$r]='SELECT DISTINCT ';
		 $this->export_sql_end[$r]  =' FROM '.MAIN_DB_PREFIX.'clienjoyholidays as t';
		 $this->export_sql_end[$r] .=' WHERE 1 = 1';
		 $this->export_sql_end[$r] .=' AND t.entity IN ('.getEntity('clienjoyholidays').')';
		 $r++; */
		/* END MODULEBUILDER IMPORT CLIENJOYHOLIDAYS */
	}

	/**
	 *  Function called when module is enabled.
	 *  The init function add constants, boxes, permissions and menus (defined in constructor) into Dolibarr database.
	 *  It also creates data directories
	 *
	 *  @param      string  $options    Options when enabling module ('', 'noboxes')
	 *  @return     int             	1 if OK, 0 if KO
	 */
	public function init($options = '')
	{
		global $conf, $langs;

		$result = $this->_load_tables('/clienjoyholidays/sql/');
		if ($result < 0) {
			return -1; // Do not activate module if error 'not allowed' returned when loading module SQL queries (the _load_table run sql with run_sql with the error allowed parameter set to 'default')
		}

		// Permissions
		$this->remove($options);

		$sql = array();

		// Document templates
		$moduledir = 'clienjoyholidays';
		$myTmpObjects = array();
		$myTmpObjects['clienjoyholidays'] = array('includerefgeneration'=>0, 'includedocgeneration'=>0);

		foreach ($myTmpObjects as $myTmpObjectKey => $myTmpObjectArray) {
			if ($myTmpObjectKey == 'clienjoyholidays') {
				continue;
			}
			if ($myTmpObjectArray['includerefgeneration']) {
				$src = DOL_DOCUMENT_ROOT.'/install/doctemplates/clienjoyholidays/template_enjoyholidays.odt';
				$dirodt = DOL_DATA_ROOT.'/doctemplates/clienjoyholidays';
				$dest = $dirodt.'/template_clienjoyholidays.odt';

				if (file_exists($src) && !file_exists($dest)) {
					require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
					dol_mkdir($dirodt);
					$result = dol_copy($src, $dest, 0, 0);
					if ($result < 0) {
						$langs->load("errors");
						$this->error = $langs->trans('ErrorFailToCopyFile', $src, $dest);
						return 0;
					}
				}

				$sql = array_merge($sql, array(
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'standard_".strtolower($myTmpObjectKey)."' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('standard_".strtolower($myTmpObjectKey)."','".strtolower($myTmpObjectKey)."',".$conf->entity.")",
					"DELETE FROM ".MAIN_DB_PREFIX."document_model WHERE nom = 'generic_".strtolower($myTmpObjectKey)."_odt' AND type = '".strtolower($myTmpObjectKey)."' AND entity = ".$conf->entity,
					"INSERT INTO ".MAIN_DB_PREFIX."document_model (nom, type, entity) VALUES('generic_".strtolower($myTmpObjectKey)."_odt', '".strtolower($myTmpObjectKey)."', ".$conf->entity.")"
				));
			}
		}

		return $this->_init($sql, $options);
	}

	/**
	 *  Function called when module is disabled.
	 *  Remove from database constants, boxes and permissions from Dolibarr database.
	 *  Data directories are not deleted
	 *
	 *  @param      string	$options    Options when enabling module ('', 'noboxes')
	 *  @return     int                 1 if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();
		return $this->_remove($sql, $options);
	}
}
