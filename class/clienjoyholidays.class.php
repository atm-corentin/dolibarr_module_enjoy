<?php
/* Copyright (C) 2017  Laurent Destailleur <eldy@users.sourceforge.net>
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
 * \file        class/clienjoyholidays.class.php
 * \ingroup     clienjoyholidays
 * \brief       This file is a CRUD class file for CliEnjoyHolidays (Create/Read/Update/Delete)
 */

// Put here all includes required by your class file
require_once DOL_DOCUMENT_ROOT . '/core/class/commonobject.class.php';


/**
 * Class for CliEnjoyHolidays
 */
class CliEnjoyHolidays extends CommonObject
{
	/**
	 * @var string ID of module.
	 */
	public $module = 'clienjoyholidays';

	/**
	 * @var string ID to identify managed object.
	 */
	public $element = 'clienjoyholidays';

	/**
	 * @var string Name of table without prefix where object is stored. This is also the key used for extrafields management.
	 */
	public $table_element = 'clienjoyholidays_clienjoyholidays';

	/**
	 * @var int  Does this object support multicompany module ?
	 * 0=No test on entity, 1=Test with field entity, 'field@table'=Test with link by field@table
	 */
	public $ismultientitymanaged = 0;

	/**
	 * @var int  Does object support extrafields ? 0=No, 1=Yes
	 */
	public $isextrafieldmanaged = 1;

	/**
	 * @var string String with name of icon for clienjoyholidays. Must be the part after the 'object_' into object_clienjoyholidays.png
	 */
	public $picto = 'clienjoyholidays@clienjoyholidays';


	const STATUS_DRAFT = 0;
	const STATUS_VALIDATED = 1;


	/**
	 *  'type' field format ('integer', 'integer:ObjectClass:PathToClass[:AddCreateButtonOrNot[:Filter]]', 'sellist:TableName:LabelFieldName[:KeyFieldName[:KeyFieldParent[:Filter]]]', 'varchar(x)', 'double(24,8)', 'real', 'price', 'text', 'text:none', 'html', 'date', 'datetime', 'timestamp', 'duration', 'mail', 'phone', 'url', 'password')
	 *         Note: Filter can be a string like "(t.ref:like:'SO-%') or (t.date_creation:<:'20160101') or (t.nature:is:NULL)"
	 *  'label' the translation key.
	 *  'picto' is code of a picto to show before value in forms
	 *  'enabled' is a condition when the field must be managed (Example: 1 or '$conf->global->MY_SETUP_PARAM)
	 *  'position' is the sort order of field.
	 *  'notnull' is set to 1 if not null in database. Set to -1 if we must set data to null if empty ('' or 0).
	 *  'visible' says if field is visible in list (Examples: 0=Not visible, 1=Visible on list and create/update/view forms, 2=Visible on list only, 3=Visible on create/update/view form only (not list), 4=Visible on list and update/view form only (not create). 5=Visible on list and view only (not create/not update). Using a negative value means field is not shown by default on list but can be selected for viewing)
	 *  'noteditable' says if field is not editable (1 or 0)
	 *  'default' is a default value for creation (can still be overwrote by the Setup of Default Values if field is editable in creation form). Note: If default is set to '(PROV)' and field is 'ref', the default value will be set to '(PROVid)' where id is rowid when a new record is created.
	 *  'index' if we want an index in database.
	 *  'foreignkey'=>'tablename.field' if the field is a foreign key (it is recommanded to name the field fk_...).
	 *  'searchall' is 1 if we want to search in this field when making a search from the quick search button.
	 *  'isameasure' must be set to 1 if you want to have a total on list for this field. Field type must be summable like integer or double(24,8).
	 *  'css' and 'cssview' and 'csslist' is the CSS style to use on field. 'css' is used in creation and update. 'cssview' is used in view mode. 'csslist' is used for columns in lists. For example: 'css'=>'minwidth300 maxwidth500 widthcentpercentminusx', 'cssview'=>'wordbreak', 'csslist'=>'tdoverflowmax200'
	 *  'help' is a 'TranslationString' to use to show a tooltip on field. You can also use 'TranslationString:keyfortooltiponlick' for a tooltip on click.
	 *  'showoncombobox' if value of the field must be visible into the label of the combobox that list record
	 *  'disabled' is 1 if we want to have the field locked by a 'disabled' attribute. In most cases, this is never set into the definition of $fields into class, but is set dynamically by some part of code.
	 *  'arrayofkeyval' to set a list of values if type is a list of predefined values. For example: array("0"=>"Draft","1"=>"Active","-1"=>"Cancel"). Note that type can be 'integer' or 'varchar'
	 *  'autofocusoncreate' to have field having the focus on a create form. Only 1 field should have this property set to 1.
	 *  'comment' is not used. You can store here any text of your choice. It is not used by application.
	 *
	 *  Note: To have value dynamic, you can set value to 0 in definition and edit the value on the fly into the constructor.
	 */

