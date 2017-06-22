<?php

class FlushRecordModel
{
    private $_server = null;
    private $_port = null;
    private $_user = null;
    private $_pwd = null;

    public function __construct($config)
    {
        $this->_server = $config['server'];
        $this->_port = $config['port'];
        $this->_user = $config['user'];
        $this->_pwd = $config['pwd'];
    }

    public function schedule()
    {
        $db = new mysqli($this->_server, $this->_user, $this->_pwd, "xydb", $this->_port);
        $sql = "SELECT * FROM apply_schedule WHERE type=2";
        $result = $db->query($sql);
        /* 循环获得结果集 */
        if(is_object($result))
        {
            while ($row = $result->fetch_assoc())
            {
                $list[] = $row;
            }
        }
        elseif(is_bool($result))
        {
            return $result;
        }
        $db->close();
        return $list;
    }
    
    public function flushRecord($schedules)
    {
        $records = array();
        foreach ($schedules as $schedule)
        {
            $records[$schedule['apply_id']] = intval($records[$schedule['apply_id']]) + intval($schedule["c_date"]) + intval($schedule["v_date"]) + intval($schedule["f_date"]) + intval($schedule["b_date"]) + intval($schedule["t_date"]) + intval($schedule["on_date"]);
        }
        if(empty($records))
        {
            echo "\n没有需要更新数据\n";
            exit();
        }
        
        //更新数据
        echo "\n--------------------------开始更新--------------------------\n";
        $db = new mysqli($this->_server, $this->_user, $this->_pwd, "xydb", $this->_port);
        $error_no = array();
        foreach ($records as $apply_id => $value)
        {
            echo " apply_id={$apply_id}     apply_total_time={$value} \n";
            $sql = "UPDATE `apply_record` SET `apply_total_time`={$value} WHERE `apply_id`={$apply_id}";
            $result = $db->query($sql);
            if(!$result)
                $error_no[] = $apply_id;
        }
        $db->close();
        
        if(!empty($error_no))
        {
            echo "\n ----------------以下需求编号更新失败---------------- \n";
            print_r($error_no);
            exit;
        }
        echo "\n--------------------------更新完毕--------------------------\n";
    }

}


$config = require_once '../../common/config/main-local.php';
$dsn = $config['components']['db']['dsn'];
$length = stripos($dsn, ";") - stripos($dsn, '=') - 1;
$str = substr($dsn, stripos($dsn, '=') + 1, $length);
list($server, $port) = explode(":", $str);

$params = array(
    'user' => $config['components']['db']['username'],
    'pwd' => $config['components']['db']['password'],
    'server' => $server,
    'port' => $port,
);

$fr = new FlushRecordModel($params);
$schedules = $fr->schedule();
$ret = $fr->flushRecord($schedules);

?>