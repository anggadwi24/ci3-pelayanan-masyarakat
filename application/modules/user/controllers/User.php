<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    protected $_module = '';
    protected $_logged_user = '';

    function __construct() {
        parent::__construct();

        $this->load->model("user_model");
        $this->model = $this->user_model;

        // Set the module from the first uri.
        $this->load->module('site_security');
        $this->_module = $this->site_security->_get_module_name();
        // Get The logged User
		$this->_logged_user = $this->site_security->_get_logged_user();
		// Load the settings module
		$this->load->module('site_settings');
    }

    public function search() {

        // check for security
        $this->site_security->_make_sure_is_admin();

        // get th query from _GET
        $search_query = $this->input->get('query');
        $data['search_query'] = $this->input->get('query');

        if (strlen($search_query) < 3) {
            redirect('user/manage');
        }

        // Get rows for display

        $data['query'] = $this->search_query($search_query, 'username', 'email', 'first_name', 'last_name');

        $data['headline'] = "You searched for: {$search_query}";
        $data['page_title'] = "You searched for: {$search_query}";
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "search";

        echo Modules::run('template/admin', $data);
    }

	public function manage() {

        // in future, check for security
        $this->site_security->_make_sure_is_admin();

        // Count rows for pagination
        // #1 = the uri string, 
        // #2 = $this->uri->segment(3), 
        // #3 = how many items per page, 
        // #4 = how many to left and right 
        // EX: 1 means << 1 active 3 >>
        // Ex: 3 means << 1 2 3 active 5 6 7 >>
        $config = $this->site_security->_config_pagination('user/manage', '3', '1', '1');
        $config['total_rows'] = $this->count_all();
        $this->pagination->initialize($config);

        // Get rows for display
		$data['query'] = $this->get_with_limit($config['per_page'], $this->uri->segment(3), 'register_date DESC');

        // Configure the data that all pages should have
        $data['page_title'] = "Administration > Manage Users";
        $data['page_description'] = "";
        $data['total_rows'] = $config['total_rows'];
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "manage";

        echo Modules::run('template/admin', $data);
	}

	public function create() {

        // Check security
        $this->site_security->_make_sure_is_admin();

        $update_id = $this->uri->segment(3);

        if (isset($update_id)) {
            $row = $this->get_where_row('id', $update_id);
            if (!$row) {
                show_404();
            }
        }

        $submit = $this->input->post('submit', TRUE);

        if ($submit == "Cancel") {
            redirect('user/manage');
        }

        if ($submit == "Submit") {
            // Process the form
            $db_columns = array(
				'username', 'role', 'status', 'email', 'first_name', 
				'last_name', 'password', 'repeat_password'
			);
			$data = $this->get_data_from_post($db_columns);

            $password = trim($this->input->post('password', TRUE));

            $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]|max_length[50]');

            if (!is_numeric($update_id)) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[35]');
                $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[password]');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|is_unique[user.username]');
            } else {
                if (empty($password)) {
                    unset($data['password']);
                } else {
                    $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[35]');
                    $this->form_validation->set_rules('repeat_password', 'Repeat Password', 'required|matches[password]');
                }
            }

            // Get the user by update id and check for same email
            $user_to_update = $this->user->get_where_row('id', $update_id);
            $posted_email = $this->input->post('email', TRUE);
            if (($user_to_update) && $user_to_update->email == $posted_email) {
                $this->form_validation->set_rules('email', 'Email', 'required|min_length[8]|max_length[50]');
            } else {
                $this->form_validation->set_rules('email', 'Email', 'required|min_length[8]|max_length[50]|is_unique[user.email]');
            }


            if ($this->form_validation->run() == TRUE) {
                // Get the variables

                if (!empty($password)) {
                    $data['hash_pass'] = custom_hash("sha256", $this->input->post("password"), HASH_KEY);
                }

                $data['register_date'] = curent_date_for_mysql();

                if (is_numeric($update_id)) {
                    // Unset data for update that canot be changed
					unset($data['username']);
					unset($data['repeat_password']);
                    $data['last_seen'] = time();

                    if (empty($password)) {
                        unset($data['hash_pass']);
                    }

                    // Update the user details
                    $this->model->_update($update_id, $data);
                    $message = "The user details were successfully updated.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect('user/create/' . $update_id);
                } else {
					// Insert a new Item
					unset($data['password']);
					unset($data['repeat_password']);
                    $this->model->_insert($data);
                    $update_id = $this->model->get_max('id'); // get the ID of the new item

                    $message = "The user was successfully added.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect('user/create/' . $update_id);
                }
            }
        }


        if ((is_numeric($update_id)) && ($submit != "Submit")) {
            $data = $this->get_data_from_db($update_id)[0];
        } else {
			$db_columns = array(
				'username', 'role', 'status', 'email', 'first_name', 
				'last_name', 'password', 'repeat_password'
			);
			$data = $this->get_data_from_post($db_columns);
		}
		
        if (!is_numeric($update_id)) {
            $data['headline'] = "Add New User";
            $data['page_title'] = "Administration > Create new user";
        } else {
            $data['headline'] = "Update User Details";
            $data['page_title'] = "Manage user details: ".$data['username'];
        }

        $data['update_id'] = $update_id;
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "create";

        echo Modules::run('template/admin', $data);
    }

	public function deleteconf() {

        // in future, check for security
        $this->site_security->_make_sure_is_admin();

        $data['update_id'] = trim($this->uri->segment(3));

        if (!is_numeric($data['update_id'])) {
            redirect('admin');
        }

        $data['query'] = $this->get_where_row('id', $data['update_id']);

        $data['page_title'] = "Administration > Delete User > ".$data['query']->username;
        $data['page_description'] = "";
        $data['logged_user'] = $this->_logged_user;
        $data['alert'] = isset($this->session->alert) ? $this->session->alert : "";
        $data['module'] = $this->_module;
        $data['view_file'] = "deleteconf";

        echo Modules::run('template/admin', $data);
    }

    public function delete($id = FALSE) {
        if ($id != FALSE) {
            $this->site_security->_make_sure_is_admin();
            $id = trim($id);
            $row = $this->get_where_row('id', $id);

            if ($row) {
                // Genre found in database, attempt to delete
                if ($row->username == "admin") {
                    $message = "You can't delete the administrator of the website.";
                    $this->site_security->_alert('Danger! ', 'alert alert-danger', $message);
                    redirect("user/manage");
                } else {
                    $this->_delete($id);

                    $message = "The user was successfully deleted.";
                    $this->site_security->_alert('Info! ', 'alert alert-success', $message);
                    redirect("user/manage");
                }
            }
        } else {
            show_404();
        }
    }


}