	// BEGIN MODULEBUILDER PROPERTIES
	/**
	 * @var array  Array with all fields and their property. Do not use it as a static var. It may be modified by constructor.
	 */
	public $fields = [
		'ref' => array('type' => 'varchar(40)', 'label' => 'Ref', 'enabled' => '1', 'position' => 1, 'notnull' => 1, 'visible' => 1, 'index' => 1, 'searchall' => 1, 'showoncombobox' => '1', 'comment' => "Reference of object"),
		'label' => array('type' => 'varchar(160)', 'label' => 'Libelle', 'enabled' => '1', 'position' => 2, 'notnull' => 1, 'visible' => 1),
		'amount' => array('type' => 'price', 'label' => 'Price', 'enabled' => '1', 'notnull' => 0, 'position' => 3, 'visible' => 1),
		'fk_destination_country' => array('type' => 'integer:Ccountry:/core/class/ccountry.class.php', 'label' => 'Pays de destination', 'enabled' => '1', 'notnull' => 1, 'position' => 4, 'visible' => 1, 'foreignkey' => 'c_country.rowid'),
		'start_date' => array('type' => 'datetime', 'label' => 'Départ', 'enabled' => '1', 'notnull' => 0, 'position' => 5, 'visible' => 1),
		'return_date' => array('type' => 'datetime', 'label' => 'Arrivée', 'enabled' => '1', 'notnull' => 0, 'position' => 6, 'visible' => 1),
		'fk_travel_mod' => array('type' => 'sellist:c_transport_mod:label:rowid::(active:=:1)', 'label' => 'Mode de transport', 'enabled' => '1', 'notnull' => 0, 'position' => 7, 'visible' => 1, 'foreignkey' => 'c_transport_mode.rowid'),

		'rowid' => array('type' => 'integer', 'label' => 'TechnicalID', 'enabled' => '1', 'position' => 1, 'notnull' => 1, 'visible' => 0, 'noteditable' => '1', 'index' => 10, 'css' => 'left', 'comment' => "Id"),
		'fk_user_creat' => array('type' => 'integer:User:user/class/user.class.php', 'label' => 'UserAuthor', 'enabled' => '1', 'position' => 20, 'notnull' => 1, 'visible' => -2, 'foreignkey' => 'user.rowid',),
		'fk_user_modif' => array('type' => 'integer:User:user/class/user.class.php', 'label' => 'UserModif', 'enabled' => '1', 'position' => 30, 'notnull' => -1, 'visible' => -2,),
		'tms' => array('type' => 'timestamp', 'label' => 'DateModification', 'enabled' => '1', 'position' => 40, 'notnull' => 0, 'visible' => -2,),
		'date_creation' => array('type' => 'date', 'label' => 'DateCreation', 'enabled' => '1', 'position' => 50, 'notnull' => 1, 'visible' => -2,),
		'import_key' => array('type' => 'varchar(14)', 'label' => 'ImportId', 'enabled' => '1', 'position' => 60, 'notnull' => 0, 'visible' => -2,),
		'status' => array('type' => 'smallint', 'label' => 'Status', 'enabled' => '1', 'notnull' => 1, 'position' => 70, 'visible' => 5, 'default' => 0, 'index' => 1, 'arrayofkeyval' => array('0' => 'Brouillon', '1' => 'Valid&eacute;'),),
	];

	public $ref;
	public $label;
	public $amount;
	public $fk_destination_country;

	public $start_date;
	public $return_date;
	public $fk_travel_mod;
	public $rowid;
	public $fk_user_creat;
	public $fk_user_modif;
	public $tms;
	public $date_creation;
	public $import_key;
	public $status;

	// END MODULEBUILDER PROPERTIES

	/**
	 * Constructor
	 *
	 * @param DoliDb $db Database handler
	 */
	public function __construct(DoliDB $db)
	{
		global $conf, $langs;

		$this->db = $db;

		if (!getDolGlobalString('MAIN_SHOW_TECHNICAL_ID') && isset($this->fields['rowid'])) {
			$this->fields['rowid']['visible'] = 0;
		}
		if (empty($conf->multicompany->enabled) && isset($this->fields['entity'])) {
			$this->fields['entity']['enabled'] = 0;
		}
		if (empty($conf->webhost->enabled)) {
			$this->fields['module_name']['enabled'] = 0;
		}


		// Example to show how to set values of fields definition dynamically
		/*if ($user->rights->clienjoyholidays->clienjoyholidays->read) {
			$this->fields['myfield']['visible'] = 1;
			$this->fields['myfield']['noteditable'] = 0;
		}*/

		// Unset fields that are disabled
		foreach ($this->fields as $key => $val) {
			if (isset($val['enabled']) && empty($val['enabled'])) {
				unset($this->fields[$key]);
			}
		}

		// Translate some data of arrayofkeyval
		if (is_object($langs)) {
			foreach ($this->fields as $key => $val) {
				if (!empty($val['arrayofkeyval']) && is_array($val['arrayofkeyval'])) {
					foreach ($val['arrayofkeyval'] as $key2 => $val2) {
						$this->fields[$key]['arrayofkeyval'][$key2] = $langs->trans($val2);
					}
				}
			}
		}
	}

