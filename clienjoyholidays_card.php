<?php
/* Copyright (C) 2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
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
 *    \file       clienjoyholidays_card.php
 *        \ingroup    clienjoyholidays
 *        \brief      Page to create/edit/view clienjoyholidays
 */

//if (! defined('NOREQUIREDB'))              define('NOREQUIREDB', '1');				// Do not create database handler $db
//if (! defined('NOREQUIREUSER'))            define('NOREQUIREUSER', '1');				// Do not load object $user
//if (! defined('NOREQUIRESOC'))             define('NOREQUIRESOC', '1');				// Do not load object $mysoc
//if (! defined('NOREQUIRETRAN'))            define('NOREQUIRETRAN', '1');				// Do not load object $langs
//if (! defined('NOSCANGETFORINJECTION'))    define('NOSCANGETFORINJECTION', '1');		// Do not check injection attack on GET parameters
//if (! defined('NOSCANPOSTFORINJECTION'))   define('NOSCANPOSTFORINJECTION', '1');		// Do not check injection attack on POST parameters
//if (! defined('NOCSRFCHECK'))              define('NOCSRFCHECK', '1');				// Do not check CSRF attack (test on referer + on token if option MAIN_SECURITY_CSRF_WITH_TOKEN is on).
//if (! defined('NOTOKENRENEWAL'))           define('NOTOKENRENEWAL', '1');				// Do not roll the Anti CSRF token (used if MAIN_SECURITY_CSRF_WITH_TOKEN is on)
//if (! defined('NOSTYLECHECK'))             define('NOSTYLECHECK', '1');				// Do not check style html tag into posted data
//if (! defined('NOREQUIREMENU'))            define('NOREQUIREMENU', '1');				// If there is no need to load and show top and left menu
//if (! defined('NOREQUIREHTML'))            define('NOREQUIREHTML', '1');				// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))            define('NOREQUIREAJAX', '1');       	  	// Do not load ajax.lib.php library
//if (! defined("NOLOGIN"))                  define("NOLOGIN", '1');					// If this page is public (can be called outside logged session). This include the NOIPCHECK too.
//if (! defined('NOIPCHECK'))                define('NOIPCHECK', '1');					// Do not check IP defined into conf $dolibarr_main_restrict_ip
//if (! defined("MAIN_LANG_DEFAULT"))        define('MAIN_LANG_DEFAULT', 'auto');					// Force lang to a particular value
//if (! defined("MAIN_AUTHENTICATION_MODE")) define('MAIN_AUTHENTICATION_MODE', 'aloginmodule');	// Force authentication handler
//if (! defined("NOREDIRECTBYMAINTOLOGIN"))  define('NOREDIRECTBYMAINTOLOGIN', 1);		// The main.inc.php does not make a redirect if not logged, instead show simple error message
//if (! defined("FORCECSP"))                 define('FORCECSP', 'none');				// Disable all Content Security Policies
//if (! defined('CSRFCHECK_WITH_TOKEN'))     define('CSRFCHECK_WITH_TOKEN', '1');		// Force use of CSRF protection with tokens even for GET
//if (! defined('NOBROWSERNOTIF'))     		 define('NOBROWSERNOTIF', '1');				// Disable browser notification

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"] . "/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME'];
$tmp2 = realpath(__FILE__);
$i = strlen($tmp) - 1;
$j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1)) . "/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1)) . "/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1))) . "/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1))) . "/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT . '/core/class/html.formcompany.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/class/html.formprojet.class.php';
require_once DOL_DOCUMENT_ROOT . "/ticket/class/ticket.class.php";
dol_include_once('/clienjoyholidays/class/clienjoyholidays.class.php');
dol_include_once('/clienjoyholidays/lib/clienjoyholidays_clienjoyholidays.lib.php');

// Load translation files required by the page
$langs->loadLangs(array("clienjoyholidays@clienjoyholidays", "other"));

// Get parameters
$fk_task = GETPOST('fk_task', 'int');
$fk_ticket = GETPOST('fk_ticket', 'int');
$id = GETPOST('id', 'int');
$ref = GETPOST('ref', 'alpha');
$action = GETPOST('action', 'aZ09');
$confirm = GETPOST('confirm', 'alpha');
$cancel = GETPOST('cancel', 'aZ09');
$contextpage = GETPOST('contextpage', 'aZ') ? GETPOST('contextpage', 'aZ') : 'clienjoyholidayscard'; // To manage different context of search
$backtopage = GETPOST('backtopage', 'alpha');
$backtopageforcancel = GETPOST('backtopageforcancel', 'alpha');
//$lineid   = GETPOST('lineid', 'int');

