<?php

require_once 'api_base_controller.php';

/**
 * Description of api_tasks_controller
 *
 * @author JosephT
 * @property Tasks $tasks tasks lib
 */
class Api_Tasks_Controller extends Api_Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->checkLogIn();
        $this->load->library(['tasks']);
    }

    public function list_tasks($status = null) {
        $status_idx = ($status !== null) ? \api\Task::getStatus($status) : null;
        $this->response['tasks'] = $this->tasks->get_tasks($this->authToken->getCurrentUserId(), $status_idx, $this->input->get('max_id')) ? : [];
    }

}