	/**
	 * Create object into database
	 *
	 * @param User $user User that creates
	 * @param bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, Id of created object if OK
	 */
	public function create(User $user, $notrigger = false)
	{

		$resultcreate = $this->createCommon($user, $notrigger);

		return $resultcreate;
	}

	/**
	 * Clone an object into another one
	 *
	 * @param User $user User that creates
	 * @param int $fromid Id of object to clone
	 * @return    mixed                New object created, <0 if KO
	 */
	public function createFromClone(User $user, $fromid)
	{

		global $langs, $extrafields;
		$error = 0;

		dol_syslog(__METHOD__, LOG_DEBUG);

		$object = new self($this->db);

		$this->db->begin();

		// Load source object
		$result = $object->fetchCommon($fromid);

		if ($result > 0 && !empty($object->table_element_line)) {
			$object->fetchLines();

		}

		// get lines so they will be clone
		//foreach($this->lines as $line)
		//	$line->fetch_optionals();

		// Reset some properties
		unset($object->id);
		unset($object->fk_user_creat);
		unset($object->import_key);

		// Clear fields
		if (property_exists($object, 'ref')) {
			$object->ref = empty($this->fields['ref']['default']) ? "Copy_Of_" . $object->ref : $this->fields['ref']['default'];
		}
		if (property_exists($object, 'status')) {
			$object->status = self::STATUS_DRAFT;
		}
		if (property_exists($object, 'date_creation')) {
			$object->date_creation = dol_now();
		}
		if (property_exists($object, 'date_modification')) {
			$object->date_modification = null;
		}
		if (property_exists($object, 'tech_detail')) {
			$object->tech_detail = null;
		}
		if (property_exists($object, 'estimate_date')) {
			$object->estimate_date = null;
		}
		if (property_exists($object, 'qty')) {
			$object->qty = null;
		}
		if (property_exists($object, 'dev_estimate')) {
			$object->dev_estimate = null;
		}
		if (property_exists($object, 'module_name')) {
			$object->module_name = null;
		}
		if (property_exists($object, 'keywords')) {
			$object->keywords = null;
		}
		// ...
		// Clear extrafields that are unique
		if (is_array($object->array_options) && count($object->array_options) > 0) {
			$extrafields->fetch_name_optionals_label($this->table_element);
			foreach ($object->array_options as $key => $option) {
				$shortkey = preg_replace('/options_/', '', $key);
				if (!empty($extrafields->attributes[$this->table_element]['unique'][$shortkey])) {
					//var_dump($key); var_dump($clonedObj->array_options[$key]); exit;
					unset($object->array_options[$key]);
				}
			}
		}

		// Create clone
		$object->context['createfromclone'] = 'createfromclone';
		$result = $object->createCommon($user);
		if ($result < 0) {
			$error++;
			$this->error = $object->error;
			$this->errors = $object->errors;
		}

		if (!$error) {
			// copy internal contacts
			if ($this->copy_linked_contact($object, 'internal') < 0) {
				$error++;
			}
		}

		if (!$error) {
			// copy external contacts if same company
			if (property_exists($this, 'fk_soc') && $this->fk_soc == $object->socid) {
				if ($this->copy_linked_contact($object, 'external') < 0) {
					$error++;
				}
			}
		}

		unset($object->context['createfromclone']);

		// End
		if (!$error) {

			setEventMessage($langs->trans('CEHCreateToClone'));
			$this->db->commit();
			return $object;
		} else {
			$this->db->rollback();
			return -1;
		}
	}

	/**
	 * Load object in memory from the database
	 *
	 * @param int $id Id object
	 * @param string $ref Ref
	 * @return int         <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetch($id, $ref = null)
	{
		$result = $this->fetchCommon($id, $ref);
		if ($result > 0 && !empty($this->table_element_line)) {
			$this->fetchLines();
		}
		return $result;
	}

	/**
	 * Load object lines in memory from the database
	 *
	 * @return int         <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetchLines()
	{
		$this->lines = array();

		$result = $this->fetchLinesCommon();
		return $result;
	}

	/**
	 * Function to concat keys of fields
	 *
	 * @param string $alias String of alias of table for fields. For example 't'.
	 * @return  string                list of alias fields
	 */
	public function getFieldListRetrocompatibility($alias = '')
	{
		// retrocompatibility
		if (intval(DOL_VERSION) <= 14) {
			$keys = array_keys($this->fields);
			if (!empty($alias)) {
				$keys_with_alias = array();
				foreach ($keys as $fieldname) {
					$keys_with_alias[] = $alias . '.' . $fieldname;
				}
				return implode(',', $keys_with_alias);
			} else {
				return implode(',', $keys);
			}
		}

		// For V14 and above
		return parent::getFieldList($alias);
	}

