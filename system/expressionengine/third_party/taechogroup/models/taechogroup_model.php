<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taechogroup_model
{
	private $EE;

	// ==================
	// 
	// ==================
	public function __construct()
	{
		$this->EE =& get_instance();
	}

    // ==================
    // 
    // ==================
    public function get_total_entries_in_channel($channel_id)
    {
        if (empty($channel_id)) return array();

        $sql = $this->EE->db->query("
            SELECT 
                count(*)
            FROM ".$this->EE->db->dbprefix('channel_titles')." ct
            WHERE 
                ct.channel_id = ".$this->EE->db->escape_str($channel_id)."
                and ct.status = 'open'
        ");
        $re = $sql->row_array();
        return current($re);
    }

    // ==================
    // 
    // ==================
    public function get_member_obj($member_id)
    {
        if (empty($member_id)) 
            return array();

        $sql = $this->EE->db->query("
            SELECT 
                *
            FROM ".$this->EE->db->dbprefix('members')."
            WHERE member_id = $member_id
        ");
        $re = $sql->row_array();
        
        if (empty($re)) return array();

        return $re;
    }


    // =================================
    // curl example with file caching
    // =================================
    private function curl_run($url)
    {
        if (empty($url)) return false;

        // This is how long the cache file should be active.
        // Note: This is set in seconds (3600 = 60 minutes)
        $cache_timer = 3600; 

        // setup cache
        $cache = PATH_THIRD . 'taechogroup/cache/curl_' . str_replace('/', '_', $url);
        $file_time = @filemtime($cache);
        if (!$file_time || ($file_time < (time() - $cache_timer)))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_USERAGENT, 'HAC');
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json; charset=utf-8'));
            $re = curl_exec($ch);
            $response = curl_getinfo($ch);
            curl_close($ch);

            if (floor($response['http_code']/100) == 2) 
            {
                // write to cache
                //@mkdir(APPPATH . 'cache', 0777);
                $cachefile = fopen($cache, 'wb');
                fwrite($cachefile, $re);
                fclose($cachefile);

                // success
                return json_decode($re);
            } 
        }
        else
        {
            return json_decode(file_get_contents($cache));
        }
        
        return false;
    }







    



}
