<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Birthday extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/birthday
	 *	- or -
	 * 		http://example.com/index.php/birthday/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/birthday/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('birthday');
	}


	public function getdays()
	{
        $month = $this->input->post('month');
        $data = array('month' => $month);
        $this->load->view('getdays', $data);
	}



	public function api_call()
	{

        $Name = $this->input->post('name');
        $month = $this->input->post('month');
        $day = $this->input->post('day');
        $year = $this->input->post('year');


        // Do we have all the date params we need
        if( $month > 0 && $day > 0 && $year > 0 && isset($Name) ){


            // Make timestamp for DB
            $Birthday = mktime(0,0,0,$month,$day,$year);


            // Timestamp into format API expects & Currency
            $Date = date('Y-m-d',$Birthday);
            $Curr = 'GBP';
            $Key = '331025c625b3d0e4d01c3d0e3d15cd82';

            // API CALL
            $ch = curl_init('http://data.fixer.io/api/'.$Date.'?access_key='.$Key.'&symbols='.$Curr.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $FixerAPI = json_decode($json, true);


            // Get our DB connection
            $this->load->database();
            $this->db;

            $data = array(
                'name' => $Name,
                'birthday' => $Birthday,
                'insert_date' => time(),
                'exchange_rate' => isset($FixerAPI['rates']['GBP'])?$FixerAPI['rates']['GBP']:NULL,
                'failure_message' => isset($FixerAPI['error']['info'])?$FixerAPI['error']['info']:NULL
            );

            $this->db->insert('birthday_exchange_rate', $data);

            $this->load->view('results');


        }

    }


    public function find_all_valid_birthdays()
    {
        // Get our DB connection
        $this->load->database();
        $this->db;

        $query = $this->db->get_where('birthday_exchange_rate', 'failure_message IS NULL');
        return $query->result();
    }





}
