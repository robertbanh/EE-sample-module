<?

class Taechogroup_upd
{
	var $version = '1.0';

	function __construct()
	{
		$this->EE =& get_instance();
	}

	function install()
	{
		// install module
		$this->EE->db->insert('modules', array(
			'module_name' => 'Taechogroup',
			'module_version' => $this->version,
			'has_cp_backend' => 'y',
			'has_publish_fields' => 'n'
		));

		/*$this->EE->db->insert('actions', array(
			'class' => 'Taechogroup',
			'method' => 'register_user'
		));*/

		/*$this->EE->db->query("CREATE TABLE IF NOT EXISTS `".$this->EE->db->dbprefix('tg_xxxx')."` (
				`id` int(10) NOT NULL AUTO_INCREMENT,
				`member_id` int(10) NOT NULL DEFAULT '0',
				`created_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`serialized_data` TEXT NULL,
			PRIMARY KEY (`id`),
  			KEY `member_id` (`member_id`)
			);");*/
		
		

		return TRUE;
	}

	function update( $current = '' )
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		$this->EE->load->dbforge();
	}

	function uninstall()
	{
		$this->EE->db->query("DELETE FROM exp_modules WHERE module_name = 'Taechogroup'");
		$this->EE->db->query("DELETE FROM exp_actions WHERE class = 'Taechogroup'");

		//$this->EE->db->query("DROP TABLE IF EXISTS ".$this->EE->db->dbprefix('tg_xxxx'));

		return TRUE;
	}
}