	/**
	 * Load list of objects in memory from the database.
	 *
	 * @param string $sortorder Sort Order
	 * @param string $sortfield Sort field
	 * @param int $limit limit
	 * @param int $offset Offset
	 * @param array $filter Filter array. Example array('field'=>'valueforlike', 'customurl'=>...)
	 * @param string $filtermode Filter mode (AND or OR)
	 * @return array|int                 int <0 if KO, array of pages if OK
	 */
	public function fetchAll($sortorder = '', $sortfield = '', $limit = 0, $offset = 0, array $filter = array(), $filtermode = 'AND')
	{
		global $conf;

		dol_syslog(__METHOD__, LOG_DEBUG);

		$records = array();

		$sql = 'SELECT ';
		$sql .= $this->getFieldList('t');
		$sql .= ' FROM ' . MAIN_DB_PREFIX . $this->table_element . ' as t';
		if (isset($this->ismultientitymanaged) && $this->ismultientitymanaged == 1) {
			$sql .= ' WHERE t.entity IN (' . getEntity($this->table_element) . ')';
		} else {
			$sql .= ' WHERE 1 = 1';
		}
		// Manage filter
		$sqlwhere = array();
		if (count($filter) > 0) {
			foreach ($filter as $key => $value) {
				if ($key == 't.rowid') {
					$sqlwhere[] = $key . '=' . $value;
				} elseif (in_array($this->fields[$key]['type'], array('date', 'datetime', 'timestamp'))) {
					$sqlwhere[] = $key . ' = \'' . $this->db->idate($value) . '\'';
				} elseif ($key == 'customsql') {
					$sqlwhere[] = $value;
				} elseif (strpos($value, '%') === false) {
					$sqlwhere[] = $key . ' IN (' . $this->db->sanitize($this->db->escape($value)) . ')';
				} else {
					$sqlwhere[] = $key . ' LIKE \'%' . $this->db->escape($value) . '%\'';
				}
			}
		}
		if (count($sqlwhere) > 0) {
			$sql .= ' AND (' . implode(' ' . $filtermode . ' ', $sqlwhere) . ')';
		}

		if (!empty($sortfield)) {
			$sql .= $this->db->order($sortfield, $sortorder);
		}
		if (!empty($limit)) {
			$sql .= ' ' . $this->db->plimit($limit, $offset);
		}

		$resql = $this->db->query($sql);
		if ($resql) {
			$num = $this->db->num_rows($resql);
			$i = 0;
			while ($i < ($limit ? min($limit, $num) : $num)) {
				$obj = $this->db->fetch_object($resql);

				$record = new self($this->db);
				$record->setVarsFromFetchObj($obj);

				$records[$record->id] = $record;

				$i++;
			}
			$this->db->free($resql);

			return $records;
		} else {
			$this->errors[] = 'Error ' . $this->db->lasterror();
			dol_syslog(__METHOD__ . ' ' . join(',', $this->errors), LOG_ERR);

			return -1;
		}
	}

	/**
	 * Update object into database
	 *
	 * @param User $user User that modifies
	 * @param bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	public function update(User $user, $notrigger = false)
	{

		// Set status to validated ref,label,fk_destination_country is not null
//		if ($this->ref != null && $this->label != null && $this->fk_destination_country != null && $this->status == $this::STATUS_DRAFT) {
//			$this->status = $this::STATUS_VALIDATED;
//		}

		return $this->updateCommon($user, $notrigger);
	}

	/**
	 * Delete object in database
	 *
	 * @param User $user User that deletes
	 * @param bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	public function delete(User $user, $notrigger = false)
	{
		return $this->deleteCommon($user, $notrigger);
		//return $this->deleteCommon($user, $notrigger, 1);
	}

	public function addCliEnjoyHolidaysToPropal(User $user, $notrigger = false)
	{
		return $this->deleteCommon($user, $notrigger);
		//return $this->deleteCommon($user, $notrigger, 1);
	}

	/**
	 *  Delete a line of object in database
	 *
	 * @param User $user User that delete
	 * @param int $idline Id of line to delete
	 * @param bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int                >0 if OK, <0 if KO
	 */
	public function deleteLine(User $user, $idline, $notrigger = false)
	{
		if ($this->status < 0) {
			$this->error = 'ErrorDeleteLineNotAllowedByObjectStatus';
			return -2;
		}

		return $this->deleteLineCommon($user, $idline, $notrigger);
	}