// Initialize technical objects
$object = new CliEnjoyHolidays($db);
$extrafields = new ExtraFields($db);
$diroutputmassaction = $conf->clienjoyholidays->dir_output . '/temp/massgeneration/' . $user->id;
$hookmanager->initHooks(array('clienjoyholidayscard', 'globalcard')); // Note that conf->hooks_modules contains array


// Fetch optionals attributes and labels
$extrafields->fetch_name_optionals_label($object->table_element);

$search_array_options = $extrafields->getOptionalsFromPost($object->table_element, '', 'search_');

// Initialize array of search criterias
$search_all = GETPOST("search_all", 'alpha');
$search = array();
foreach ($object->fields as $key => $val) {
	if (GETPOST('search_' . $key, 'alpha')) {
		$search[$key] = GETPOST('search_' . $key, 'alpha');
	}
}

if (empty($action) && empty($id) && empty($ref)) {
	$action = 'view';
}

// Load object
include DOL_DOCUMENT_ROOT . '/core/actions_fetchobject.inc.php'; // Must be include, not include_once.

$permissiontoread = $user->rights->clienjoyholidays->clienjoyholidays->read;
$permissiontoadd = $user->rights->clienjoyholidays->clienjoyholidays->write; // Used by the include of actions_addupdatedelete.inc.php and actions_lineupdown.inc.php
$permissiontodelete = $user->rights->clienjoyholidays->clienjoyholidays->delete || ($permissiontoadd && isset($object->status) && $object->status == $object::STATUS_DRAFT);
$permissionnote = $user->rights->clienjoyholidays->clienjoyholidays->write; // Used by the include of actions_setnotes.inc.php
$permissiondellink = $user->rights->clienjoyholidays->clienjoyholidays->write; // Used by the include of actions_dellink.inc.php
$upload_dir = $conf->clienjoyholidays->multidir_output[isset($object->entity) ? $object->entity : 1] . '/clienjoyholidays';

// Security check (enable the most restrictive one)
//if ($user->socid > 0) accessforbidden();
//if ($user->socid > 0) $socid = $user->socid;
//$isdraft = (($object->status == $object::STATUS_DRAFT) ? 1 : 0);
//restrictedArea($user, $object->element, $object->id, $object->table_element, '', 'fk_soc', 'rowid', $isdraft);
//if (empty($conf->clienjoyholidays->enabled)) accessforbidden();
//if (!$permissiontoread) accessforbidden();

/*
 * Actions
 */
$addNew = GETPOSTISSET('addnew');
$addCancel = GETPOSTISSET('cancel');

