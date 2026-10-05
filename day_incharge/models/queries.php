<?php
$db = new grid($con);
class grid{
    public function __construct($con){
        $this->con = $con;
        if($this->con->connect_error){
            die($this->con->connect_error);
        }
    }
    private $table;
    public $result;
    private $sql;
    public function Select(...$data){
        $this->sql = "SELECT ";
        for($i = 0; $i < count($data); ++$i){
            $this->sql .= $data[$i] . ",";
        }
        $this->sql = rtrim($this->sql, ",");
        $this->sql .= " FROM ";
    }
    public function From($tablename){
        $this->sql .= $tablename;
    }
    public function Join($join){
        $this->sql .= " JOIN ";
        $this->sql .= $join; 
    }
    public function ON(...$onwhere){
        $this->sql .= " ON ";
        for($i = 0; $i < count($onwhere); ++$i){
            $this->sql .= $onwhere[$i] . "=";
        }
        $this->sql = rtrim($this->sql, "=");  
    }
    public function Where($where){
        $this->sql .= " Where ";
        $this->sql .= $where;  
    }
    public function Orderby($orderby){
        $this->sql .= " ORDER BY ";
        $this->sql .= $orderby;  
    }
    public function result(){
        return $this->con->query($this->sql);
    }

}






// ////////////////////////Method////////////////////////

// $db->Select("*");
// $db->From("customer");
// $db->Where("close = '1' AND status = '1' AND MONTH(crt_date) = MONTH(CURRENT_DATE())");
// $cus_result_ex = $db->result();


// $db->Select("*","SUM(total_payment)","SUM(received),SUM(order_type)");
// $db->From("lab_order".$_SESSION['sr_no']."");
// $db->Where("close = '1' AND status = '1'  GROUP BY order_date");
// $db->Orderby("order_date DESC");
// $res_data_ex_new = $db->result();

// $db->Select('*','SUM(lab_order'.$_SESSION['sr_no'].'.total_payment)','SUM(lab_order'.$_SESSION['sr_no'].'.received)');
// $db->From("lab_order".$_SESSION['sr_no']."");
// $db->Join("customer");
// $db->ON("lab_order".$_SESSION['sr_no'].".cus_id","customer.cus_id");
// $db->Where("lab_order".$_SESSION['sr_no'].".close = '1' AND lab_order".$_SESSION['sr_no'].".status = '1' GROUP BY lab_order".$_SESSION['sr_no'].".cus_id");
// $today_rent = $db->result();





?>