	/**
	 *    Validate object
	 *
	 * @param User $user User making status change
	 * @param int $notrigger 1=Does not execute triggers, 0= execute triggers
	 * @return    int                        <=0 if OK, 0=Nothing done, >0 if KO
	 */
	public function validate($user, $notrigger = 0)
	{
		global $conf, $langs;

		require_once DOL_DOCUMENT_ROOT . '/core/lib/files.lib.php';

		$error = 0;

		// Protection
		if ($this->status == self::STATUS_VALIDATED) {
			dol_syslog(get_class($this) . "::validate action abandonned: already validated", LOG_WARNING);
			return 0;
		}

		if ($this->status == self::STATUS_DRAFT) {
			$this->status = self::STATUS_VALIDATED;
		}

		/*if (! ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->clienjoyholidays->write))
		 || (! empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->clienjoyholidays->clienjoyholidays_advance->validate))))
		 {
		 $this->error='NotEnoughPermissions';
		 dol_syslog(get_class($this)."::valid ".$this->error, LOG_ERR);
		 return -1;
		 }*/

		$now = dol_now();

		$this->db->begin();




			// Validate
			$sql = "UPDATE " . MAIN_DB_PREFIX . $this->table_element;
			$sql .= " SET status = " . self::STATUS_VALIDATED;
			$sql .= " WHERE ref = '" . $this->ref . "'";

			dol_syslog(get_class($this) . "::validate()", LOG_DEBUG);
			$resql = $this->db->query($sql);
			if (!$resql) {
				dol_print_error($this->db);
				$this->error = $this->db->lasterror();
				$error++;
			}




		// Set new ref and current status
		if (!$error) {
			$this->status = self::STATUS_VALIDATED;
		}

		if (!$error) {
			$this->db->commit();
			return 1;
		} else {
			$this->db->rollback();
			return -1;
		}
	}


	/**
	 *    Set draft status
	 *
	 * @param User $user Object user that modify
	 * @param int $notrigger 1=Does not execute triggers, 0=Execute triggers
	 * @return    int                        <0 if KO, >0 if OK
	 */
	public function setDraft($user, $notrigger = 0)
	{
		// Protection
		if ($this->status <= self::STATUS_DRAFT) {
			return 0;
		}

		/*if (! ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->write))
		 || (! empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->clienjoyholidays_advance->validate))))
		 {
		 $this->error='Permission denied';
		 return -1;
		 }*/

		return $this->setStatusCommon($user, self::STATUS_DRAFT, $notrigger, 'CLIENJOYHOLIDAYS_UNVALIDATE');
	}

	/**
	 *    Set cancel status
	 *
	 * @param User $user Object user that modify
	 * @param int $notrigger 1=Does not execute triggers, 0=Execute triggers
	 * @return    int                        <0 if KO, 0=Nothing done, >0 if OK
	 */


	/**
	 *    Set back to validated status
	 *
	 * @param User $user Object user that modify
	 * @param int $notrigger 1=Does not execute triggers, 0=Execute triggers
	 * @return    int                        <0 if KO, 0=Nothing done, >0 if OK
	 */
	public function reopen($user, $notrigger = 0)
	{
		// Protection
		if ($this->status != self::STATUS_DRAFT) {
			return 0;
		}

		/*if (! ((empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->write))
		 || (! empty($conf->global->MAIN_USE_ADVANCED_PERMS) && ! empty($user->rights->clienjoyholidays->clienjoyholidays_advance->validate))))
		 {
		 $this->error='Permission denied';
		 return -1;
		 }*/

		return $this->setStatusCommon($user, self::STATUS_VALIDATED, $notrigger, 'CLIENJOYHOLIDAYS_REOPEN');
	}

