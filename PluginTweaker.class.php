<?php 
/**
 * This plugin do some changes that for my own think must be.
 */
class PluginTweaker extends Plugin {
	
	protected $aInherits=array(
		'mapper' => array('ModuleUser_MapperUser' => '_ModuleOverride_MapperUser')
	);
	
	/**
	 * Activate plugin
	 * @see Plugin::Activate()
	 */
	public function Activate() {
		return TRUE;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Plugin::Init()
	 */
	public function Init() {
		
	}
	
	/**
	 * Deactivate plugin
	 * @see Plugin::Deactivate()
	 */
	public function Deactivate(){
		return TRUE;
	}
}
?>