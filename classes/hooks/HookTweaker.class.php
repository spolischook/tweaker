<?php
/*---------------------------------------------------------
 * 
 *  Copyright © 2012 Sergey Polischook
 *  
 *  -------------------------------------------------------
 *  
 *  Official site: http://kotoblog.pp.ua
*   Contact e-mail: spolischook@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*   
*   -------------------------------------------------------
 */

/**
 * Базовые хуки
 *
 * @package hooks
 * @since 1.0
 */
 
class PluginTweaker_HookTweaker extends Hook {
	/**
	* Регистрируем хуки
	*/
	public function RegisterHook() {
		$this->AddHook('registration_begin','add',__CLASS__,-100);
	}
	
	public function add($aVars) {
		return "There are new input!";
	}
}