	/**
	 *  Return a link to the object card (with optionaly the picto)
	 *
	 * @param int $withpicto Include picto in link (0=No picto, 1=Include picto into link, 2=Only picto)
	 * @param string $option On what the link point to ('nolink', ...)
	 * @param int $notooltip 1=Disable tooltip
	 * @param string $morecss Add more css on link
	 * @param int $save_lastsearch_value -1=Auto, 0=No save of lastsearch_values when clicking, 1=Save lastsearch_values whenclicking
	 * @return    string                              String with URL
	 */
	public function getNomUrl($withpicto = 0, $option = '', $notooltip = 0, $morecss = '', $save_lastsearch_value = -1)
	{
		global $conf, $langs, $hookmanager, $action;

		if ($action == 'create') {
//			$result = 'Brouillon';
//			return $result;
		} else {
			if (!empty($conf->dol_no_mouse_hover)) {
				$notooltip = 1; // Force disable tooltips
			}

			$result = '';

			$label = img_picto('', $this->picto) . ' <u>' . $langs->trans("CliEnjoyHolidays") . '</u>';
			if (isset($this->status)) {
				$label .= ' ' . $this->getLibStatut(5);
			}
			$label .= '<br>';
			$label .= '<b>' . $langs->trans('abc') . ':</b> ' . $this->ref;

			if (!empty($this->commercial_text)) {
				$label .= '<br>';
				$label .= '<b>' . $langs->trans($this->fields['commercial_text']['label']) . ':</b> ' . str_replace("\r\n", "", $this->commercial_text);
			}

			if (!empty($this->keywords)) {
//				$label .= '<br>';
//				$label .= '<b>' . $langs->trans($this->fields['keywords']['label']) . ':</b> ' . str_replace("\r\n", "", $this->keywords);
			}

			$url = dol_buildpath('/clienjoyholidays/clienjoyholidays_card.php', 1) . '?id=' . $this->id;

			if ($option != 'nolink') {
				// Add param to save lastsearch_values or not
				$add_save_lastsearch_values = ($save_lastsearch_value == 1 ? 1 : 0);
				if ($save_lastsearch_value == -1 && preg_match('/list\.php/', $_SERVER["PHP_SELF"])) {
					$add_save_lastsearch_values = 1;
				}
				if ($add_save_lastsearch_values) {
					$url .= '&save_lastsearch_values=1';
				}
			}

			$linkclose = '';
			if (empty($notooltip)) {
				if (getDolGlobalString('MAIN_OPTIMIZEFORTEXTBROWSER')) {
					$label = $langs->trans("ShowCliEnjoyHolidays");
					$linkclose .= ' alt="' . dol_escape_htmltag($label, 1) . '"';
				}
				$linkclose .= ' title="' . dol_escape_htmltag($label, 1) . '"';
				$linkclose .= ' class="classfortooltip' . ($morecss ? ' ' . $morecss : '') . '"';
			} else {
				$linkclose = ($morecss ? ' class="' . $morecss . '"' : '');
			}

			if ($option == 'nolink') {
				$linkstart = '<span';
			} else {
				$linkstart = '<a href="' . $url . '"';

			}
			$linkstart .= $linkclose . '>';
			if ($option == 'nolink') {
				$linkend = '</span>';
			} else {
				$linkend = '</a>';
			}

			$result .= $linkstart;

			if (empty($this->showphoto_on_popup)) {
				if ($withpicto) {
					$result .= img_object(($notooltip ? '' : $label), ($this->picto ? $this->picto : 'generic'), ($notooltip ? (($withpicto != 2) ? 'class="paddingright"' : '') : 'class="' . (($withpicto != 2) ? 'paddingright ' : '') . 'classfortooltip"'), 0, 0, $notooltip ? 0 : 1);
				}
			} else {
				if ($withpicto) {
					require_once DOL_DOCUMENT_ROOT . '/core/lib/files.lib.php';

					list($class, $module) = explode('@', $this->picto);
					$upload_dir = $conf->$module->multidir_output[$conf->entity] . "/$class/" . dol_sanitizeFileName($this->ref);
					$filearray = dol_dir_list($upload_dir, "files");
					$filename = $filearray[0]['name'];
					if (!empty($filename)) {
						$pospoint = strpos($filearray[0]['name'], '.');

						$pathtophoto = $class . '/' . $this->ref . '/thumbs/' . substr($filename, 0, $pospoint) . '_mini' . substr($filename, $pospoint);
						if (empty($conf->global->{strtoupper($module . '_' . $class) . '_FORMATLISTPHOTOSASUSERS'})) {
							$result .= '<div class="floatleft inline-block valignmiddle divphotoref"><div class="photoref"><img class="photo' . $module . '" alt="No photo" border="0" src="' . DOL_URL_ROOT . '/viewimage.php?modulepart=' . $module . '&entity=' . $conf->entity . '&file=' . urlencode($pathtophoto) . '"></div></div>';
						} else {
							$result .= '<div class="floatleft inline-block valignmiddle divphotoref"><img class="photouserphoto userphoto" alt="No photo" border="0" src="' . DOL_URL_ROOT . '/viewimage.php?modulepart=' . $module . '&entity=' . $conf->entity . '&file=' . urlencode($pathtophoto) . '"></div>';
						}

						$result .= '</div>';
					} else {
						$result .= img_object(($notooltip ? '' : $label), ($this->picto ? $this->picto : 'generic'), ($notooltip ? (($withpicto != 2) ? 'class="paddingright"' : '') : 'class="' . (($withpicto != 2) ? 'paddingright ' : '') . 'classfortooltip"'), 0, 0, $notooltip ? 0 : 1);
					}
				}
			}

			if ($withpicto != 2) {
				$result .= $this->ref;
			}

			$result .= $linkend;
			//if ($withpicto != 2) $result.=(($addlabel && $this->label) ? $sep . dol_trunc($this->label, ($addlabel > 1 ? $addlabel : 0)) : '');

			global $action, $hookmanager;
			$hookmanager->initHooks(array('clienjoyholidaysdao'));
			$parameters = array('id' => $this->id, 'getnomurl' => $result);
			$reshook = $hookmanager->executeHooks('getNomUrl', $parameters, $this, $action); // Note that $action and $object may have been modified by some hooks
			if ($reshook > 0) {
				$result = $hookmanager->resPrint;
			} else {
				$result .= $hookmanager->resPrint;
			}

			return $result;
		}
	}