$parameters = array();
$reshook = $hookmanager->executeHooks('doActions', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) {
	setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
}
if (empty($reshook)) {
	$error = 0;

	$backurlforlist = dol_buildpath('/clienjoyholidays/clienjoyholidays_list.php', 1);

	if (empty($backtopage) || ($cancel && empty($id))) {
		if (empty($backtopage) || ($cancel && strpos($backtopage, '__ID__'))) {
			if (empty($id) && (($action != 'add' && $action != 'create') || $cancel)) {
				$backtopage = $backurlforlist;
			} else {
				$backtopage = dol_buildpath('/clienjoyholidays/clienjoyholidays_card.php', 1) . '?id=' . ($id > 0 ? $id : '__ID__');
			}
		}
	}


	// Action clone object and redirect to edit mode
	if ($action == 'confirm_clone' && $confirm == 'yes' && !empty($permissiontoadd)) {
		if (1 == 0 && !GETPOST('clone_content') && !GETPOST('clone_receivers')) {
			setEventMessages($langs->trans("NoCloneOptionsSpecified"), null, 'errors');
		} else {
			$objectutil = dol_clone($object, 1); // To avoid to denaturate loaded object when setting some properties for clone or if createFromClone modifies the object. We use native clone to keep this->db valid.
			$result = $objectutil->createFromClone($user, (($object->id > 0) ? $object->id : $id));
			if (is_object($result) || $result > 0) {
				$newid = 0;
				if (is_object($result)) $newid = $result->id;
				else $newid = $result;
				header("Location: " . $_SERVER['PHP_SELF'] . '?id=' . $newid . '&action=edit'); // Open record of new object
				exit;
			} else {
				setEventMessages($objectutil->error, $objectutil->errors, 'errors');
				$action = '';
			}
		}
	}


	if ($action == 'add' && $addCancel) {
		header("Location: " . $backtopage); // Open record of new object
		exit;
	}

	if ($action == 'add') {
		if ($fk_ticket > 0) {
			$object->fk_ticket = $fk_ticket;
			$backtopage = 'clienjoyholidays_card.php?id=__ID__';
		}
	}

	if ($action == 'add' && $addNew) {
		$backtopage = dol_buildpath('/clienjoyholidays/clienjoyholidays_card.php', 1) . '?action=create';

	}

	$saveAddNew = GETPOSTISSET('saveaddnew');
	$redirectBackToPage = null;
	if ($action == 'update' && $saveAddNew) {
		$redirectBackToPage = true;
	}

	if ($action === 'update') {

		$status = GETPOST('status', 'int');
	}
	// Actions cancel, add, update, update_extras, confirm_validate, confirm_delete, confirm_deleteline, confirm_clone, confirm_close, confirm_setdraft, confirm_reopen
	include DOL_DOCUMENT_ROOT . '/core/actions_addupdatedelete.inc.php';


	if ($action == 'add' && $fk_ticket > 0) {
		$object->add_object_linked('ticket', $fk_ticket);
	}

	// Actions when linking object each other
	include DOL_DOCUMENT_ROOT . '/core/actions_dellink.inc.php';

	// Actions when printing a doc from card
	include DOL_DOCUMENT_ROOT . '/core/actions_printing.inc.php';

	// Action to move up and down lines of object
	//include DOL_DOCUMENT_ROOT.'/core/actions_lineupdown.inc.php';


	$saveAddNew = GETPOSTISSET('saveaddnew');
	if ($redirectBackToPage == true && $textCommercial == !null) {
		$backtopage = dol_buildpath('/clienjoyholidays/clienjoyholidays_card.php', 1) . '?action=create';
		header("Location: " . $backtopage); // Open record of new object
		exit;
	}
	/*
	 * View
	 *
	 * Put here all code to build page
	 */
	$form = new Form($db);
	$formfile = new FormFile($db);


	$title = $langs->trans("CliEnjoyHolidays");
	$help_url = '';
	llxHeader('', $title, $help_url, '', '', '', '', array("clienjoyholidays/css/clienjoyholidays.css"));

// fields fk_soc & fk_project in view


// Example : Adding jquery code
// print '<script type="text/javascript" language="javascript">
// jQuery(document).ready(function() {
// 	function init_myfunc()
// 	{
// 		jQuery("#myid").removeAttr(\'disabled\');
// 		jQuery("#myid").attr(\'disabled\',\'disabled\');
// 	}
// 	init_myfunc();
// 	jQuery("#mybutton").click(function() {
// 		init_myfunc();
// 	});
// });
// </script>';


// Part to create
	if ($action == 'create') {

		print load_fiche_titre($langs->trans("NewObject", $langs->transnoentitiesnoconv("CliEnjoyHolidays")), '', 'object_' . $object->picto);
		print '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">';
		print '<input type="hidden" name="token" value="' . newToken() . '">';
		print '<input type="hidden" name="action" value="add">';

		if ($fk_ticket > 0) {
			print '<input type="hidden" name="fk_ticket" value="' . $fk_ticket . '">';
		}
		if ($backtopage) {
			print '<input type="hidden" name="backtopage" value="' . $backtopage . '">';
		}
		if ($backtopageforcancel) {
			print '<input type="hidden" name="backtopageforcancel" value="' . $backtopageforcancel . '">';
		}
		print dol_get_fiche_head(array(), '');

		// Set some default values
		//if (! GETPOSTISSET('fieldname')) $_POST['fieldname'] = 'myvalue';

		print '<table class="border centpercent tableforfieldcreate">' . "\n";

		// Ref
//    print '<tr><td class="titlefieldcreate fieldrequired">'.$langs->trans('Ref').'</td><td>'.$langs->trans("Draft").'</td></tr>';
//    $object->fields['ref']['visible'] = 0;

		// Common attributes
		include DOL_DOCUMENT_ROOT . '/core/tpl/commonfields_add.tpl.php';

		// Other attributes
		include DOL_DOCUMENT_ROOT . '/core/tpl/extrafields_add.tpl.php';

		print '</table>' . "\n";

		print dol_get_fiche_end();

		print '<div class="center">';
		print '<input type="submit" class="button" name="add" value="' . dol_escape_htmltag($langs->trans("Create")) . '">';
		print '&nbsp; ';
		print '<input type="' . ($backtopage ? "submit" : "button") . '" class="button button-cancel" name="cancel" value="' . dol_escape_htmltag($langs->trans("Cancel")) . '"' . ($backtopage ? '' : ' onclick="javascript:history.go(-1)"') . '>'; // Cancel for create does not post form if we don't know the backtopage
		print '</div>';

		print '</form>';
		//dol_set_focus('input[name="ref"]');

	}

// Part to edit record
	if (($id || $ref) && $action == 'edit') {

		print load_fiche_titre($langs->trans("CliEnjoyHolidays"), '', 'object_' . $object->picto);

		print '<form method="POST" action="' . $_SERVER["PHP_SELF"] . '">';
		print '<input type="hidden" name="token" value="' . newToken() . '">';
		print '<input type="hidden" name="action" value="update">';
		print '<input type="hidden" name="id" value="' . $object->id . '">';
		if ($backtopage) {
			print '<input type="hidden" name="backtopage" value="' . $backtopage . '">';
		}
		if ($backtopageforcancel) {
			print '<input type="hidden" name="backtopageforcancel" value="' . $backtopageforcancel . '">';
		}

		print dol_get_fiche_head();

		print '<table class="border centpercent tableforfieldedit">' . "\n";

		// Common attributes
		include DOL_DOCUMENT_ROOT . '/core/tpl/commonfields_edit.tpl.php';

		// Other attributes
		include DOL_DOCUMENT_ROOT . '/core/tpl/extrafields_edit.tpl.php';

		print '</table>';

		print dol_get_fiche_end();

		print '<div class="center"><input type="submit" class="button button-save" name="save" value="' . $langs->trans("Save") . '">';
		print ' &nbsp; <input type="submit" class="button button-cancel" name="cancel" value="' . $langs->trans("Cancel") . '">';
		print '</div>';

		print '</form>';
	}

// Part to show record
	if ($object->id > 0 && (empty($action) || ($action != 'edit' && $action != 'create'))) {
		$res = $object->fetch_optionals();
//	$object->fields['commercial_text']['position'] = 999;
//	$object->fields['detailed_feature_specification']['position'] = 1000;
//	$object->fields['tech_detail']['position'] = 1001;

		$head = clienjoyholidaysPrepareHead($object);
		print dol_get_fiche_head($head, 'card', $langs->trans("Workstation"), -1, $object->picto);

		$formconfirm = '';


		// Confirmation to delete
		if ($action == 'delete') {
			$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('CEHDeleteCliEnjoyHolidays'), $langs->trans('ConfirmDeleteObject'), 'confirm_delete', '', 0, 1);
		}
		// Confirmation to delete line
		if ($action == 'deleteline') {
			$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('DeleteLine'), $langs->trans('ConfirmDeleteLine'), 'confirm_deleteline', '', 0, 1);
		}
		// Clone confirmation
		if ($action == 'clone') {
			// Create an array for form
			$formquestion = array();
			$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('ToClone'), $langs->trans('ConfirmCloneAsk', $object->ref), 'confirm_clone', $formquestion, 'yes', 1);
		}

		// Confirmation of action xxxx
		if ($action == 'xxx') {
			$formquestion = array();
			/*
			$forcecombo=0;
			if ($conf->browser->name == 'ie') $forcecombo = 1;	// There is a bug in IE10 that make combo inside popup crazy
			$formquestion = array(
				// 'text' => $langs->trans("ConfirmClone"),
				// array('type' => 'checkbox', 'name' => 'clone_content', 'label' => $langs->trans("CloneMainAttributes"), 'value' => 1),
				// array('type' => 'checkbox', 'name' => 'update_prices', 'label' => $langs->trans("PuttingPricesUpToDate"), 'value' => 1),
				// array('type' => 'other',    'name' => 'idwarehouse',   'label' => $langs->trans("SelectWarehouseForStockDecrease"), 'value' => $formproduct->selectWarehouses(GETPOST('idwarehouse')?GETPOST('idwarehouse'):'ifone', 'idwarehouse', '', 1, 0, 0, '', 0, $forcecombo))
			);
			*/
			$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('XXX'), $text, 'confirm_xxx', $formquestion, 0, 1, 220);
		}

		// Call Hook formConfirm
		$parameters = array('formConfirm' => $formconfirm);
		$reshook = $hookmanager->executeHooks('formConfirm', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
		if (empty($reshook)) {
			$formconfirm .= $hookmanager->resPrint;
		} elseif ($reshook > 0) {
			$formconfirm = $hookmanager->resPrint;
		}

		// Print form confirm
		print $formconfirm;

		// Object card
		// ------------------------------------------------------------
		$linkback = '<a href="' . dol_buildpath('/clienjoyholidays/clienjoyholidays_list.php', 1) . '?restore_lastsearch_values=1' . (!empty($socid) ? '&socid=' . $socid : '') . '">' . $langs->trans("BackToList") . '</a>';

		$morehtmlref = '<div class="refidno">';


		// Ref customer
		//$morehtmlref .= $form->editfieldkey("RefCustomer", 'ref_client', $object->ref_client, $object, 0, 'string', '', 0, 1);
		//$morehtmlref .= $form->editfieldval("RefCustomer", 'ref_client', $object->ref_client, $object, 0, 'string', '', null, null, '', 1);
		// Thirdparty
		//$morehtmlref .= '<br>' . $langs->trans('ThirdParty') . ' : ' . (is_object($object->thirdparty) ? $object->thirdparty->getNomUrl(1) : '');


		$morehtmlref .= '</div>';

		dol_banner_tab($object, 'ref', $linkback, 1, 'ref', 'ref', $morehtmlref);

		print '<div class="fichecenter">';
		print '<div class="fichehalfleft">';
		print '<div class="underbanner clearboth"></div>';
		print '<table class="border centpercent tableforfield">' . "\n";

		// Common attributes
		$keyforbreak = 'commercial_text';    // We change column just before this field
		//unset($object->fields['fk_project']);				// Hide field already shown in banner
		//unset($object->fields['fk_soc']);					// Hide field already shown in banner
		include DOL_DOCUMENT_ROOT . '/core/tpl/commonfields_view.tpl.php';


		// Other attributes. Fields from hook formObjectOptions and Extrafields.
		include DOL_DOCUMENT_ROOT . '/core/tpl/extrafields_view.tpl.php';

		print '</table>';
		print '</div>';
		print '</div>';

		print '<div class="clearboth"></div>';

		print dol_get_fiche_end();

		/*
		 * Lines
		 */

		if (!empty($object->table_element_line)) {
			// Show object lines
			$result = $object->getLinesArray();

			print '	<form name="addproduct" id="addproduct" action="' . $_SERVER["PHP_SELF"] . '?id=' . $object->id . (($action != 'editline') ? '' : '#line_' . GETPOST('lineid', 'int')) . '" method="POST">
		<input type="hidden" name="token" value="' . newToken() . '">
		<input type="hidden" name="action" value="' . (($action != 'editline') ? 'addline' : 'updateline') . '">
		<input type="hidden" name="mode" value="">
		<input type="hidden" name="page_y" value="">
		<input type="hidden" name="id" value="' . $object->id . '">
		';

			if (!empty($conf->use_javascript_ajax) && $object->status == 0) {
				include DOL_DOCUMENT_ROOT . '/core/tpl/ajaxrow.tpl.php';
			}

			print '<div class="div-table-responsive-no-min">';
			if (!empty($object->lines) || ($object->status == $object::STATUS_DRAFT && $permissiontoadd && $action != 'selectlines' && $action != 'editline')) {
				print '<table id="tablelines" class="noborder noshadow" width="100%">';
			}

			if (!empty($object->lines)) {
				$object->printObjectLines($action, $mysoc, null, GETPOST('lineid', 'int'), 1);
			}

			// Form to add new line
			if ($object->status == 0 && $permissiontoadd && $action != 'selectlines') {
				if ($action != 'editline') {
					// Add products/services form

					$parameters = array();
					$reshook = $hookmanager->executeHooks('formAddObjectLine', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
					if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
					if (empty($reshook))
						$object->formAddObjectLine(1, $mysoc,);
				}
			}

			if (!empty($object->lines) || ($object->status == $object::STATUS_DRAFT && $permissiontoadd && $action != 'selectlines' && $action != 'editline')) {
				print '</table>';
			}
			print '</div>';

			print "</form>\n";
		}

		// Buttons for actions

		if ($action != 'presend' && $action != 'editline') {
			print '<div class="tabsAction">' . "\n";
			$parameters = array();
			$reshook = $hookmanager->executeHooks('addMoreActionsButtons', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
			if ($reshook < 0) {
				setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
			}
			if (empty($reshook)) {

				// Back to draft
				if ($object->status == $object::STATUS_VALIDATED) {
					print dolGetButtonAction($langs->trans('SetToDraft'), '', 'default', $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&action=confirm_setdraft&confirm=yes&token=' . newToken(), '', $permissiontoadd);
				} else {
					print dolGetButtonAction($langs->trans('Modify'), '', 'default', $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&action=edit&token=' . newToken(), '', $permissiontoadd);
				}
				// Validate
				if ($object->status == $object::STATUS_DRAFT) {
					if (empty($object->table_element_line) || (is_array($object->lines) && count($object->lines) > 0)) {
						print dolGetButtonAction($langs->trans('Validate'), '', 'default', $_SERVER['PHP_SELF'] . '?id=' . $object->id . '&action=confirm_validate&confirm=yes&token=' . newToken(), '', $permissiontoadd);
					} else {
						$langs->load("errors");
						print dolGetButtonAction($langs->trans("ErrorAddAtLeastOneLineFirst"), $langs->trans("Validate"), 'default', '#', '', 0);
					}
				}

				// Clone
				print dolGetButtonAction($langs->trans('ToClone'), '', 'default', $_SERVER['PHP_SELF'] . '?id=' . $object->id . '&action=clone&token=' . newToken(), '', $permissiontoadd);

				/*
				if ($permissiontoadd) {
					if ($object->status == $object::STATUS_ENABLED) {
						print dolGetButtonAction($langs->trans('Disable'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=disable&token='.newToken(), '', $permissiontoadd);
					} else {
						print dolGetButtonAction($langs->trans('Enable'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=enable&token='.newToken(), '', $permissiontoadd);
					}
				}
				if ($permissiontoadd) {
					if ($object->status == $object::STATUS_VALIDATED) {
						print dolGetButtonAction($langs->trans('Cancel'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=close&token='.newToken(), '', $permissiontoadd);
					} else {
						print dolGetButtonAction($langs->trans('Re-Open'), '', 'default', $_SERVER['PHP_SELF'].'?id='.$object->id.'&action=reopen&token='.newToken(), '', $permissiontoadd);
					}
				}
				*/

				// Delete (need delete permission, or if draft, just need create/modify permission)
				print dolGetButtonAction($langs->trans('Delete'), '', 'delete', $_SERVER['PHP_SELF'] . '?id=' . $object->id . '&action=delete&token=' . newToken(), '', $permissiontodelete || ($object->status == $object::STATUS_DRAFT && $permissiontoadd));
			}
			print '</div>' . "\n";
		}


		// Show links to link elements
		$somethingshown = $form->showLinkedObjectBlock($object);

		print '</div><div class="fichehalfright"><div class="ficheaddleft">';

		$MAXEVENT = 10;

		$morehtmlright = '<a href="' . dol_buildpath('/clienjoyholidays/clienjoyholidays_agenda.php', 1) . '?id=' . $object->id . '">';
		$morehtmlright .= $langs->trans("SeeAll");
		$morehtmlright .= '</a>';

		// List of actions on element
		include_once DOL_DOCUMENT_ROOT . '/core/class/html.formactions.class.php';
		$formactions = new FormActions($db);
		$somethingshown = $formactions->showactions($object, $object->element . '@' . $object->module, (is_object($object->thirdparty) ? $object->thirdparty->id : 0), 1, '', $MAXEVENT, '', $morehtmlright);

		print '</div></div></div>';
	}


// Presend form

	$defaulttopic = 'InformationMessage';
	$diroutput = $conf->clienjoyholidays->dir_output;
	$trackid = 'clienjoyholidays' . $object->id;

	include DOL_DOCUMENT_ROOT . '/core/tpl/card_presend.tpl.php';
}

// End of page
llxFooter();
$db->close();
