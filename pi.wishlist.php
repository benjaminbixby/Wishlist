<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Wishlist Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Benjamin Bixby
 * @link		http://benjaminbixby.com
 */

$plugin_info = array(
	'pi_name'		=> 'Wishlist',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Benjamin Bixby',
	'pi_author_url'	=> 'http://benjaminbixby.com',
	'pi_description'=> 'Get wishlist items.',
	'pi_usage'		=> Wishlist::usage()
);


class Wishlist {

	public $return_data;
    
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}

	// ----------------------------------------------------------------
	
	function set()
	{
  
    // Fetch params
    $name    = $this->EE->TMPL->fetch_param('name');
    $value   = $this->EE->TMPL->fetch_param('value');
    $seconds = $this->EE->TMPL->fetch_param('seconds');
    $event   = $this->EE->TMPL->fetch_param('event');

    // Bake cookie
    $this->EE->functions->set_cookie($name, $value, $seconds);

  	} // End of set()

	// ----------------------------------------------------------------

	function entries()
	{

		// entry array
		$allentrys = array();
		
		$sql = "SELECT `entry_id` FROM `exp_channel_data` WHERE `channel_id`='3'";
		$query = $this->EE->db->query($sql);
		if ($query->num_rows() > 0)
    	{
    		foreach($query->result_array() as $row)
    		{
    			$data[] = $row['entry_id'];
    		}
	    }

	    foreach($data as $k => $v)
	    {

	    	$q = $this->EE->input->cookie($v);

	    	if ($q != "")
	    	{
	    		array_push($allentrys, $data[$k]);
	    	}
	    
		}

		// Outputs just the entry numbers separated by a pipe
		$eids = implode('|', $allentrys);
		$tagdata = $this->EE->TMPL->tagdata;
		return $this->return_data = str_replace("{eids}", $eids, $tagdata);
		

	} // end display()

	// ----------------------------------------------------------------

	function check()
	{
	
		// entry array
		$allentrys = array();
		
		$sql = "SELECT `entry_id` FROM `exp_channel_data` WHERE `channel_id`='3'";
		$query = $this->EE->db->query($sql);
		if ($query->num_rows() > 0)
    	{
    		foreach($query->result_array() as $row)
    		{
    			$data[] = $row['entry_id'];
    		}
	    }

	    foreach($data as $k => $v)
	    {

	    	$q = $this->EE->input->cookie($v);

	    	if ($q != "")
	    	{
	    		array_push($allentrys, $data[$k]);
	    	}
	    
		}

		$result = count($allentrys);

	    $string = '<div id="top_wishlist" class="boxsha">
	      <h2>My Wishlist</h2>
	      <p><a href="{site_url}wishlist" title="My Wishlist">'.$result.' items</a></p>
	    </div>';

	    if ($result > 0)
		{
	    return $string;
		}

	} // end check()

	// ----------------------------------------------------------------

	function send()
	{
		
		$checkspam = $this->EE->input->post('myhoneypot');

		if ($checkspam != "")
		{
			return "Oops... looks like you're spam. Sorry.";
		}

		$result = '';

if (isset($_POST['product_title3']))
{
$title = $_POST['product_title3'];
	
	if (isset($_POST['product_option3']))
	{
	$option = $_POST['product_option3'];
	} else {
	$option = "No option for this product.";
	}

	if(isset($_POST['product_notes3']))
	{
	$notes = $_POST['product_notes3'];
	} else {
	$notes = "No notes specified by customer.";
	}

$string = $title . " | " . $option . " | " . $notes . "<br />";

$result .= $string;

}

$string = $title . " | " . $option . " | " . $notes . "<br />";

$result .= $string;

}

// load the email class to use it, and others as req

	$this->EE->load->library('email');
	$this->EE->load->helper('text');

	// recieve data via javascript, get 'post' data here
	// use this as template $entryid = $this->EE->input->post('entryid');
	$custname = $this->EE->input->post('name');
	$custemail = $this->EE->input->post('email');
	$custphone = $this->EE->input->post('phone');
	$custstreet = $this->EE->input->post('street');
	$custcity = $this->EE->input->post('city');
	$custstate = $this->EE->input->post('state');
	$custzip = $this->EE->input->post('zip');

	// setup vars
	$receipient = 'info@logsiding.com';
	$email_subject = 'Customer Wishlist Request';

	$firstp = '<p>A Customer has submitted their wishlist to you.  Here are the details:</p>';

	$theirinfo = "<p>Customer Name: " . $custname . "<br />Customer Email: " . $custemail . "<br />Customer Phone: " . $custphone . "<br />Customer Address: " . $custstreet . " " . $custcity . ", " . $custstate . " " . $custzip . "</p>";

	$email_msg = $firstp . $result . $theirinfo;

	// setup and send
	$this->EE->email->wordwrap = true;
	$this->EE->email->mailtype = 'html';
	$this->EE->email->from($custemail, $custname);
	$this->EE->email->to($receipient);
	$this->EE->email->subject($email_subject);
	$this->EE->email->message(entities_to_ascii($email_msg));
	$this->EE->email->Send();


	$this->EE->functions->set_cookie('3', '', '');
	$this->EE->functions->set_cookie('4', '', '');
	$this->EE->functions->set_cookie('5', '', '');
	$this->EE->functions->set_cookie('6', '', '');
	$this->EE->functions->set_cookie('8', '', '');
	$this->EE->functions->set_cookie('9', '', '');
	$this->EE->functions->set_cookie('10', '', '');
	$this->EE->functions->set_cookie('11', '', '');
	$this->EE->functions->set_cookie('12', '', '');
	$this->EE->functions->set_cookie('14', '', '');
	$this->EE->functions->set_cookie('15', '', '');
	$this->EE->functions->set_cookie('16', '', '');
	$this->EE->functions->set_cookie('17', '', '');
	$this->EE->functions->set_cookie('19', '', '');
	$this->EE->functions->set_cookie('20', '', '');
	$this->EE->functions->set_cookie('21', '', '');
	$this->EE->functions->set_cookie('22', '', '');
	$this->EE->functions->set_cookie('24', '', '');
	$this->EE->functions->set_cookie('25', '', '');

	return '<h1 style="text-align:center;">Thank you for your email, ' . $custname . "." . "<br />We will respond shortly!</h1>";

	} // end send()


	// ----------------------------------------------------------------
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

 Since you did not provide instructions on the form, make sure to put plugin documentation here.
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.wishlist.php */
/* Location: /system/expressionengine/third_party/wishlist/pi.wishlist.php */