	/**
	 *  Return the label of the status
	 *
	 * @param int $mode 0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto, 6=Long label + Picto
	 * @return    string                   Label of status
	 */
	public function getLibStatut($mode = 0)
	{
		return $this->LibStatut($this->status, $mode);
	}

	// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps

	/**
	 *  Return the status
	 *
	 * @param int $status Id status
	 * @param int $mode 0=long label, 1=short label, 2=Picto + short label, 3=Picto, 4=Picto + long label, 5=Short label + Picto, 6=Long label + Picto
	 * @return string                   Label of status
	 */
	public function LibStatut($status, $mode = 0)
	{
		// phpcs:enable
		if (empty($this->labelStatus) || empty($this->labelStatusShort)) {
			global $langs;
			//$langs->load("clienjoyholidays@clienjoyholidays");
			$this->labelStatus[self::STATUS_DRAFT] = $langs->trans('Draft');
			$this->labelStatus[self::STATUS_VALIDATED] = $langs->trans('Validated');
			$this->labelStatusShort[self::STATUS_DRAFT] = $langs->trans('Draft');
			$this->labelStatusShort[self::STATUS_VALIDATED] = $langs->trans('Validated');
		}

		$statusType = 'status' . $status;
		if ($status == self::STATUS_VALIDATED) $statusType = 'status1';

		return dolGetStatus($this->labelStatus[$status], $this->labelStatusShort[$status], '', $statusType, $mode);
	}

	/**
	 *    Load the info information in the object
	 *
	 * @param int $id Id of object
	 * @return    void
	 */


	public function info($id)
	{
		$sql = 'SELECT rowid, date_creation as datec, tms as datem,';
		$sql .= ' fk_user_creat, fk_user_modif';
		$sql .= ' FROM ' . MAIN_DB_PREFIX . $this->table_element . ' as t';
		$sql .= ' WHERE t.rowid = ' . ((int)$id);
		$result = $this->db->query($sql);
		if ($result) {
			if ($this->db->num_rows($result)) {
				$obj = $this->db->fetch_object($result);
				$this->id = $obj->rowid;
				if ($obj->fk_user_author) {
					$cuser = new User($this->db);
					$cuser->fetch($obj->fk_user_author);
					$this->user_creation_id = $cuser;
				}

				if ($obj->fk_user_valid) {
					$vuser = new User($this->db);
					$vuser->fetch($obj->fk_user_valid);
					$this->user_validation_id = $vuser;
				}

				if ($obj->fk_user_cloture) {
					$cluser = new User($this->db);
					$cluser->fetch($obj->fk_user_cloture);
					$this->user_cloture = $cluser;
				}

				$this->date_creation = $this->db->jdate($obj->datec);
				$this->date_modification = $this->db->jdate($obj->datem);
				$this->date_validation = $this->db->jdate($obj->datev);
			}

			$this->db->free($result);
		} else {
			dol_print_error($this->db);
		}
	}

	/**
	 * Initialise object with example values
	 * Id must be 0 if object instance is a specimen
	 *
	 * @return void
	 */
	public function initAsSpecimen()
	{
		// Set here init that are not commonf fields
		// $this->property1 = ...
		// $this->property2 = ...

		$this->initAsSpecimenCommon();
	}

	/**
	 *    Create an array of lines
	 *
	 * @return array|int        array of lines if OK, <0 if KO
	 */
	public function getLinesArray()
	{
		$this->lines = array();

		$objectline = new CliEnjoyHolidaysLine($this->db);
		$result = $objectline->fetchAll('ASC', 'position', 0, 0, array('customsql' => 'fk_clienjoyholidays = ' . $this->id));
		var_dump($result);
		if (is_numeric($result)) {
			$this->error = $this->error;
			$this->errors = $this->errors;
			return $result;
		} else {
			$this->lines = $result;
			return $this->lines;
		}
	}

