<?php
class PluginTweaker_ModuleOverride_MapperUser extends PlaginTweaker_Inherit_ModuleUser_MapperUser {
	
	/**
	 * Возвращает список пользователей по фильтру
	 *
	 * @param array $aFilter	Фильтр
	 * @param array $aOrder	Сортировка
	 * @param int $iCount	Возвращает общее количество элементов
	 * @param int $iCurrPage	Номер страницы
	 * @param int $iPerPage	Количество элментов на страницу
	 * @return array
	 */
	public function GetUsersByFilter($aFilter,$aOrder,&$iCount,$iCurrPage,$iPerPage) {
		$aOrderAllow=array('user_id','user_login','user_date_register','user_rating','user_skill','user_profile_name');
		$sOrder='';
		foreach ($aOrder as $key=>$value) {
			if (!in_array($key,$aOrderAllow)) {
				unset($aOrder[$key]);
			} elseif (in_array($value,array('asc','desc'))) {
				$sOrder.=" {$key} {$value},";
			}
		}
		$sOrder=trim($sOrder,',');
		if ($sOrder=='') {
			$sOrder=' user_id desc ';
		}

		$sql = "SELECT
					user_id
				FROM
					".Config::Get('db.table.user')."
				WHERE
					1 = 1
					{ AND user_id = ?d }
					{ AND user_mail = ? }
					{ AND user_password = ? }
					{ AND user_ip_register = ? }
					{ AND user_activate = ?d }
					{ AND user_activate_key = ? }
					{ AND user_profile_sex = ? }
					{ AND user_profile_name LIKE ? }
					{ AND user_profile_name LIKE ? }
				ORDER by {$sOrder}
				LIMIT ?d, ?d ;
					";
		$aResult=array();
		if ($aRows=$this->oDb->selectPage($iCount,$sql,
										  isset($aFilter['id']) ? $aFilter['id'] : DBSIMPLE_SKIP,
										  isset($aFilter['mail']) ? $aFilter['mail'] : DBSIMPLE_SKIP,
										  isset($aFilter['password']) ? $aFilter['password'] : DBSIMPLE_SKIP,
										  isset($aFilter['ip_register']) ? $aFilter['ip_register'] : DBSIMPLE_SKIP,
										  isset($aFilter['activate']) ? $aFilter['activate'] : DBSIMPLE_SKIP,
										  isset($aFilter['activate_key']) ? $aFilter['activate_key'] : DBSIMPLE_SKIP,
										  isset($aFilter['profile_sex']) ? $aFilter['profile_sex'] : DBSIMPLE_SKIP,
										  isset($aFilter['login']) ? $aFilter['login'] : DBSIMPLE_SKIP,
										  isset($aFilter['profile_name']) ? $aFilter['profile_name'] : DBSIMPLE_SKIP,
										  ($iCurrPage-1)*$iPerPage, $iPerPage
		)) {
			foreach ($aRows as $aRow) {
				$aResult[]=$aRow['user_id'];
			}
		}
		return $aResult;
	}
	/**
	 * Возвращает список префиксов логинов пользователей (для алфавитного указателя)
	 *
	 * @param int $iPrefixLength	Длина префикса
	 * @return array
	 */
	public function GetGroupPrefixUser($iPrefixLength=1) {
		$sql = "
			SELECT SUBSTRING(`user_profile_name` FROM 1 FOR ?d ) as prefix
			FROM
				".Config::Get('db.table.user')."
			WHERE
				user_activate = 1
			GROUP BY prefix
			ORDER BY prefix ";
		$aReturn=array();
		if ($aRows=$this->oDb->select($sql,$iPrefixLength)) {
			foreach ($aRows as $aRow) {
				$aReturn[]=mb_strtoupper($aRow['prefix'],'utf-8');
			}
		}
		return $aReturn;
	}
}