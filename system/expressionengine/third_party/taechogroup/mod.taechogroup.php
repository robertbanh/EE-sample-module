<? if( ! defined('BASEPATH')) exit('No direct script access allowed');

// extending the core channel class
if (!class_exists( 'Channel')) { require_once PATH_MOD.'channel/mod.channel.php'; }

class Taechogroup extends Channel
{
	public $return_data = NULL;

	// =================
	//
	// =================
	public function __construct()
	{
		$this->EE =& get_instance();

		// load models
		$this->EE->load->model('taechogroup_model');
	}

    // ----------------------------------------
    //  Usage:
    /* <link rel="stylesheet" href="/css/styles.css?v={exp:taechogroup:css_cache_buster}" type="text/css" media="screen" charset="utf-8">
    */
    // ----------------------------------------
    public function css_cache_buster()
    {
        $css_file = APPPATH . '../../css/styles.css';
        
        return filemtime($css_file);
    }

    // ----------------------------------------
    //  {exp:taechogroup:example_one}
    // ----------------------------------------
    public function example_one()
    {
        $css_file = APPPATH . '../../css/styles.css';
        
        return filemtime($css_file);
    }

    // =================
    /* 
       {exp:taechogroup:example_two param="hello"}
            <p>{name} : {data} : {blah}</p>
       {/exp:taechogroup:example_two}
    */
    // =================
    public function example_two()
    {
        // example of how to fetch attributes
        $param = ($this->EE->TMPL->fetch_param('param') != FALSE) ? $this->EE->TMPL->fetch_param('param') : 'nothing';

        // sample array to loop 3 times
        $re = array('1', '2', '3');

        foreach ($re as $r)
        {
            // Example of how you set {name}, {data}, {blah}
            $variables[] = array(
                'name' => $r,
                'data' => 'test',
                'blah' => $param . ' world',
            );
        }

        $output = $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $variables);

        return $output;
    }

    // =================
    /* 
       {exp:taechogroup:example_three}
            hello world
       {/exp:taechogroup:example_three}
    */
    // =================
    public function example_three()
    {
        // example of how to get the content inside the variable pairs
        $tagdata = trim($this->EE->TMPL->tagdata);

        $output = str_replace('hello', 'bye', $tagdata);

        return $output;
    }

    // =================
    /* 
      {exp:taechogroup:favorites}
          {title}
          {url_title}
          {...}
      {/exp:taechogroup:favorites}
    */ 
    // =================
    public function favorites()
    {
        parent::Channel();
        
        // fetch current logged in user
        $current_user = $this->EE->session->userdata('member_id');
        if (empty($current_user)) return $this->EE->TMPL->no_results();

        // fetch all favorites by the user
        $re = $this->EE->taechogroup_model->get_entry_ids_by_member_id($current_user);
        if (empty($re)) return $this->EE->TMPL->no_results();

        $entry_ids = array();
        foreach ($re as $r)
        {
            $entry_ids[] = $r['entry_id'];
        }
        
        $this->EE->TMPL->tagparams['entry_id'] = implode('|', $entry_ids);
       
        $this->return_data = parent::entries();

        return $this->return_data;
    }



}