	/**
	 *  Returns the reference to the following non used object depending on the active numbering module.
	 *
	 * @return string            Object free reference
	 */
	public function getNextNumRef()
	{
		global $langs, $conf;
		$langs->load("clienjoyholidays@clienjoyholidays");

		if (!getDolGlobalString('CLIENJOYHOLIDAYS_CLIENJOYHOLIDAYS_ADDON')) {
			$conf->global->CLIENJOYHOLIDAYS_CLIENJOYHOLIDAYS_ADDON = 'mod_clienjoyholidays_standard';
		}

		if (getDolGlobalString('CLIENJOYHOLIDAYS_CLIENJOYHOLIDAYS_ADDON')) {
			$mybool = false;

			$file = getDolGlobalString('CLIENJOYHOLIDAYS_CLIENJOYHOLIDAYS_ADDON') . ".php";
			$classname = $conf->global->CLIENJOYHOLIDAYS_CLIENJOYHOLIDAYS_ADDON;

			// Include file with class
			$dirmodels = array_merge(array('/'), (array)$conf->modules_parts['models']);
			foreach ($dirmodels as $reldir) {
				$dir = dol_buildpath($reldir . "core/modules/clienjoyholidays/");

				// Load file with numbering class (if found)
				$mybool |= @include_once $dir . $file;
			}

			if ($mybool === false) {
				dol_print_error('', "Failed to include file " . $file);
				return '';
			}

			if (class_exists($classname)) {
				$obj = new $classname();
				$numref = $obj->getNextValue($this);

				if ($numref != '' && $numref != '-1') {
					return $numref;
				} else {
					$this->error = $obj->error;
					//dol_print_error($this->db,get_class($this)."::getNextNumRef ".$obj->error);
					return "";
				}
			} else {
				print $langs->trans("Error") . " " . $langs->trans("ClassNotFound") . ' ' . $classname;
				return "";
			}
		} else {
			print $langs->trans("ErrorNumberingModuleNotSetup", $this->element);
			return "";
		}
	}

	/**
	 *  Create a document onto disk according to template module.
	 *
	 * @param string $modele Force template to use ('' to not force)
	 * @param Translate $outputlangs objet lang a utiliser pour traduction
	 * @param int $hidedetails Hide details of lines
	 * @param int $hidedesc Hide description
	 * @param int $hideref Hide ref
	 * @param null|array $moreparams Array to provide more information
	 * @return     int                        0 if KO, 1 if OK
	 */
	public function generateDocument($modele, $outputlangs, $hidedetails = 0, $hidedesc = 0, $hideref = 0, $moreparams = null)
	{
		global $conf, $langs;

		$result = 0;
		$includedocgeneration = 0;

		$langs->load("clienjoyholidays@clienjoyholidays");

		if (!dol_strlen($modele)) {
			$modele = 'standard_clienjoyholidays';

			if (!empty($this->model_pdf)) {
				$modele = $this->model_pdf;
			} elseif (getDolGlobalString('CLIENJOYHOLIDAYS_ADDON_PDF')) {
				$modele = $conf->global->CLIENJOYHOLIDAYS_ADDON_PDF;
			}
		}

		$modelpath = "core/modules/clienjoyholidays/doc/";

		if ($includedocgeneration && !empty($modele)) {
			$result = $this->commonGenerateDocument($modelpath, $modele, $outputlangs, $hidedetails, $hidedesc, $hideref, $moreparams);
		}

		return $result;
	}


	/**
	 * Return HTML string to put an input field into a page
	 * Code very similar with showInputField of extra fields
	 *
	 * @param array $val Array of properties for field to show
	 * @param string $key Key of attribute
	 * @param string $value Preselected value to show (for date type it must be in timestamp format, for amount or price it must be a php numeric value)
	 * @param string $moreparam To add more parameters on html input tag
	 * @param string $keysuffix Prefix string to add into name and id of field (can be used to avoid duplicate names)
	 * @param string $keyprefix Suffix string to add into name and id of field (can be used to avoid duplicate names)
	 * @param string|int $morecss Value for css to define style/length of field. May also be a numeric.
	 * @return string
	 */
	public function showInputField($val, $key, $value, $moreparam = '', $keysuffix = '', $keyprefix = '', $morecss = 0, $nonewbutton = 0)
	{
		global $conf, $langs, $form, $action;

		if ($key == 'keywords') {
			// return '<input  name="keywords" style="text-transform: uppercase" type="text" value="'.dol_escape_htmltag($value).'"/>';
		} else {
			$out = parent::showInputField($val, $key, $value, $moreparam, $keysuffix, $keyprefix, $morecss, $nonewbutton);
		}


		return $out;
	}
}


require_once DOL_DOCUMENT_ROOT . '/core/class/commonobjectline.class.php';

/**
 * Class CliEnjoyHolidaysLine. You can also remove this and generate a CRUD class for lines objects.
 */
class CliEnjoyHolidaysLine extends CommonObjectLine
{
	// To complete with content of an object CliEnjoyHolidaysLine
	// We should have a field rowid, fk_clienjoyholidays and position

	/**
	 * @var int  Does object support extrafields ? 0=No, 1=Yes
	 */
	public $isextrafieldmanaged = 0;

	/**
	 * Constructor
	 *
	 * @param DoliDb $db Database handler
	 */
	public function __construct(DoliDB $db)
	{
		$this->db = $db;
	}
}
