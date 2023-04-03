<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class vehicle extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        // $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        // $this->load->model('Billing_model');
    }

    // start vehicle part

    public function index()
    {
        $data['title'] = "Vehicle";
        $data['content'] = $this->load->view('Administrator/vehicle/add_vehicle', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function add_vehicle()
    {
        $res = ['success' => false, 'message' => ''];

        $vehicle = json_decode($this->input->raw_input_stream);

        try {
            $data        = (array)$vehicle;
            $data['AddBy']     = $this->session->userdata("FullName");
            $data['AddTime']   = date('Y-m-d H:i:s');
            $data['status']    = 'a';
            $data['branch_id'] = $this->brunch;

            $this->db->insert('tbl_vehicle', $data);
            $vehicleInsertId = $this->db->insert_id();

            if ($vehicle->driver) {
                // add driver history
                $result = $this->db->query("SELECT * FROM tbl_employee WHERE Employee_SlNo = ?", $vehicle->driver)->row();

                $driver = [];

                $driver['vehicle_id']      = $vehicleInsertId;
                $driver['date']            = date('Y-m-d');
                $driver['driver_id']       = $data['driver'];
                $driver['emp_name']        = $data['driver_name'];
                $driver['emp_salary']      = $result->salary_range;
                $driver['emp_designation'] = $result->Designation_ID;
                $driver['emp_department']  = $result->Department_ID;
                $driver['Add_By']          = $this->session->userdata("userId");
                $driver['addtime']         = date('Y-m-d H:i:s');

                $this->db->insert('tbl_employee_history', $driver);
            }
            if ($vehicle->helper) {
                // add helper history
                $q_helper = $this->db->query("SELECT * FROM tbl_employee WHERE Employee_SlNo = ?", $vehicle->helper)->row();

                $helper = [];

                $helper['vehicle_id']      = $vehicleInsertId;
                $helper['date']            = date('Y-m-d');
                $helper['helper_id']       = $data['helper'];
                $helper['emp_name']        = $data['helper_name'];
                $helper['emp_salary']      = $q_helper->salary_range;
                $helper['emp_designation'] = $q_helper->Designation_ID;
                $helper['emp_department']  = $q_helper->Department_ID;
                $helper['Add_By']          = $this->session->userdata("userId");
                $helper['addtime']         = date('Y-m-d H:i:s');

                $this->db->insert('tbl_employee_history', $helper);
            }
            $res = ['success' => true, 'message' => 'Vehicle added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }
        echo json_encode($res);
    }

    public function get_vehicle()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clause = '';
        // if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
        //     $clause .= " and vl.date between '$data->dateFrom' and '$data->dateTo'";
        // }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and vehicle_id = '$data->vehicle_id'";
        }

        $vehicle = $this->db->query("SELECT * FROM tbl_vehicle WHERE status = 'a' and branch_id = ? $clause", $this->brunch)->result();

        echo json_encode($vehicle);
    }

    public function get_all_vehicles()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clause = '';
        // if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
        //     $clause .= " and vl.date between '$data->dateFrom' and '$data->dateTo'";
        // }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and vehicle_id = '$data->vehicle_id'";
        }

        $vehicle = $this->db->query("SELECT * FROM tbl_vehicle WHERE status != 'd' and branch_id = ? $clause", $this->brunch)->result();

        echo json_encode($vehicle);
    }


    public function get_vehicle_license()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        // if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
        //     $clause .= " and vl.date between '$data->dateFrom' and '$data->dateTo'";
        // }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and vl.vehicle_id = '$data->vehicle_id'";
        }

        $vehicle = $this->db->query("SELECT vl.*,v.vehicle_reg_no
        FROM tbl_vehicle_license vl
        left JOIN tbl_vehicle v on v.vehicle_id = vl.vehicle_id
        WHERE vl.status = 'a'
        $clause
        and vl.branch_id = ?", $this->brunch)->result();

        $vehicle = array_map(function ($value) {
            $value->today = date('Y-m-d');
            $value->day_reg_expired = (strtotime($value->registration_expire_date) - strtotime(date('Y-m-d'))) / 86400;
            $value->day_road_permit_expired = (strtotime($value->roadPermit_expire_date) - strtotime(date('Y-m-d'))) / 86400;
            $value->day_fit_expired = (strtotime($value->fitness_expire_date) - strtotime(date('Y-m-d'))) / 86400;
            $value->day_token_expired = (strtotime($value->taxToken_expire_date) - strtotime(date('Y-m-d'))) / 86400;
            $value->day_insu_expired = (strtotime($value->insurance_expire_date) - strtotime(date('Y-m-d'))) / 86400;

            return $value;
        }, $vehicle);

        echo json_encode($vehicle);
    }

    public function update_vehicle()
    {
        $res = ['success' => false, 'message' => ''];
        $vehicle = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$vehicle;
            unset($data['vehicle_id']);
            unset($data['AddBy']);
            unset($data['AddTime']);
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->set($data)->where('vehicle_id', $vehicle->vehicle_id)->update('tbl_vehicle');


            $this->db->set($data)->where('vehicle_id', $vehicle->vehicle_id)->update('tbl_vehicle');
            $prevHistory = $this->db->query("SELECT * FROM tbl_employee_history WHERE vehicle_id = ?", $vehicle->vehicle_id)->result();

            // add driver history
            if ($vehicle->driver) {

                $exist_result = $this->db->query("SELECT * FROM tbl_employee_history WHERE vehicle_id = ? and driver_id <> 0 order by id desc LIMIT 1", $vehicle->vehicle_id)->row();


                if ($exist_result && $exist_result->driver_id != $vehicle->driver) {

                    $result = $this->db->query("SELECT * FROM tbl_employee WHERE Employee_SlNo = ?", $vehicle->driver)->row();

                    $driver = [];

                    $driver['vehicle_id']      = $vehicle->vehicle_id;
                    $driver['date']            = date('Y-m-d');
                    $driver['driver_id']       = $data['driver'];
                    $driver['emp_name']        = $data['driver_name'];
                    $driver['emp_salary']      = $result->salary_range;
                    $driver['emp_designation'] = $result->Designation_ID;
                    $driver['emp_department']  = $result->Department_ID;
                    $driver['Add_By']          = $this->session->userdata("userId");
                    $driver['addtime']         = date('Y-m-d H:i:s');

                    $this->db->insert('tbl_employee_history', $driver);
                }
            }

            // add helper history
            if ($vehicle->helper) {

                $exist_result_helper = $this->db->query("SELECT * FROM tbl_employee_history WHERE vehicle_id = ? and helper_id <> 0 order by id desc LIMIT 1", $vehicle->vehicle_id)->row();

                if ($exist_result_helper && $exist_result_helper->helper_id != $vehicle->helper) {

                    $q_helper = $this->db->query("SELECT * FROM tbl_employee WHERE Employee_SlNo = ?", $vehicle->helper)->row();

                    $helper = [];

                    $helper['vehicle_id']      = $vehicle->vehicle_id;
                    $helper['date']            = date('Y-m-d');
                    $helper['helper_id']       = $data['helper'];
                    $helper['emp_name']        = $data['helper_name'];
                    $helper['emp_salary']      = $q_helper->salary_range;
                    $helper['emp_designation'] = $q_helper->Designation_ID;
                    $helper['emp_department']  = $q_helper->Department_ID;
                    $helper['Add_By']          = $this->session->userdata("userId");
                    $helper['addtime']         = date('Y-m-d H:i:s');

                    $this->db->insert('tbl_employee_history', $helper);
                }
            }

            $res = ['success' => true, 'message' => 'Vehicle updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function delete_vehicle()
    {
        $res = ['success' => false, 'message' => ''];
        $vehicle = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['vehicle_id' => $vehicle->vehicle_id, 'branch_id' => $this->brunch])->update('tbl_vehicle');

            $res = ['success' => true, 'message' => 'vehicle deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function inactive_vehicle()
    {
        $res = ['success' => false, 'message' => ''];
        $vehicle = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'i'])->where(['vehicle_id' => $vehicle->vehicle_id, 'branch_id' => $this->brunch])->update('tbl_vehicle');

            $res = ['success' => true, 'message' => 'vehicle Inactive successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function active_vehicle()
    {
        $res = ['success' => false, 'message' => ''];
        $vehicle = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'a'])->where(['vehicle_id' => $vehicle->vehicle_id, 'branch_id' => $this->brunch])->update('tbl_vehicle');

            $res = ['success' => true, 'message' => 'vehicle Active successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    // end vehicle part
    // .....................................................................................................
    // // start service update part
    // public function serviceEntry()
    // {
    //     $data['title'] = "Service Entry";
    //     $data['content'] = $this->load->view('Administrator/vehicle/service-entry', $data, TRUE);
    //     $this->load->view('Administrator/index', $data);
    // }

    // public function saveVehicleService()
    // {
    //     $res = ['success' => false, 'message' => ''];

    //     $vsObj = json_decode($this->input->raw_input_stream);

    //     try {
    //         $data = (array)$vsObj;
    //         unset($data['service_id']);
    //         // unset($data['vehicle_reg_no']);
    //         $data['AddBy']    = $this->session->userdata("userId");
    //         $data['AddTime']  = date('Y-m-d H:i:s');
    //         $data['status']   = 'a';
    //         $data['branch_id']   = $this->brunch;

    //         $this->db->insert('tbl_vehicle_service', $data);

    //         $res = ['success' => true, 'message' => 'Vehicle sevice added successfully'];
    //     } catch (Exception $ex) {
    //         $res = ['success' => false, 'message' => $ex->getMessage()];
    //     }
    //     echo json_encode($res);
    // }

    // public function getVehicleService()
    // {
    //     $services = $this->db->query("SELECT vs.*,v.vehicle_reg_no
    //         FROM tbl_vehicle_service vs
    //         left join tbl_vehicle v on v.vehicle_id = vs.vehicle_id
    //         WHERE vs.status = 'a'
    //         and vs.branch_id = ?", $this->brunch)->result();
    //     echo json_encode($services);
    // }

    // public function updateVehicleService()
    // {
    //     $res = ['success' => false, 'message' => ''];
    //     $serviceObj = json_decode($this->input->raw_input_stream);
    //     $serviceId = $serviceObj->service_id;

    //     try {
    //         $data = (array)$serviceObj;
    //         unset($data['service_id']);
    //         $data['UpdateBy']    = $this->session->userdata("FullName");
    //         $data['updatetime']  = date('Y-m-d H:i:s');
    //         $data['branch_id']  = $this->brunch;

    //         $this->db->set($data)->where('service_id', $serviceId)->update('tbl_vehicle_service');

    //         $res = ['success' => true, 'message' => 'Vehicle Service updated Successfully'];
    //     } catch (Exception $ex) {
    //         $res = ['success' => false, 'message' => $ex->getMessage()];
    //         // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
    //     }

    //     echo json_encode($res);
    // }

    // public function deleteVehicleService()
    // {
    //     $res = ['success' => false, 'message' => ''];
    //     $serviceId = json_decode($this->input->raw_input_stream);

    //     try {
    //         $this->db->set(['status' => 'd'])->where(['service_id' => $serviceId->service_id, 'branch_id' => $this->brunch])->update('tbl_vehicle_service');

    //         $res = ['success' => true, 'message' => 'A service deleted successfully'];
    //     } catch (Exception $ex) {
    //         $res = ['success' => false, 'message' => $ex->getMessage()];
    //     }

    //     echo json_encode($res);
    // }
    // // end service update part

    // start service update part
    public function generalServiceEntry()
    {
        $data['title'] = "Service Entry";
        $data['content'] = $this->load->view('Administrator/vehicle/general-service-entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function tyreEntry()
    {
        $data['title'] = "Tyre Entry";
        $data['content'] = $this->load->view('Administrator/vehicle/tyre-entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAllTyreDetails()
    {
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        // if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
        //     $clauses .= " and m.date between '$data->dateFrom' and '$data->dateTo'";
        // }

        if (isset($data->tyre_id) && $data->tyre_id != 0 && $data->tyre_id != '') {

            $clauses .= " and tyre_id = '$data->tyre_id'";

            $tyreDetails = $this->db->query("SELECT te.*, v.vehicle_reg_no
                FROM tbl_tyre_entry te
                LEFT JOIN tbl_vehicle v on v.vehicle_id = te.vehicle_id 
                WHERE te.tyre_id = ?
            ", $data->tyre_id)->result();

            $res['tyreDetails'] = $tyreDetails;

            $spareTyres = $this->db->query("SELECT *
                FROM tbl_tyre_entry_details
                WHERE tyreEntryId = ?", $data->tyre_id)->result();

            $res['spare_cart'] = $spareTyres;
        }

        echo json_encode($res);
    }

    public function saveTyreEntry()
    {

        $dataObj = json_decode($this->input->raw_input_stream);

        $tyreId = $dataObj->data->tyre_id;

        try {
            $data = (array)$dataObj->data;
            unset($data['tyre_id']);

            if ($tyreId == '') {
                $data['date']      = date('Y-m-d');
                $data['status']    = 'a';
                $data['AddBy']     = $this->session->userdata("userId");
                $data['AddTime']   = date('Y-m-d H:i:s');
                $data['branch_id'] = $this->brunch;

                $this->db->insert('tbl_tyre_entry', $data);
                $tyreEntryId = $this->db->insert_id();

                foreach ($dataObj->cart as $key => $value) {
                    $details       = (array)$value;
                    $details['tyreEntryId'] = $tyreEntryId;
                    $details['status']      = 'a';

                    $this->db->insert('tbl_tyre_entry_details', $details);
                }

                $res = ['success' => true, 'message' => 'Data save successfully'];
            } else {
                $data['date']       = date('Y-m-d');
                $data['UpdateBy']   = $this->session->userdata("userId");
                $data['updatetime'] = date('Y-m-d H:i:s');
                $data['branch_id']  = $this->brunch;

                $this->db->where('tyre_id', $tyreId)->update('tbl_tyre_entry', $data);

                $this->db->where('tyreEntryId', $tyreId)->delete('tbl_tyre_entry_details');

                foreach ($dataObj->cart as $key => $value) {
                    $details       = (array)$value;
                    $details['tyreEntryId'] = $tyreId;
                    $details['status']      = 'a';

                    $this->db->insert('tbl_tyre_entry_details', $details);
                }
                $res = ['success' => true, 'message' => 'Data Update successfully'];
            }
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getTyreList()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and te.vehicle_id = '$data->vehicle_id'";
        }

        $result = $this->db->query("SELECT 
            te.*, v.vehicle_reg_no      
            FROM tbl_tyre_entry te
            left join tbl_vehicle v on v.vehicle_id = te.vehicle_id
            WHERE te.status = 'a' 
            and te.branch_id = ?
            $clause
        order by tyre_id desc", $this->brunch)->result();

        $result = array_map(function ($tyre) {
            $tyre->details = $this->db->query("SELECT * FROM tbl_tyre_entry_details WHERE `tyreEntryId` = ?", $tyre->tyre_id)->result();

            return $tyre;
        }, $result);

        echo json_encode($result);
    }


    // public function updateTyreEntry()
    // {
    //     $res = ['success' => false, 'message' => ''];

    //     $tyreObj = json_decode($this->input->raw_input_stream);
    //     $tyre_id = $tyreObj->data->tyre_id;
    //     $parts_cart =  $tyreObj->parts_cart;


    //     try {
    //         $data = (array)$tyreObj->data;
    //         // $tyre_cart = json_encode($tyreObj->parts_cart);
    //         unset($data['tyre_id']); 
    //         unset($data['vehicle_reg_no']); 
    //         $data['UpdateBy']    = $this->session->userdata("FullName");
    //         $data['updatetime']  = date('Y-m-d H:i:s');
    //         $data['branch_id']  = $this->brunch;

    //         $this->db->set($data)->where('tyre_id', $tyre_id)->update('tbl_tyre_entry');

    //         // foreach ($parts_cart as $key => $part) {
    //         //     $details = (array)$part;
    //         //     unset($details['id']); 
    //         //     unset($details['tyreEntryId']); 
    //         //     $details['tyreEntryId'] = $tyre_id;
    //         //     $this->db->insert('tbl_tyre_entry_details', $details);
    //         // }

    //         foreach ($parts_cart as $key => $part) 
    //         {
    //             $details = (array)$part; 
    //             unset($details['id']); 
    //             unset($details['tyreEntryId']); 
    //             $details['tyreEntryId'] =  $tyre_id;
    //             //$this->db->where('tyreEntryId', $tyre_id)->update('tbl_tyre_entry_details', $details);
    //             $this->db->insert('tbl_tyre_entry_details', $details);
    //         }

    //         $res = ['success' => true, 'message' => 'Data updated Successfully'];

    //     } catch (Exception $ex) {
    //         $res = ['success' => false, 'message' => $ex->getMessage()];
    //         // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
    //     }

    //     echo json_encode($res);
    // }


    public function deleteTyreEntry()
    {
        $res = ['success' => false, 'message' => ''];
        $tyreEntryId = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['tyre_id' => $tyreEntryId->tyre_id, 'branch_id' => $this->brunch])->update('tbl_tyre_entry');
            $this->db->set(['status' => 'd'])->where(['tyreEntryId' => $tyreEntryId->tyre_id])->update('tbl_tyre_entry_details');

            $res = ['success' => true, 'message' => 'Item deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function saveGeneralService()
    {
        $res = ['success' => false, 'message' => ''];

        $vsObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$vsObj;
            unset($data['general_service_id']);
            // unset($data['vehicle_reg_no']);
            $data['date']    = date('Y-m-d');
            $data['status']   = 'a';
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_general_service', $data);

            $res = ['success' => true, 'message' => 'Data save successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }
        echo json_encode($res);
    }

    public function getAllGeneralService()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clause .= " and gs.date between '$data->dateFrom' and '$data->dateTo'";
        }

        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and gs.vehicle_id = '$data->vehicle_id'";
        }

        $services = $this->db->query("SELECT 
            gs.general_service_id,
            gs.date, 
            gs.start_date, 
            gs.end_date, 
            gs.comments, 
            v.vehicle_reg_no, 
            gsl.general_service_name
        
            FROM tbl_general_service gs
            left join tbl_vehicle v on v.vehicle_id = gs.vehicle_id
            left join tbl_general_service_list gsl on gsl.id = gs.general_service_list_id
            WHERE gs.status = 'a'
            and gs.branch_id = ?
            $clause
        ", $this->brunch)->result();

        echo json_encode($services);
    }

    public function getAllGeneralServiceRemainder()
    {
        $data = json_decode($this->input->raw_input_stream);

        $now = date('Y-m-d');
        $search_date = date("Y-m-d", strtotime($now . ' + 15 days'));

        $clause = '';
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and gs.vehicle_id = '$data->vehicle_id'";
        }

        $services = $this->db->query("SELECT 
            gs.general_service_id,
            gs.date, 
            gs.start_date, 
            gs.end_date, 
            gs.comments, 
            v.vehicle_reg_no, 
            gsl.general_service_name
        
            FROM tbl_general_service gs
            left join tbl_vehicle v on v.vehicle_id = gs.vehicle_id
            left join tbl_general_service_list gsl on gsl.id = gs.general_service_list_id
            WHERE gs.status = 'a'
            " . ($data->type == "" ? "" : " and gs.end_date between '$now' and '$search_date' ") . "
            and gs.branch_id = ?
            $clause
            " . ($data->type == "" ? "" : " order by gs.general_service_id desc ") . "
        ", $this->brunch)->result();

        if (isset($data->type) && $data->type == 'remainder') {
            $services = array_map(function ($key, $trn) use ($now) {
                $now = strtotime($now);
                $end_date = strtotime($trn->end_date);
                $datediff = $end_date - $now;
                $trn->remain_day = round($datediff / (60 * 60 * 24));
                return $trn;
            }, array_keys($services), $services);
        }
        echo json_encode($services);
    }

    public function getAllGeneralServiceList()
    {
        $data = json_decode($this->input->raw_input_stream);
        // $now = date('Y-m-d');
        // $search_date = date("Y-m-d", strtotime($now. ' + 15 days'));
        $clause = '';

        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and gs.vehicle_id = '$data->vehicle_id'";
        }

        $services = $this->db->query(
            "SELECT gs.date, 
            gs.start_date, 
            gs.end_date, 
            gs.comments, 
            v.vehicle_reg_no, 
            gsl.general_service_name
        
        FROM tbl_general_service gs
        left join tbl_vehicle v on v.vehicle_id = gs.vehicle_id
        left join tbl_general_service_list gsl on gsl.id = gs.general_service_list_id
        WHERE gs.status = 'a' 
        and gs.branch_id = ?
        $clause
        order by general_service_id desc",
            $this->brunch
        )->result();

        echo json_encode($services);
    }


    public function updateGeneralService()
    {
        $res = ['success' => false, 'message' => ''];
        $gServiceObj = json_decode($this->input->raw_input_stream);
        $gServiceId = $gServiceObj->general_service_id;

        try {
            $data = (array)$gServiceObj;
            unset($data['general_service_id']);
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->set($data)->where('general_service_id', $gServiceId)->update('tbl_general_service');

            $res = ['success' => true, 'message' => 'Data updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteGeneralService()
    {
        $res = ['success' => false, 'message' => ''];
        $gServiceId = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['general_service_id' => $gServiceId->general_service_id, 'branch_id' => $this->brunch])->update('tbl_general_service');

            $res = ['success' => true, 'message' => 'Item deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    // end general service update part
    // ...................................................................................


    //  start general service list
    public function addGeneralServiceList()
    {
        $data['title'] = "Add General Service List";
        $data['content'] = $this->load->view('Administrator/vehicle/general-service-list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveGeneralServiceList()
    {
        $res = ['success' => false, 'message' => ''];

        $vsObj = json_decode($this->input->raw_input_stream);
        $listId = $vsObj->id;

        try {
            if ($listId == '') {
                $data = (array)$vsObj;
                unset($data['id']);
                $data['AddBy']    = $this->session->userdata("userId");
                $data['AddTime']  = date('Y-m-d H:i:s');
                $data['branch_id']   = $this->brunch;

                $this->db->insert('tbl_general_service_list', $data);
            } else {
                $data = (array)$vsObj;
                unset($data['id']);
                $this->db->where('id', $listId)->update('tbl_general_service_list', $data);
            }

            $res = ['success' => true, 'message' => 'Data save successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }
        echo json_encode($res);
    }

    public function getGeneralServiceList()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->status) && $data->status != '') {
            $clause .= " and status = '$data->status' ";
        }
        $services = $this->db->query("SELECT *
            FROM tbl_general_service_list
            WHERE branch_id = ?
            $clause
            order by id desc", $this->brunch)->result();

        echo json_encode($services);
    }
    // end service update part




    // start License update part
    public function licenseEntry()
    {
        $data['title'] = "License Entry";
        $data['content'] = $this->load->view('Administrator/vehicle/license-entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveVehicleLicense()
    {
        $res = ['success' => false, 'message' => ''];

        // $licenseObj = json_decode($this->input->raw_input_stream);
        $licenseObj = json_decode($this->input->post('data'));

        $this->db->select('*');
        $this->db->from('tbl_vehicle_license');
        $this->db->where(['vehicle_id' => $licenseObj->vehicle_id, 'branch_id' => $this->brunch, 'status' => 'a']);
        $check_duplicate = $this->db->get()->row();

        if ($check_duplicate) {
            $res = ['success' => false, 'message' => 'Vehicle duplicate found!'];
        } else {

            try {

                $vehicle = $licenseObj->vehicle_reg_no;

                $path = 'uploads/vehicle_docs/' . $vehicle;
                if (!file_exists($path)) {
                    mkdir($path);
                }

                if (!empty($_FILES['registrationImg'])) {
                    $arr = explode('.', $_FILES['registrationImg']['name']);
                    $extension = end($arr);
                    $registration = 'Registration.' . $extension;
                    move_uploaded_file($_FILES['registrationImg']['tmp_name'], $path . '/' . $registration);
                }
                if (!empty($_FILES['roadPermitImg'])) {
                    $arr = explode('.', $_FILES['roadPermitImg']['name']);
                    $extension = end($arr);
                    $roadPermit = 'Road_Permit.' . $extension;
                    move_uploaded_file($_FILES['roadPermitImg']['tmp_name'], $path . '/' . $roadPermit);
                }
                if (!empty($_FILES['fitnessImg'])) {
                    $arr = explode('.', $_FILES['fitnessImg']['name']);
                    $extension = end($arr);
                    $fitness = 'Fitness.' . $extension;
                    move_uploaded_file($_FILES['fitnessImg']['tmp_name'], $path . '/' . $fitness);
                }
                if (!empty($_FILES['taxTokenImg'])) {
                    $arr = explode('.', $_FILES['taxTokenImg']['name']);
                    $extension = end($arr);
                    $tax_token = 'Tax_Token.' . $extension;
                    move_uploaded_file($_FILES['taxTokenImg']['tmp_name'], $path . '/' . $tax_token);
                }
                if (!empty($_FILES['insuranceImg'])) {
                    $arr = explode('.', $_FILES['insuranceImg']['name']);
                    $extension = end($arr);
                    $insurance = 'Insurance.' . $extension;
                    move_uploaded_file($_FILES['insuranceImg']['tmp_name'], $path . '/' . $insurance);
                }


                $data = (array)$licenseObj;
                unset($data['license_id']);
                unset($data['vehicle_reg_no']);

                $data['registration_file_name'] = $registration ?? '';
                $data['roadPermit_file_name']   = $roadPermit ?? '';
                $data['fitness_file_name']      = $fitness ?? '';
                $data['tax_token_file_name']    = $tax_token ?? '';
                $data['insurance_file_name']    = $insurance ?? '';
                $data['AddBy']        = $this->session->userdata("userId");
                $data['AddTime']      = date('Y-m-d H:i:s');
                $data['status']       = 'a';
                $data['branch_id']    = $this->brunch;

                $this->db->insert('tbl_vehicle_license', $data);

                $res = ['success' => true, 'message' => 'Data save successfully'];
            } catch (Exception $ex) {
                $res = ['success' => false, 'message' => $ex->getMessage()];
            }
        }


        echo json_encode($res);
    }

    public function getVehicleLicense()
    {
        $license = $this->db->query("SELECT vl.*,v.vehicle_reg_no
            FROM tbl_vehicle_license vl
            left join tbl_vehicle v on v.vehicle_id = vl.vehicle_id
            WHERE vl.status = 'a'
            and vl.branch_id = ?", $this->brunch)->result();
        echo json_encode($license);
    }

    public function licenseExpairReminder()
    {
        $data['title'] = "License Entry";
        $data['content'] = $this->load->view('Administrator/vehicle/license-expair-reminder', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function licenseExpairReminderList()
    {

        $now = date('Y-m-d');
        //$search_date = date("Y-m-d", strtotime($now. ' + 15 days'));

        $license = $this->db->query("SELECT 
                        vl.registration_expire_date,
                        vl.roadPermit_expire_date,
                        vl.fitness_expire_date,
                        vl.taxToken_expire_date,
                        vl.insurance_expire_date,
                        v.vehicle_reg_no
                        FROM tbl_vehicle_license vl
                        left join tbl_vehicle v on v.vehicle_id = vl.vehicle_id
                        WHERE vl.status = 'a'
                        and vl.roadPermit_expire_date <= '$now'
                        or vl.registration_expire_date <= '$now'
                        or vl.fitness_expire_date <= '$now'
                        or vl.taxToken_expire_date <= '$now'
                        or vl.insurance_expire_date <= '$now'
                        and vl.branch_id = ?", $this->brunch)->result();

        $license = array_map(function ($key, $trn) use ($now) {
            $now = strtotime($now);

            //reg_expire_date//
            $end_date = strtotime($trn->registration_expire_date);
            $datediff = $end_date - $now;
            $trn->reg_remain_day = round($datediff / (60 * 60 * 24));

            //road_expire_date//
            $end_date = strtotime($trn->roadPermit_expire_date);
            $datediff = $end_date - $now;
            $trn->road_remain_day = round($datediff / (60 * 60 * 24));

            //fitness_expire_date//
            $end_date = strtotime($trn->fitness_expire_date);
            $datediff = $end_date - $now;
            $trn->fitness_remain_day = round($datediff / (60 * 60 * 24));

            //tax-token_expire_date//
            $end_date = strtotime($trn->taxToken_expire_date);
            $datediff = $end_date - $now;
            $trn->taxToken_remain_day = round($datediff / (60 * 60 * 24));

            //tax-token_expire_date//
            $end_date = strtotime($trn->insurance_expire_date);
            $datediff = $end_date - $now;
            $trn->insurance_remain_day = round($datediff / (60 * 60 * 24));

            return $trn;
        }, array_keys($license), $license);

        echo json_encode($license);
    }

    public function updateVehicleLicense()
    {
        $res = ['success' => false, 'message' => ''];
        // $licenseObj = json_decode($this->input->raw_input_stream);
        $licenseObj = json_decode($this->input->post('data'));

        $licenseId = $licenseObj->license_id;

        $this->db->select('*');
        $this->db->from('tbl_vehicle_license');
        $this->db->where(['vehicle_id' => $licenseObj->vehicle_id, 'branch_id' => $this->brunch, 'status' => 'a']);
        $this->db->where('license_id !=', $licenseObj->license_id);
        $check_duplicate = $this->db->get()->row();

        if ($check_duplicate) {
            $res = ['success' => false, 'message' => 'Vehicle duplicate found!'];
        } else {

            try {


                $vehicle = $licenseObj->vehicle_reg_no;

                $path = 'uploads/vehicle_docs/' . $vehicle;
                if (!file_exists($path)) {
                    mkdir($path);
                }

                if (!empty($_FILES['registrationImg'])) {
                    $arr = explode('.', $_FILES['registrationImg']['name']);
                    $extension = end($arr);
                    $registration = 'Registration.' . $extension;
                    move_uploaded_file($_FILES['registrationImg']['tmp_name'], $path . '/' . $registration);
                }
                if (!empty($_FILES['roadPermitImg'])) {
                    $arr = explode('.', $_FILES['roadPermitImg']['name']);
                    $extension = end($arr);
                    $roadPermit = 'Road_Permit.' . $extension;
                    move_uploaded_file($_FILES['roadPermitImg']['tmp_name'], $path . '/' . $roadPermit);
                }
                if (!empty($_FILES['fitnessImg'])) {
                    $arr = explode('.', $_FILES['fitnessImg']['name']);
                    $extension = end($arr);
                    $fitness = 'Fitness.' . $extension;
                    move_uploaded_file($_FILES['fitnessImg']['tmp_name'], $path . '/' . $fitness);
                }
                if (!empty($_FILES['taxTokenImg'])) {
                    $arr = explode('.', $_FILES['taxTokenImg']['name']);
                    $extension = end($arr);
                    $tax_token = 'Tax_Token.' . $extension;
                    move_uploaded_file($_FILES['taxTokenImg']['tmp_name'], $path . '/' . $tax_token);
                }
                if (!empty($_FILES['insuranceImg'])) {
                    $arr = explode('.', $_FILES['insuranceImg']['name']);
                    $extension = end($arr);
                    $insurance = 'Insurance.' . $extension;
                    move_uploaded_file($_FILES['insuranceImg']['tmp_name'], $path . '/' . $insurance);
                }



                $data = (array)$licenseObj;
                unset($data['license_id']);
                unset($data['vehicle_reg_no']);

                $data['registration_file_name'] = $registration ?? '';
                $data['roadPermit_file_name']   = $roadPermit ?? '';
                $data['fitness_file_name']      = $fitness ?? '';
                $data['tax_token_file_name']    = $tax_token ?? '';
                $data['insurance_file_name']    = $insurance ?? '';
                $data['UpdateBy']    = $this->session->userdata("FullName");
                $data['updatetime']  = date('Y-m-d H:i:s');
                $data['branch_id']  = $this->brunch;

                $this->db->set($data)->where('license_id', $licenseId)->update('tbl_vehicle_license');

                $res = ['success' => true, 'message' => 'Vehicle License updated Successfully'];
            } catch (Exception $ex) {
                $res = ['success' => false, 'message' => $ex->getMessage()];
                // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
            }
        }

        echo json_encode($res);
    }

    public function deleteVehicleLicense()
    {
        $res = ['success' => false, 'message' => ''];
        $licenseId = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['license_id' => $licenseId->license_id, 'branch_id' => $this->brunch])->update('tbl_vehicle_license');

            $res = ['success' => true, 'message' => 'A license deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    // License update end


    public function addRequisition()
    {
        $data['title'] = "Add Requisition";
        $lastInvoice = $this->db->query("select requisition_no from tbl_requisition order by requisition_id desc limit 1")->row();
        if ($lastInvoice) {
            $newReqNo = substr($lastInvoice->requisition_no, 1, 6) + 1;
            if (strlen($newReqNo) == 1) {
                $data['invoice'] = 'R00000' . $newReqNo;
            } else if (strlen($newReqNo) == 2) {
                $data['invoice'] = 'R0000' . $newReqNo;
            } else if (strlen($newReqNo) == 3) {
                $data['invoice'] = 'R000' . $newReqNo;
            } else if (strlen($newReqNo) == 4) {
                $data['invoice'] = 'R0' . $newReqNo;
            } else {
                $data['invoice'] = 'R' . $newReqNo;
            }
        } else {
            $data['invoice'] = 'R000001';
        }
        $data['requisition_id'] = 0;
        $data['content'] = $this->load->view('Administrator/vehicle/add_requisition', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    // public function getParts()
    // {
    //     $parts = $this->db->qurey("select * form tbl_product p where p.status = 'a'")->result();
    //     echo json_encode($parts);
    // }

    public function saveRequisition()
    {
        $res = ['success' => false, 'message' => ''];

        $requisition = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$requisition->req_data;
            unset($data['requisitionBy']);
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_requisition', $data);
            $requisitionId = $this->db->insert_id();

            foreach ($requisition->carts as $key => $value) {

                $details = (array)$value;
                unset($details['vehicle_reg_no']);
                unset($details['parts_name']);
                $details['requisition_id']  = $requisitionId;
                $details['date']    = date('Y-m-d');
                $details['AddBy']    = $this->session->userdata("userId");
                $details['AddTime']  = date('Y-m-d H:i:s');
                $details['status']   = 'a';
                $details['branch_id']   = $this->brunch;

                $this->db->insert('tbl_requisition_details', $details);
            }

            $res = ['success' => true, 'message' => 'Requisition added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }
        echo json_encode($res);
    }

    public function updateRequisition()
    {
        $res = ['success' => false, 'message' => ''];

        $requisition = json_decode($this->input->raw_input_stream);

        try {
            $reqId = $requisition->req_data->requisition_id;
            $data = (array)$requisition->req_data;
            unset($data['requisition_id']);
            unset($data['requisition_no']);
            unset($data['requisitionBy']);
            $data['updateby']    = $this->session->userdata("userId");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']   = $this->brunch;

            $this->db->where('requisition_id', $reqId)->update('tbl_requisition', $data);

            $this->db->where('requisition_id', $reqId)->delete('tbl_requisition_details');

            foreach ($requisition->carts as $key => $value) {

                $details = (array)$value;
                unset($details['vehicle_reg_no']);
                unset($details['parts_name']);
                $details['requisition_id']    = $reqId;
                $details['date']    = date('Y-m-d');
                $details['AddBy']    = $this->session->userdata("userId");
                $details['AddTime']  = date('Y-m-d H:i:s');
                $details['status']   = 'a';
                $details['branch_id']   = $this->brunch;

                $this->db->insert('tbl_requisition_details', $details);
            }

            $res = ['success' => true, 'message' => 'Requisition updated successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }
        echo json_encode($res);
    }

    public function deleteRequisition()
    {
        $res = ['success' => false, 'message' => ''];
        $requisition = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['requisition_id' => $requisition->requisition_id, 'branch_id' => $this->brunch])->update('tbl_requisition');

            $this->db->set(['status' => 'd'])->where(['requisition_id' => $requisition->requisition_id, 'branch_id' => $this->brunch])->update('tbl_requisition_details');

            $res = ['success' => true, 'message' => 'Requisition deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getAllRequisitions()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->requisition_id) and $data->requisition_id != '') {
            $clause .= " and r.requisition_id = '$data->requisition_id'";
        }

        if (isset($data->requisition_id) and $data->requisition_id != '') {
            $res['reqDetails'] = $this->db->query("SELECT rd.*,v.vehicle_reg_no,p.Product_Name
            FROM tbl_requisition_details rd
            LEFT JOIN tbl_vehicle v on v.vehicle_id = rd.vehicle_id
            left join tbl_product p on p.Product_SlNo = rd.parts_id
            WHERE rd.status = 'a'
            and rd.branch_id = ?
            and rd.requisition_id = ?
              ", [$this->brunch, $data->requisition_id])->result();
        }

        $res['requisition'] = $this->db->query("SELECT r.*, u.User_Name, u.User_ID
        FROM tbl_requisition r
        LEFT JOIN tbl_user u on u.User_SlNo = r.AddBy
        WHERE r.status = 'a'
        and r.branch_id = ?
        $clause
        ", $this->brunch)->result();
        echo json_encode($res);
    }

    public function requisitionRecord()
    {
        $data['title'] = "Requisition Record";
        $data['content'] = $this->load->view('Administrator/vehicle/requisition-record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function requisitions()
    {
        $data['title'] = "Requisitions";
        $data['content'] = $this->load->view('Administrator/vehicle/requisitions', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getRequisitionsReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';

        if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
            $clause .= " and r.date between '$data->dateFrom' and '$data->dateTo'";
        }
        if (isset($data->userFullName) && $data->userFullName != '') {
            $clause .= " and u.User_Name = '$data->userFullName'";
        }
        if (isset($data->purchase_order) && $data->purchase_order != '') {
            $clause .= " and r.purchase_order_status = 'pending'";
        }

        $requisition = $this->db->query("SELECT r.*, u.User_Name, u.User_ID
        FROM tbl_requisition r
        LEFT JOIN tbl_user u on u.User_SlNo = r.AddBy
        WHERE r.status = 'a'
        and r.branch_id = ?
        $clause
        ", $this->brunch)->result();

        if ((isset($data->recordType) && $data->recordType == 'with_details') || isset($data->purchase_order) && $data->purchase_order == 'yes') {

            foreach ($requisition as $key => $value) {
                $value->requisitionDetails = $this->db->query("SELECT rd.*,v.vehicle_reg_no,p.Product_Name
                FROM tbl_requisition_details rd
                LEFT JOIN tbl_vehicle v on v.vehicle_id = rd.vehicle_id
                left join tbl_product p on p.Product_SlNo = rd.parts_id
                WHERE rd.status = 'a'
                and rd.requisition_id = ?                  
                ", $value->requisition_id)->result();
            }
        }

        echo json_encode($requisition);
    }

    public function requisitionPrint($reqId)
    {
        $data['title'] = "Requisition Form";
        $data['requisition_id'] = $reqId;
        $data['content'] = $this->load->view('Administrator/vehicle/requisition-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function requisition_edit($reqId)
    {
        $data['title'] = "Requisition Update";
        $requisition = $this->db->query("select * from tbl_requisition where requisition_id = ?", $reqId)->row();
        $data['requisition_id'] = $reqId;
        $data['invoice'] = $requisition->requisition_no;
        $data['content'] = $this->load->view('Administrator/vehicle/add_requisition', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function makePurchaseOrder()
    {
        redirect('Administrator/Purchase/order');
    }

    public function directPurchase()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }
        $data['title'] = "Direct Purchase";

        $invoice = $this->mt->generatePurchaseInvoice();

        $data['purchaseId'] = 0;
        $data['invoice'] = $invoice;
        $data['content'] = $this->load->view('Administrator/vehicle/direct-purchase', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function savePurchaseOrder()
    {
        $res = ['success' => false, 'message' => ''];
        $dataObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$dataObj->data;
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_purchase_order', $data);
            $purchaseOrderId = $this->db->insert_id();

            foreach ($dataObj->cart as $product) {
                $purchaseOrderDetails = array(
                    'purchaseOrder_id' => $purchaseOrderId,
                    'date'             => $product->date ?? date('Y-m-d'),
                    'vehicle_id'       => $product->vehicle_id ?? '',
                    'parts_id'         => $product->parts_id,
                    'quantity'         => $product->quantity,
                    'unit_price'       => $product->unit_price,
                    'total_amount'     => $product->total_amount,
                    'Status'           => 'a',
                    'AddBy'            => $this->session->userdata("userId"),
                    'AddTime'          => date('Y-m-d H:i:s'),
                    'branch_id'        => $this->brunch,
                );

                $this->db->insert('tbl_purchase_order_details', $purchaseOrderDetails);
            }

            if (isset($data['requisition_id'])) {

                $this->db->set(['purchase_order_status' => 'complete', 'purchase_order_id' => $purchaseOrderId])->where('requisition_id', $data['requisition_id'])->update('tbl_requisition');
            }

            $res = ['success' => true, 'message' => 'Purchase Order Save Successfully', 'purchaseOrderId' => $purchaseOrderId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function updatePurchaseOrder()
    {
        $res = ['success' => false, 'message' => ''];
        $dataObj = json_decode($this->input->raw_input_stream);

        $u_id = $dataObj->data->purchaseOrder_id;

        try {
            $data = (array)$dataObj->data;
            unset($data['purchaseOrder_id']);
            unset($data['purchaseOrder_invoiceNo']);
            if (isset($data['requisition_id'])) {
                unset($data['requisition_id']);
            }
            $data['updateby']    = $this->session->userdata("userId");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']   = $this->brunch;

            $this->db->where('purchaseOrder_id', $u_id)->update('tbl_purchase_order', $data);

            $this->db->where('purchaseOrder_id', $u_id)->delete('tbl_purchase_order_details');

            foreach ($dataObj->cart as $product) {
                $purchaseOrderDetails = array(
                    'purchaseOrder_id' => $u_id,
                    'date'             => $product->date ?? date('Y-m-d'),
                    'vehicle_id'       => $product->vehicle_id ?? '',
                    'parts_id'         => $product->parts_id,
                    'quantity'         => $product->quantity,
                    'unit_price'       => $product->unit_price,
                    'total_amount'     => $product->total_amount,
                    'Status'           => 'a',
                    'AddBy'            => $this->session->userdata("userId"),
                    'AddTime'          => date('Y-m-d H:i:s'),
                    'branch_id'        => $this->brunch,
                );

                $this->db->insert('tbl_purchase_order_details', $purchaseOrderDetails);
            }

            // foreach ($dataObj->cart as $product) {
            //     $purchaseOrderDetails = array(
            //         'parts_id'     => $product->parts_id ?? '',
            //         'quantity'     => $product->quantity ?? '',
            //         'unit_price'   => $product->unit_price,
            //         'total_amount' => $product->total_amount,
            //         'AddBy'        => $this->session->userdata("userId"),
            //         'AddTime'      => date('Y-m-d H:i:s'),
            //         'branch_id'    => $this->brunch,
            //     );

            //     $this->db->insert('tbl_purchase_order_details', $purchaseOrderDetails);
            // }

            // $this->db->set(['purchase_order_status' => 'complete', 'purchase_order_id' => $purchaseOrderId])->where('requisition_id', $data['requisition_id'])->update('tbl_requisition');

            $res = ['success' => true, 'message' => 'Purchase Order Update Successfully', 'purchaseOrderId' => $u_id];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function purchaseOrderRecord()
    {
        $data['title'] = "Purchase Order Record";
        $data['content'] = $this->load->view('Administrator/vehicle/purchase-order-record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getPurchaseOrderReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
            $clause .= " and po.purchaseOrder_date between '$data->dateFrom' and '$data->dateTo'";
        }
        if (isset($data->userFullName) && $data->userFullName != '') {
            $clause .= " and u.User_Name = '$data->userFullName'";
        }
        // if (isset($data->purchase_order) && $data->purchase_order != '') {
        //     $clause .= " and r.purchase_order_status = 'pending'";
        // }

        $purchaseOrder = $this->db->query("SELECT po.*,s.Supplier_Name,s.Supplier_Mobile,s.Supplier_Address, q.requisition_no, u.User_Name, u.User_ID
        FROM tbl_purchase_order po
        LEFT JOIN tbl_user u on u.User_SlNo = po.AddBy
        left join tbl_requisition q on q.requisition_id = po.requisition_id                
        left join tbl_supplier s on s.Supplier_SlNo = po.supplier_id
        WHERE po.status = 'a'
        and po.branch_id = ?
        $clause
        ", $this->brunch)->result();

        if ((isset($data->recordType) && $data->recordType == 'with_details') || isset($data->purchase_order) && $data->purchase_order == 'yes') {

            foreach ($purchaseOrder as $key => $value) {
                $value->purchaseOrderDetails = $this->db->query("SELECT pod.*,v.vehicle_reg_no,p.Product_Name
                FROM tbl_purchase_order_details pod
                LEFT JOIN tbl_vehicle v on v.vehicle_id = pod.vehicle_id
                left join tbl_product p on p.Product_SlNo = pod.parts_id
                WHERE pod.status = 'a'
                and pod.purchaseOrder_id = ?                  
                ", $value->purchaseOrder_id)->result();
            }
        }

        echo json_encode($purchaseOrder);
    }

    public function purchaseOrderPrint($Id)
    {
        $data['title'] = "Purchase Order";
        $data['id'] = $Id;
        $data['content'] = $this->load->view('Administrator/vehicle/purchase-order-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAllPurchaseOrder()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->purchaseOrder_id) and $data->purchaseOrder_id != '') {
            $clause .= " and po.purchaseOrder_id = '$data->purchaseOrder_id'";
        }

        if (isset($data->purchaseOrder_id) and $data->purchaseOrder_id != '') {
            $res['purchaseOrderDetails'] = $this->db->query("SELECT pod.*,v.vehicle_reg_no,p.Product_Name,
                (select ifnull(sum(pd.PurchaseDetails_TotalQuantity),0)
                from tbl_purchasedetails pd
                left JOIN tbl_purchasemaster pm on pm.PurchaseMaster_SlNo = pd.PurchaseMaster_IDNo
                where pm.PurchaseMaster_InvoiceNo = po.purchaseOrder_invoiceNo
                and pd.Product_IDNo = pod.parts_id) as already_received_qty
                FROM tbl_purchase_order_details pod
                LEFT JOIN tbl_vehicle v on v.vehicle_id = pod.vehicle_id
                left join tbl_product p on p.Product_SlNo = pod.parts_id
                JOIN tbl_purchase_order po on po.purchaseOrder_id = pod.purchaseOrder_id            
                WHERE pod.status = 'a'
                and pod.branch_id = ?
                and pod.purchaseOrder_id = ?
            ", [$this->brunch, $data->purchaseOrder_id])->result();
        }

        $res['purchaseOrder'] = $this->db->query("SELECT po.*,r.requisition_no,s.Supplier_Code,s.Supplier_Name,s.Supplier_Mobile,s.Supplier_Address,s.Supplier_Type, u.User_Name, u.User_ID,

            (SELECT ifnull(sum(pod.quantity),0)
            from tbl_purchase_order_details pod
            WHERE pod.purchaseOrder_id = po.purchaseOrder_id
            ) as order_qty,
            
            (SELECT ifnull(sum(pd.PurchaseDetails_TotalQuantity),0)
            from tbl_purchasedetails pd
            LEFT JOIN tbl_purchasemaster pm on pm.PurchaseMaster_SlNo = pd.PurchaseMaster_IDNo
            WHERE pm.PurchaseMaster_InvoiceNo = po.purchaseOrder_invoiceNo
            ) as received_qty
            
            FROM tbl_purchase_order po
            LEFT JOIN tbl_user u on u.User_SlNo = po.AddBy        
            left join tbl_supplier s on s.Supplier_SlNo = po.supplier_id
            left join tbl_requisition r on r.requisition_id = po.requisition_id
            WHERE po.status = 'a'
            and po.branch_id = ?
            $clause
        ", $this->brunch)->result();

        // $res['purchaseOrder'] = $this->db->query("SELECT po.*,r.requisition_no,s.Supplier_Code,s.Supplier_Name,s.Supplier_Mobile,s.Supplier_Address, u.User_Name, u.User_ID
        // FROM tbl_purchase_order po
        // LEFT JOIN tbl_user u on u.User_SlNo = po.AddBy        
        // left join tbl_supplier s on s.Supplier_SlNo = po.supplier_id
        // left join tbl_requisition r on r.requisition_id = po.requisition_id
        // WHERE po.status = 'a'
        // and po.branch_id = ?
        // $clause
        // ", $this->brunch)->result();

        echo json_encode($res);
    }


    public function purchaseChalanPrint($purchaseId)
    {
        $data['title'] = "Purchase Invoice";
        $data['purchaseId'] = $purchaseId;
        $data['content'] = $this->load->view('Administrator/vehicle/purchaseAndReport', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function getPurchaseChalan()
    {
        // $data = json_decode($this->input->raw_input_stream);
        // $branchId = $this->session->userdata("BRANCHid");

        // if(isset($data->purchaseId) && $data->purchaseId != 0 && $data->purchaseId != '')
        // {
        //     $clauses .= " and PurchaseMaster_SlNo = '$data->purchaseId'";

        //     $purchase = $this->db->query("
        //         select *
        //         from tbl_purchasedetails pd
        //         where pd.PurchaseMaster_IDNo = ?
        //     ", $data->purchaseId)->result(); 

        //     echo json_encode($purchase);
        // }

        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata('BRANCHid');

        // $clauses = "";
        // if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
        //     $clauses .= " and pm.PurchaseMaster_OrderDate between '$data->dateFrom' and '$data->dateTo'";
        // }

        // if (isset($data->supplierId) && $data->supplierId != '') {
        //     $clauses .= " and pm.Supplier_SlNo = '$data->supplierId'";
        // }

        $purchaseIdClause = "";
        if (isset($data->purchaseId) && $data->purchaseId != null) {
            //$purchaseIdClause = " and pm.PurchaseMaster_SlNo = '$data->purchaseId'";

            $purchaseDetails = $this->db->query("
                select
                    pd.PurchaseDetails_TotalQuantity as issueQuantity,
                    pd.PurchaseDetails_Note,
                    ci.*,
                    (select (ci.purchase_quantity + ci.sales_return_quantity + ci.transfer_to_quantity + ci.wastage_restore_qty) - (ci.sales_quantity + ci.purchase_return_quantity + ci.damage_quantity + ci.transfer_from_quantity)) as current_quantity,
                    p.Product_Name,
                    p.Product_Code,
                    p.ProductCategory_ID,
                    p.Product_SellingPrice,
                    pc.ProductCategory_Name,
                    u.Unit_Name,
                    r.total_quantity as requisition_quantity
                from tbl_purchasedetails pd 
                join tbl_product p on p.Product_SlNo = pd.Product_IDNo
                join tbl_purchasemaster pm on pm.PurchaseMaster_SlNo = pd.PurchaseMaster_IDNo
                join tbl_purchase_order po on po.purchaseOrder_invoiceNo = pm.PurchaseMaster_InvoiceNo 
                join tbl_requisition r on r.requisition_id = po.requisition_id
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                join tbl_unit u on u.Unit_SlNo = p.Unit_ID
                join tbl_currentinventory ci on ci.product_id = pd.Product_IDNo  
                where pd.PurchaseMaster_IDNo = '$data->purchaseId'
            ")->result();

            $res['purchaseDetails'] = $purchaseDetails;
            $res['issueQuantity'] = array_sum(
                array_map(function ($product) {
                    return $product->issueQuantity;
                }, $purchaseDetails)
            );

            echo json_encode($res);
        }
    }

    // public function purchaseOrderEdit($id)
    // {
    //     $data['title'] = "Purchase Order Update";
    //     $result = $this->db->query("select * from tbl_purchase_order where purchaseOrder_id = ?", $id)->row();
    //     $data['id'] = $id;
    //     $data['invoice'] = $result->purchaseOrder_invoiceNo;
    //     $data['content'] = $this->load->view('Administrator/Purchase/order', $data, TRUE);
    //     $this->load->view('Administrator/index', $data);
    // }
    public function directPurchaseEdit($id)
    {
        $data['title'] = "Direct Purchase Order Update";
        $result = $this->db->query("select * from tbl_purchase_order where purchaseOrder_id = ?", $id)->row();
        $data['purchaseId'] = $id;
        $data['invoice'] = $result->purchaseOrder_invoiceNo;
        $data['content'] = $this->load->view('Administrator/vehicle/direct-purchase-edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    public function deletePurchaseOrder()
    {
        $res = ['success' => false, 'message' => ''];
        $dataObj = json_decode($this->input->raw_input_stream);

        try {
            $oldPurchaseOrder = $this->db->query("select * from tbl_purchase_order where purchaseOrder_id = ?", $dataObj->purchaseOrder_id)->row();

            $this->db->set(['status' => 'd'])->where(['purchaseOrder_id' => $dataObj->purchaseOrder_id, 'branch_id' => $this->brunch])->update('tbl_purchase_order');

            $this->db->set(['status' => 'd'])->where(['purchaseOrder_id' => $dataObj->purchaseOrder_id, 'branch_id' => $this->brunch])->update('tbl_purchase_order_details');

            $this->db->set(['purchase_order_status' => 'pending', 'purchase_order_id' => ''])->where('requisition_id', $oldPurchaseOrder->requisition_id)->update('tbl_requisition');

            $res = ['success' => true, 'message' => 'Purchase Order deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function receivedChallanUpdate()
    {
        $data['title'] = "Received Challan Update";
        $data['content'] = $this->load->view('Administrator/vehicle/received-challan', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    // start supplier evaluation part
    public function supplierEvaluation($id = null)
    {
        $data['id'] = $id == null ? '' : $id;
        $data['title'] = "Supplier Evaluation";
        $data['content'] = $this->load->view('Administrator/vehicle/supplier-evaluation', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveSupplierEvaluation()
    {
        $res = ['success' => false, 'message' => ''];

        $supEvaObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$supEvaObj->details;
            unset($data['supplier_evaluation_id ']);
            // unset($data['vehicle_reg_no']);
            $data['date']    = date('Y-m-d');
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_sup_evaluation', $data);
            $se_id = $this->db->insert_id();

            foreach ($supEvaObj->cart as $value) {
                $data2 = (array)$value;
                $data2['supplier_evaluation_id']    = $se_id;
                $data2['status']    = 'a';

                $this->db->insert('tbl_sup_evaluation_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Supplier Evaluation added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getSupplierEvaluation()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = '';
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and se.date between '$data->dateFrom' and '$data->dateTo'";
        }
        if (isset($data->supplier_id) && $data->supplier_id != '') {
            $clauses .= " and se.supplier_Id = '$data->supplier_id'";
        }
        if (isset($data->supplier_evaluation_id) && $data->supplier_evaluation_id != '') {
            $clauses .= " and se.supplier_evaluation_id = '$data->supplier_evaluation_id'";
        }

        $evaluations = $this->db->query("SELECT se.*,s.Supplier_Name,s.Supplier_Address, concat(se.period_of_evaluation_from,' - ',se.period_of_evaluation_to) as period_of_evaluation
            FROM tbl_sup_evaluation se
            left join tbl_supplier s on s.Supplier_SlNo = se.supplier_Id
            WHERE se.status = 'a'
            and se.branch_id = ?
            $clauses
            order by supplier_evaluation_id desc", $this->brunch)->result();

        foreach ($evaluations as $value) {
            $value->details = $this->db->query("select sed.* from tbl_sup_evaluation_details sed where sed.supplier_evaluation_id = $value->supplier_evaluation_id")->result();
        }
        echo json_encode($evaluations);
    }

    public function updateSupplierEvaluation()
    {
        $res = ['success' => false, 'message' => ''];
        $supEvaObj = json_decode($this->input->raw_input_stream);
        $updateId = $supEvaObj->details->supplier_evaluation_id;

        // echo json_encode($updateId);
        // exit;

        try {

            $data = (array)$supEvaObj->details;
            unset($data['supplier_evaluation_id']);
            // unset($data['vehicle_reg_no']);
            // $data['date']    = date('Y-m-d');
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->set($data)->where('supplier_evaluation_id', $updateId)->update('tbl_sup_evaluation');

            $this->db->query("DELETE FROM tbl_sup_evaluation_details WHERE supplier_evaluation_id = ?", $updateId);

            foreach ($supEvaObj->cart as $value) {
                $data2 = (array)$value;
                unset($data2['SEvaluation_details_id']);
                $data2['supplier_evaluation_id']    = $updateId;
                $data2['status']    = 'a';

                $this->db->insert('tbl_sup_evaluation_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Supplier Evaluation updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteSupplierEvaluation()
    {
        $res = ['success' => false, 'message' => ''];
        $supEvaObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['supplier_evaluation_id' => $supEvaObj->supplier_evaluation_id, 'branch_id' => $this->brunch])->update('tbl_sup_evaluation');

            $this->db->set(['status' => 'd'])->where(['supplier_evaluation_id' => $supEvaObj->supplier_evaluation_id])->update('tbl_sup_evaluation_details');

            $res = ['success' => true, 'message' => ' deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }


    // start supplier feedback part
    public function supplierFeedback()
    {
        $data['title'] = "Supplier Feedback";
        $data['content'] = $this->load->view('Administrator/vehicle/supplier-feedback', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveSupplierFeedback()
    {
        $res = ['success' => false, 'message' => ''];

        $supFeedbackObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$supFeedbackObj->details;
            unset($data['sup_feedback_id ']);
            // unset($data['vehicle_reg_no']);
            $data['date']    = date('Y-m-d');
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_sup_feedback', $data);
            $sf_id = $this->db->insert_id();

            foreach ($supFeedbackObj->cart as $value) {
                $data2 = (array)$value;
                $data2['sup_feedback_id']    = $sf_id;
                $data2['status']    = 'a';

                $this->db->insert('tbl_sup_feedback_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Supplier feedback added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getSupplierfeedback()
    {
        $feedbacks = $this->db->query("SELECT sf.*,s.Supplier_Name
            FROM tbl_sup_feedback sf
            left join tbl_supplier s on s.Supplier_SlNo = sf.supplier_Id
            WHERE sf.status = 'a'
            and sf.branch_id = ?
            order by sup_feedback_id desc", $this->brunch)->result();

        foreach ($feedbacks as $value) {
            $value->details = $this->db->query("select sfd.* from tbl_sup_feedback_details sfd where sfd.sup_feedback_id = $value->sup_feedback_id")->result();
        }
        echo json_encode($feedbacks);
    }

    public function updateSupplierfeedback()
    {
        $res = ['success' => false, 'message' => ''];
        $supFeedbackObj = json_decode($this->input->raw_input_stream);
        $updateId = $supFeedbackObj->details->sup_feedback_id;

        try {
            $data = (array)$supFeedbackObj->details;
            unset($data['sup_feedback_id']);
            // unset($data['vehicle_reg_no']);
            // $data['date']    = date('Y-m-d');
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->set($data)->where('sup_feedback_id', $updateId)->update('tbl_sup_feedback');

            $this->db->query("DELETE FROM tbl_sup_feedback_details WHERE sup_feedback_id = ?", $updateId);

            foreach ($supFeedbackObj->cart as $value) {
                $data2 = (array)$value;
                unset($data2['sup_feedback_details_id']);
                $data2['sup_feedback_id']    = $updateId;
                $data2['status']    = 'a';

                $this->db->insert('tbl_sup_feedback_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Supplier feedback updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteSupplierfeedback()
    {
        $res = ['success' => false, 'message' => ''];
        $supFeedbackObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['sup_feedback_id' => $supFeedbackObj->sup_feedback_id, 'branch_id' => $this->brunch])->update('tbl_sup_feedback');

            $this->db->set(['status' => 'd'])->where(['sup_feedback_id' => $supFeedbackObj->sup_feedback_id])->update('tbl_sup_feedback_details');

            $res = ['success' => true, 'message' => ' deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }




    // start Customer feedback part
    public function customerFeedback()
    {
        $data['title'] = "Customer Feedback";
        $data['content'] = $this->load->view('Administrator/vehicle/customer-feedback', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveCustomerFeedback()
    {
        $res = ['success' => false, 'message' => ''];

        $cusFeedbackObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$cusFeedbackObj->details;
            unset($data['cus_feedback_id ']);
            // unset($data['vehicle_reg_no']);
            $data['date']    = date('Y-m-d');
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_cus_feedback', $data);
            $cf_id = $this->db->insert_id();

            foreach ($cusFeedbackObj->cart as $value) {
                $data2 = (array)$value;
                $data2['cus_feedback_id']    = $cf_id;
                $data2['status']    = 'a';

                $this->db->insert('tbl_cus_feedback_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Customer feedback added successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getCustomerfeedback()
    {
        $feedbacks = $this->db->query("SELECT cf.*,c.Customer_Name,c.Customer_Address
            FROM tbl_cus_feedback cf
            left join tbl_customer c on c.Customer_SlNo = cf.customer_Id
            WHERE cf.status = 'a'
            and cf.branch_id = ?
            order by cus_feedback_id desc", $this->brunch)->result();

        foreach ($feedbacks as $value) {
            $value->details = $this->db->query("select cfd.* from tbl_cus_feedback_details cfd where cfd.cus_feedback_id = $value->cus_feedback_id")->result();
        }
        echo json_encode($feedbacks);
    }

    public function updateCustomerfeedback()
    {
        $res = ['success' => false, 'message' => ''];
        $cusFeedbackObj = json_decode($this->input->raw_input_stream);
        $updateId = $cusFeedbackObj->details->cus_feedback_id;

        try {
            $data = (array)$cusFeedbackObj->details;
            unset($data['cus_feedback_id']);
            // unset($data['vehicle_reg_no']);
            // $data['date']    = date('Y-m-d');
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->set($data)->where('cus_feedback_id', $updateId)->update('tbl_cus_feedback');

            $this->db->query("DELETE FROM tbl_cus_feedback_details WHERE cus_feedback_id = ?", $updateId);

            foreach ($cusFeedbackObj->cart as $value) {
                $data2 = (array)$value;
                unset($data2['cus_feedback_details_id']);
                $data2['cus_feedback_id']    = $updateId;
                $data2['status']    = 'a';

                $this->db->insert('tbl_cus_feedback_details', $data2);
            }

            $res = ['success' => true, 'message' => 'Customer feedback updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteCustomerfeedback()
    {
        $res = ['success' => false, 'message' => ''];
        $cusFeedbackObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['cus_feedback_id' => $cusFeedbackObj->cus_feedback_id, 'branch_id' => $this->brunch])->update('tbl_cus_feedback');

            $this->db->set(['status' => 'd'])->where(['cus_feedback_id' => $cusFeedbackObj->cus_feedback_id])->update('tbl_cus_feedback_details');

            $res = ['success' => true, 'message' => ' deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }



    // start add Accidental Record
    public function addAccidentalRecord($id = null)
    {
        $data['id'] = $id != null ? $id : '';
        $data['title'] = "Add Accidental Records";
        $data['content'] = $this->load->view('Administrator/vehicle/add_accidental_records', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveAccidentalRecord()
    {
        $res = ['success' => false, 'message' => ''];

        $accRecordObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$accRecordObj;
            unset($data['accidental_record_id ']);
            $data['date']    = date('Y-m-d');
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_accidental_record', $data);
            $insertId = $this->db->insert_id();

            $res = ['success' => true, 'message' => 'Accidental Record save successfully', 'id' => $insertId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getAccidentalRecord()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = '';
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and ar.date between '$data->dateFrom' and '$data->dateTo'";
        }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clauses .= " and ar.vehicle_id = '$data->vehicle_id'";
        }
        if (isset($data->accident_category) && $data->accident_category != '') {
            $clauses .= " and ar.accident_category = '$data->accident_category'";
        }
        if (isset($data->accidental_record_id) && $data->accidental_record_id != '') {
            $clauses .= " and ar.accidental_record_id = '$data->accidental_record_id'";
        }

        $records = $this->db->query("SELECT ar.*,v.vehicle_reg_no
            FROM tbl_accidental_record ar
            left join tbl_vehicle v on v.vehicle_id = ar.vehicle_id
            WHERE ar.status = 'a'
            and ar.branch_id = ?
            $clauses
            order by accidental_record_id desc", $this->brunch)->result();

        echo json_encode($records);
    }

    public function updateAccidentalRecord()
    {
        $res = ['success' => false, 'message' => ''];
        $accRecordObj = json_decode($this->input->raw_input_stream);
        $updateId = $accRecordObj->accidental_record_id;

        try {
            $data = (array)$accRecordObj;
            unset($data['accidental_record_id']);
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->where('accidental_record_id', $updateId)->update('tbl_accidental_record', $data);


            $res = ['success' => true, 'message' => 'Accidental Records updated Successfully', 'id' => $updateId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteAccidentalRecord()
    {
        $res = ['success' => false, 'message' => ''];
        $accRecordObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['accidental_record_id' => $accRecordObj->accidental_record_id, 'branch_id' => $this->brunch])->update('tbl_accidental_record');

            $res = ['success' => true, 'message' => 'Record deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }



    // start add Complain Record
    public function addComplainRecord($id = null)
    {
        $data['id'] = $id != '' ? $id : '';
        $data['title'] = "Add Complain Records";
        $data['content'] = $this->load->view('Administrator/vehicle/add_complain_records', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveComplainRecord()
    {
        $res = ['success' => false, 'message' => ''];

        $comRecordObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$comRecordObj;
            unset($data['complain_record_id ']);
            $data['date']    = date('Y-m-d');
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['status']   = 'a';
            $data['branch_id']   = $this->brunch;

            $this->db->insert('tbl_complain_record', $data);

            $res = ['success' => true, 'message' => 'Complain Record save successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getComplainRecord()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clause .= " and cr.date between '$data->dateFrom' and '$data->dateTo'";
        }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and cr.vehicle_id = '$data->vehicle_id'";
        }
        if (isset($data->driver) && $data->driver != '') {
            $clause .= " and e.Employee_SlNo = '$data->driver'";
        }
        if (isset($data->complain_record_id) && $data->complain_record_id != '') {
            $clause .= " and cr.complain_record_id = '$data->complain_record_id'";
        }

        $records = $this->db->query("SELECT cr.*,v.vehicle_id,v.vehicle_reg_no,e.Employee_SlNo,e.Employee_Name
            FROM tbl_complain_record cr
            left join tbl_vehicle v on v.vehicle_id = cr.vehicle_id
            left join tbl_employee e on v.driver = e.Employee_SlNo
            WHERE cr.status = 'a'
            and cr.branch_id = ?
            $clause
            order by complain_record_id desc", $this->brunch)->result();

        echo json_encode($records);
    }

    public function updateComplainRecord()
    {
        $res = ['success' => false, 'message' => ''];
        $comRecordObj = json_decode($this->input->raw_input_stream);
        $updateId = $comRecordObj->complain_record_id;

        try {
            $data = (array)$comRecordObj;
            unset($data['complain_record_id']);
            $data['UpdateBy']    = $this->session->userdata("FullName");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->where('complain_record_id', $updateId)->update('tbl_complain_record', $data);


            $res = ['success' => true, 'message' => 'Complain Records updated Successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteComplainRecord()
    {
        $res = ['success' => false, 'message' => ''];
        $RecordObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['complain_record_id' => $RecordObj->complain_record_id, 'branch_id' => $this->brunch])->update('tbl_complain_record');

            $res = ['success' => true, 'message' => 'Record deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }






    // start daily maintenance
    public function dailyMaintenance($id = null)
    {
        $data['title'] = "Add Daily Maintenance";
        $data['maintenance_id'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/add-daily-maintenance', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveMaintenance()
    {
        $res = ['success' => false, 'message' => ''];

        // $maintenanceObj = json_decode($this->input->raw_input_stream);
        $maintenanceObj = json_decode($this->input->post('data'));
        $cart = json_decode($this->input->post('cart'));
        $labour_cart = json_decode($this->input->post('labour_cart'));
        $parts_cart = json_decode($this->input->post('parts_cart'));

        try {
            $this->db->trans_begin();
            $data = (array)$maintenanceObj;
            unset($data['maintenance_id ']);
            $data['status']    = 'a';
            $data['AddBy']     = $this->session->userdata("userId");
            $data['AddTime']   = date('Y-m-d H:i:s');
            $data['branch_id'] = $this->brunch;

            $this->db->insert('tbl_maintenance', $data);
            $maintenanceId = $this->db->insert_id();

            foreach ($cart as $key => $value) {
                $details = (array)$value;
                unset($details['new_parts_name']);
                unset($details['old_parts_name']);
                $details['maintenance_id']   = $maintenanceId;
                $details['status']   = 'a';

                $this->db->insert('tbl_maintenance_details', $details);

                // stock update
                $this->db->query("UPDATE tbl_currentinventory 
                        set sales_quantity = sales_quantity + 1
                        where product_id = ?
                        and branch_id = ?
                        ", [$value->new_parts, $this->session->userdata('BRANCHid')]);

                $this->db->query("UPDATE tbl_currentinventory 
                set wastage_qty = wastage_qty + 1
                where product_id = ?
                and branch_id = ?
                ", [$value->new_parts, $this->session->userdata('BRANCHid')]);
            }

            foreach ($parts_cart as $key => $part) {
                $details = (array)$part;
                $details['maintenance_id']   = $maintenanceId;

                $this->db->insert('tbl_maintenance_sparparts_details', $details);
            }

            foreach ($labour_cart as $key => $labour) {
                $details = (array)$labour;
                $details['maintenance_id']   = $maintenanceId;

                $this->db->insert('tbl_maintenance_lcost_details', $details);
            }

            $updateImg = [];
            $updateImg['image1'] = '';
            $updateImg['image2'] = '';

            if (!empty($_FILES['image1'])) {

                $arr = explode('.', $_FILES['image1']['name']);
                $extension = end($arr);
                $image1name = $maintenanceId . '_1.' . $extension;
                move_uploaded_file($_FILES['image1']['tmp_name'], './uploads/maintanance_img/' . $image1name);

                $updateImg['image1'] = $image1name;
            }

            if (!empty($_FILES['image2'])) {

                $arr2 = explode('.', $_FILES['image2']['name']);
                $extension = end($arr2);
                $image2name = $maintenanceId . '_2.' . $extension;
                move_uploaded_file($_FILES['image2']['tmp_name'], './uploads/maintanance_img/' . $image2name);

                $updateImg['image2'] = $image2name;
            }

            $this->db->where('maintenance_id', $maintenanceId)->update('tbl_maintenance', $updateImg);

            $this->db->trans_commit();

            $res = ['success' => true, 'message' => 'Data save successfully', 'maintenance_id' => $maintenanceId];
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function maintenanceRecord()
    {
        $data['title'] = "Maintenance Record";
        $data['content'] = $this->load->view('Administrator/vehicle/maintenance-record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getAllMaintenance()
    {
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and m.date between '$data->dateFrom' and '$data->dateTo'";
        }

        if (isset($data->maintenance_id) && $data->maintenance_id != 0 && $data->maintenance_id != '') {

            $clauses .= " and maintenance_id = '$data->maintenance_id'";

            $maintenanceDetails = $this->db->query("SELECT md.*, p.Product_Name,p.Product_Code,pc.ProductCategory_Name,u.Unit_Name
                FROM tbl_maintenance_details md
                LEFT JOIN tbl_product p on p.Product_SlNo = md.new_parts
                join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
                join tbl_unit u on u.Unit_SlNo = p.Unit_ID
                WHERE md.maintenance_id = ?
            ", $data->maintenance_id)->result();

            $res['maintenanceDetails'] = $maintenanceDetails;

            $spareParts = $this->db->query("SELECT *
                FROM tbl_maintenance_sparparts_details
                WHERE maintenance_id = ?", $data->maintenance_id)->result();

            $res['spare_cart'] = $spareParts;

            $labourCost = $this->db->query("SELECT *
            FROM tbl_maintenance_lcost_details
            WHERE maintenance_id = ?", $data->maintenance_id)->result();

            $res['labour_cart'] = $labourCost;
        }
        $maintenance = $this->db->query("SELECT m.*, v.vehicle_reg_no, u.FullName
            FROM tbl_maintenance m
            LEFT join tbl_vehicle v on v.vehicle_id = m.vehicle_id
            left join tbl_user u on u.User_SlNo = m.AddBy
            WHERE m.status = 'a'
            and m.branch_id = '$branchId'
            $clauses
            order by m.maintenance_id desc
        ")->result();



        $res['maintenance'] = $maintenance;

        echo json_encode($res);
    }

    public function getMaintenanceReport()
    {
        $data = json_decode($this->input->raw_input_stream);
        $branchId = $this->session->userdata("BRANCHid");

        $clauses = "";
        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and m.date between '$data->dateFrom' and '$data->dateTo'";
        }

        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clauses .= " and v.vehicle_id = '$data->vehicle_id'";
        }

        if (isset($data->workshop_id) && $data->workshop_id != '') {
            $clauses .= " and w.workshop_id = '$data->workshop_id'";
        }
        // if (isset($data->customerId) && $data->customerId != '') {
        //     $clauses .= " and sm.SalseCustomer_IDNo = '$data->customerId'";
        // }

        // if (isset($data->employeeId) && $data->employeeId != '') {
        //     $clauses .= " and sm.employee_id = '$data->employeeId'";
        // }

        // if (isset($data->customerType) && $data->customerType != '') {
        //     $clauses .= " and c.Customer_Type = '$data->customerType'";
        // }

        // if (isset($data->vehicle_id) && $data->vehicle_id != 0 && $data->vehicle_id != '') {
        //     $clauses .= " and vehicle_id = '$data->vehicle_id'";
        //     $maintenanceDetails = $this->db->query("
        //         select 
        //             sd.*,
        //             p.Product_Code,
        //             p.Product_Name,
        //             pc.ProductCategory_Name,
        //             u.Unit_Name
        //         from tbl_saledetails sd
        //         join tbl_product p on p.Product_SlNo = sd.Product_IDNo
        //         join tbl_productcategory pc on pc.ProductCategory_SlNo = p.ProductCategory_ID
        //         join tbl_unit u on u.Unit_SlNo = p.Unit_ID
        //         where sd.SaleMaster_IDNo = ?
        //     ", $data->salesId)->result();

        //     $res['maintenanceDetails'] = $maintenanceDetails;
        // }
        $maintenance = $this->db->query("SELECT m.*, v.vehicle_reg_no, u.FullName, w.workshop_name
            FROM tbl_maintenance m
            LEFT join tbl_vehicle v on v.vehicle_id = m.vehicle_id
            LEFT join tbl_workshop w on w.workshop_id = m.workshop_name
            left join tbl_user u on u.User_SlNo = m.AddBy
            WHERE m.status = 'a'
            and m.branch_id = '$branchId'
            $clauses
            order by m.maintenance_id desc
        ")->result();

        foreach ($maintenance as $data) {
            $data->maintenanceDetails = $this->db->query("SELECT md.*, p.Product_Name,p.Product_Code
                FROM tbl_maintenance_details md
                LEFT JOIN tbl_product p on p.Product_SlNo = md.new_parts
                WHERE md.maintenance_id = ?
            ", $data->maintenance_id)->result();
        }

        // $res['maintenance'] = $maintenance;

        echo json_encode($maintenance);
    }

    // public function getComplainRecord()
    // {
    //     $records = $this->db->query("SELECT cr.*,v.vehicle_reg_no
    //         FROM tbl_complain_record cr
    //         left join tbl_vehicle v on v.vehicle_id = cr.vehicle_id
    //         WHERE cr.status = 'a'
    //         and cr.branch_id = ?
    //         order by complain_record_id desc", $this->brunch)->result();

    //     echo json_encode($records);
    // }

    public function updateMaintenance()
    {
        $res = ['success' => false, 'message' => ''];

        // $maintenanceObj = json_decode($this->input->raw_input_stream);

        $maintenanceObj = json_decode($this->input->post('data'));
        $cart = json_decode($this->input->post('cart'));
        $labour_cart = json_decode($this->input->post('labour_cart'));
        $parts_cart = json_decode($this->input->post('parts_cart'));

        $maintenanceId = $maintenanceObj->maintenance_id;

        try {
            $this->db->trans_begin();
            $data = (array)$maintenanceObj;
            unset($data['maintenance_id ']);
            $data['status']   = 'a';
            $data['AddBy']    = $this->session->userdata("userId");
            $data['AddTime']  = date('Y-m-d H:i:s');
            $data['branch_id']   = $this->brunch;

            $this->db->where('maintenance_id', $maintenanceId)->update('tbl_maintenance', $data);

            $oldDetails = $this->db->query("SELECT * from tbl_maintenance_details where maintenance_id = ?", $maintenanceId)->result();
            // remove details, inventory update
            foreach ($oldDetails as $key => $value) {
                $this->db->query("DELETE FROM tbl_maintenance_details WHERE maintenance_id = ?", $value->maintenance_id);

                // stock update
                $this->db->query("UPDATE tbl_currentinventory 
                set sales_quantity = sales_quantity - 1
                where product_id = ?
                and branch_id = ?
                ", [$value->new_parts, $this->session->userdata('BRANCHid')]);

                $this->db->query("UPDATE tbl_currentinventory 
                set wastage_qty = wastage_qty - 1
                where product_id = ?
                and branch_id = ?
                ", [$value->new_parts, $this->session->userdata('BRANCHid')]);
            }

            foreach ($cart as $key => $value) {
                $details = (array)$value;
                unset($details['new_parts_name']);
                unset($details['old_parts_name']);
                $details['maintenance_id']   = $maintenanceId;
                $details['status']   = 'a';

                $this->db->insert('tbl_maintenance_details', $details);

                // stock update
                $this->db->query("UPDATE tbl_currentinventory 
                        set sales_quantity = sales_quantity + 1
                        where product_id = ?
                        and branch_id = ?
                        ", [$value->new_parts, $this->session->userdata('BRANCHid')]);

                $this->db->query("UPDATE tbl_currentinventory 
                set wastage_qty = wastage_qty + 1
                where product_id = ?
                and branch_id = ?
                ", [$value->new_parts, $this->session->userdata('BRANCHid')]);
            }

            $this->db->query("DELETE FROM tbl_maintenance_sparparts_details WHERE maintenance_id = ?", $maintenanceId);
            $this->db->query("DELETE FROM tbl_maintenance_lcost_details WHERE maintenance_id = ?", $maintenanceId);


            foreach ($parts_cart as $key => $part) {
                $details = (array)$part;
                unset($details['spare_parts_id']);
                unset($details['maintenance_id']);
                $details['maintenance_id'] = $maintenanceId;

                $this->db->insert('tbl_maintenance_sparparts_details', $details);
            }

            foreach ($labour_cart as $key => $labour) {
                $details = (array)$labour;
                unset($details['labour_cost_id']);
                unset($details['maintenance_id']);
                $details['maintenance_id'] = $maintenanceId;

                $this->db->insert('tbl_maintenance_lcost_details', $details);
            }


            $updateImg = [];
            $updateImg['image1'] = $maintenanceObj->image1;
            $updateImg['image2'] = $maintenanceObj->image2;

            if (!empty($_FILES['image1'])) {

                $arr = explode('.', $_FILES['image1']['name']);
                $extension = end($arr);
                $image1name = $maintenanceId . '_1.' . $extension;
                move_uploaded_file($_FILES['image1']['tmp_name'], './uploads/maintanance_img/' . $image1name);

                $updateImg['image1'] = $image1name;
            }

            if (!empty($_FILES['image2'])) {

                $arr2 = explode('.', $_FILES['image2']['name']);
                $extension = end($arr2);
                $image2name = $maintenanceId . '_2.' . $extension;
                move_uploaded_file($_FILES['image2']['tmp_name'], './uploads/maintanance_img/' . $image2name);

                $updateImg['image2'] = $image2name;
            }

            $this->db->where('maintenance_id', $maintenanceId)->update('tbl_maintenance', $updateImg);


            $this->db->trans_commit();

            $res = ['success' => true, 'message' => 'Data save successfully', 'maintenance_id' => $maintenanceId];
        } catch (Exception $ex) {
            $this->db->rollback();
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function deleteMaintenance()
    {
        $res = ['success' => false, 'message' => ''];
        $RecordObj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['maintenance_id' => $RecordObj->maintenance_id, 'branch_id' => $this->brunch])->update('tbl_maintenance');

            $this->db->set(['status' => 'd'])->where('maintenance_id', $RecordObj->maintenance_id)->update('tbl_maintenance_details');

            $res = ['success' => true, 'message' => 'Record deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function maintenancePrint($id)
    {
        $data['title'] = "Daily Maintenance";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/maintenance-print', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    // start add Complain Record
    public function addJobCard($id = null)
    {
        $data['jobCardNo'] = '';
        if ($id == null) {
            $lastJobCardNo = $this->db->query("select job_card_no from tbl_job_card order by job_card_no desc limit 1")->row();
            if ($lastJobCardNo) {
                $newReqNo = substr($lastJobCardNo->job_card_no, -4) + 1;
                if (strlen($newReqNo) == 1) {
                    $data['jobCardNo'] = 'JOB000' . $newReqNo;
                } else if (strlen($newReqNo) == 2) {
                    $data['jobCardNo'] = 'JOB00' . $newReqNo;
                } else if (strlen($newReqNo) == 3) {
                    $data['jobCardNo'] = 'JOB0' . $newReqNo;
                } else {
                    $data['jobCardNo'] = 'JOB' . $newReqNo;
                }
            } else {
                $data['jobCardNo'] = 'JOB0001';
            }
        }

        $data['title'] = "Add Job Card";
        $data['jobCardId'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/add-job-card', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveJobCard()
    {
        $res = ['success' => false, 'message' => ''];

        $inputObj = json_decode($this->input->raw_input_stream);

        try {
            $data = (array)$inputObj;
            unset($data['job_card_id']);
            $data['job_status'] = 'Pending';
            $data['status']     = 'a';
            $data['AddBy']      = $this->session->userdata("userId");
            $data['AddTime']    = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->insert('tbl_job_card', $data);
            $jobInsertId = $this->db->insert_id();

            $res = ['success' => true, 'message' => 'Data save successfully', 'jobId' => $jobInsertId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function getJobCard()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clause = '';
        if (isset($data->job_card_id) && $data->job_card_id != '') {
            $clause .= " and jc.job_card_id = '$data->job_card_id'";
        }
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clause .= " and jc.vehicle_id = '$data->vehicle_id'";
        }
        if (isset($data->vehicleId) && $data->vehicleId != '') {
            $clause .= " and jc.vehicle_id = '$data->vehicleId' and jc.job_status = 'Pending'";
        }
        if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
            $clause .= " and jc.date between '$data->dateFrom' and '$data->dateTo'";
        }

        $records = $this->db->query("SELECT jc.*,v.vehicle_reg_no,v.model_no,v.tyre_size,v.manufacture_year
            FROM tbl_job_card jc
            left join tbl_vehicle v on v.vehicle_id = jc.vehicle_id
            WHERE jc.status = 'a'
            and jc.branch_id = ?
            $clause
            order by job_card_id desc", $this->brunch)->result();

        echo json_encode($records);
    }

    public function updateJobCard()
    {
        $res = ['success' => false, 'message' => ''];
        $inputObj = json_decode($this->input->raw_input_stream);
        $updateId = $inputObj->job_card_id;

        try {
            $data = (array)$inputObj;
            unset($data['job_card_id']);
            $data['updateBy']    = $this->session->userdata("userId");
            $data['updatetime']  = date('Y-m-d H:i:s');
            $data['branch_id']  = $this->brunch;

            $this->db->where('job_card_id', $updateId)->update('tbl_job_card', $data);


            $res = ['success' => true, 'message' => 'Data updated Successfully', 'jobId' => $updateId];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
            // $res = ['success' => false, 'message' => 'Something going wrong! please try later'];
        }

        echo json_encode($res);
    }

    public function deleteJobCard()
    {
        $res = ['success' => false, 'message' => ''];
        $Obj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['job_card_id' => $Obj->job_card_id, 'branch_id' => $this->brunch])->update('tbl_job_card');

            $res = ['success' => true, 'message' => 'Record deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function completeJobStatus()
    {
        $res = ['success' => false, 'message' => ''];
        $Obj = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['job_status' => 'Complete'])->where(['job_card_id' => $Obj->jobCardId, 'branch_id' => $this->brunch])->update('tbl_job_card');

            $res = ['success' => true, 'message' => 'Job Status Update successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }

    public function jobCardRecord()
    {
        $data['title'] = "Job Card Record";
        $data['content'] = $this->load->view('Administrator/vehicle/job-card-record', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function jobCardPrint($id)
    {
        $data['title'] = "Job Card";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/job-card-print', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function accidentalPrint($id)
    {
        $data['title'] = "Accidental Report";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/accidental_print', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function evaluationPrint($id)
    {
        $data['title'] = "Supplier Evaluation Record";
        $data['id'] = $id;
        $data['content'] = $this->load->view('Administrator/vehicle/evaluation_print', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }












    //wastage restore
    public function wastageRestore()
    {
        $data['title'] = "Wastage Restore";
        $data['content'] = $this->load->view('Administrator/vehicle/wastage-restore', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    // washing / schedule 
    public function washingSchedule()
    {
        $data['title'] = "Washing Schedule Record";
        $data['content'] = $this->load->view('Administrator/vehicle/washing-schedule', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getWashServiceSchedule()
    {
        $res = ['success' => false, 'message' => ''];
        $obj = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($obj->searchFor) && $obj->searchFor == 'washing') {
            $clause .= " and vs.wash_date like '$obj->date%' ";
        }
        if (isset($obj->searchFor) && $obj->searchFor == 'service') {
            $clause .= " and vs.service_date like '$obj->date%' ";
        }

        $result = $this->db->query("SELECT vs.*, v.vehicle_reg_no, v.driver_name
        FROM tbl_vehicle_service vs
        left JOIN tbl_vehicle v on v.vehicle_id = vs.vehicle_id
        WHERE vs.status = 'a'
        and vs.branch_id = ?
        $clause
        ", $this->brunch)->result();

        echo json_encode($result);
    }



    // start Workshop part
    public function addWorkshop()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Add Workshop";
        $data['content'] = $this->load->view('Administrator/setup/add-workshop', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function saveWorkshop()
    {
        $res = ['success' => false, 'message' => ''];
        $inputObJ = json_decode($this->input->raw_input_stream);
        $workshopId = $inputObJ->workshop_id;

        if ($workshopId) {
            $exist_result = $this->db->query("SELECT * FROM tbl_workshop WHERE workshop_name = ? and workshop_id != ? and status = 'a'", [$inputObJ->workshop_name, $workshopId])->row();
        } else {
            $exist_result = $this->db->query("SELECT * FROM tbl_workshop WHERE workshop_name = ? and status = 'a'", $inputObJ->workshop_name)->row();
        }

        if ($exist_result) {
            $res = ['success' => false, 'message' => 'Workshop name already exist'];
        } else {
            try {
                $data = (array)$inputObJ;

                if ($workshopId == '') {
                    unset($data['workshop_id']);
                    $data['status']    = 'a';
                    $data['AddBy']     = $this->session->userdata("userId");
                    $data['AddTime']   = date('Y-m-d H:i:s');
                    $data['branch_id'] = $this->brunch;

                    $this->db->insert('tbl_workshop', $data);
                } else {
                    unset($data['workshop_id']);
                    $data['UpdateBy']    = $this->session->userdata("userId");
                    $data['updatetime']  = date('Y-m-d H:i:s');
                    $data['branch_id'] = $this->brunch;

                    $this->db->where('workshop_id', $workshopId)->update('tbl_workshop', $data);
                }

                $res = ['success' => true, 'message' => 'Data Save successfully'];
            } catch (Exception $ex) {
                $res = ['success' => false, 'message' => $ex->getMessage()];
            }
        }
        echo json_encode($res);
    }

    public function getWorkshop()
    {
        $result = $this->db->query("SELECT * FROM tbl_workshop WHERE status = 'a' and branch_id = ? order by workshop_id desc", $this->brunch)->result();
        echo json_encode($result);
    }

    public function deleteWorkshop()
    {
        $res = ['success' => false, 'message' => ''];
        $inputObJ = json_decode($this->input->raw_input_stream);

        try {
            $this->db->set(['status' => 'd'])->where(['workshop_id' => $inputObJ->workshop_id, 'branch_id' => $this->brunch])->update('tbl_workshop');

            $res = ['success' => true, 'message' => 'Workshop deleted successfully'];
        } catch (Exception $ex) {
            $res = ['success' => false, 'message' => $ex->getMessage()];
        }

        echo json_encode($res);
    }
    // end Workshop part


    public function accidentalReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Accidental Report";
        $data['content'] = $this->load->view('Administrator/vehicle/accidental-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function complainReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Complain Report";
        $data['content'] = $this->load->view('Administrator/vehicle/complain-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function supEvaluation()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Supplier Evaluation Report";
        $data['content'] = $this->load->view('Administrator/vehicle/supplier-evaluation-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function licenseReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "License Report";
        $data['content'] = $this->load->view('Administrator/vehicle/license-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function generalServiceReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "General Service Report";
        $data['content'] = $this->load->view('Administrator/vehicle/general-service-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function tyreEntryReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Tyre Entry Report";
        $data['content'] = $this->load->view('Administrator/vehicle/tyre-entry-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function generalServiceReminder()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "General Service Reminder";
        $data['content'] = $this->load->view('Administrator/vehicle/general-service-reminder', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function drivingHistory()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Driver Driving History";
        $data['content'] = $this->load->view('Administrator/vehicle/driving-history', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getDrivingHistory()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clause = '';
        if (isset($data->Employee_SlNo) && $data->Employee_SlNo != '') {
            $clause .= " eh.driver_id = '$data->Employee_SlNo'";
        }
        if ((isset($data->dateFrom) && $data->dateFrom != '') && isset($data->Employee_SlNo) && $data->Employee_SlNo != '') {
            $clause .= " and ";
        }
        if ((isset($data->dateFrom) && $data->dateFrom != '') && (isset($data->dateTo) && $data->dateTo != '')) {
            $clause .= " eh.date between '$data->dateFrom' and '$data->dateTo'";
        }

        $result = $this->db->query("SELECT eh.*,des.Designation_Name,dep.Department_Name,v.vehicle_reg_no
        FROM tbl_employee_history eh
        LEFT JOIN tbl_designation des on des.Designation_SlNo = eh.emp_designation
        LEFT JOIN tbl_department dep on dep.Department_SlNo = eh.emp_department
        LEFT JOIN tbl_vehicle v on v.vehicle_id = eh.vehicle_id
        WHERE des.Designation_Name = 'Driver' and $clause")->result();

        echo json_encode($result);
    }

    public function vehicleList()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Vehicle List Report";
        $data['content'] = $this->load->view('Administrator/vehicle/vehicle-list-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function tyreReport()
    {
        $access = $this->mt->userAccess();
        if (!$access) {
            redirect(base_url());
        }

        $data['title'] = "Tyre Report";
        $data['content'] = $this->load->view('Administrator/vehicle/tyre-report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getTyreReport()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = '';
        if (isset($data->vehicle_id) && $data->vehicle_id != '') {
            $clauses .= " and te.vehicle_id = '$data->vehicle_id'";
        }

        if (isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != '') {
            $clauses .= " and te.date between '$data->dateFrom' and '$data->dateTo'";
        }

        $tyre_details = $this->db->query("SELECT
            ted.*,
            te.vehicle_id,
            te.installation_date,
            te.expaire_date,
            te.date,
            v.vehicle_reg_no,
            te.comments
            FROM tbl_tyre_entry_details ted
            LEFT JOIN tbl_tyre_entry te on te.tyre_id = ted.tyreEntryId
            LEFT JOIN tbl_vehicle v on v.vehicle_id = te.vehicle_id
            WHERE te.status = 'a'
            and te.branch_id = ?
            $clauses
            order by te.tyre_id desc
        ", $this->brunch)->result();

        // $tyre = $this->db->query("SELECT 
        //     ted.*,
        //     ted.tyre_name,
        //     ted.new_serial, 
        //     ted.old_serial
        //     FROM tbl_tyre_entry_details ted
        // ")->result();

        $res['tyre_details'] = $tyre_details;
        // $res['tyre'] = $tyre;
        echo json_encode($res);
    }
}
