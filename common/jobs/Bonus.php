<?php
namespace common\jobs;

use shakura\yii2\gearman\JobBase;
use common\models\activity\LotteryWinner;
use common\models\activity\LotteryBonusLog;
use common\models\redis\LotteryList;

class Bonus extends JobBase
{
    private $_mch_id = 10035717;
    private $_wxappid = 'wx2c4643a8a115af7f';

    public function execute(\GearmanJob $job = null)
    {
        $params = unserialize($job->workload())->params;
        $winner = LotteryWinner::find()->where(['id' => $params['data'], 'modify_time' => 0])->asArray()->one();
        if (!$winner) return;
        $lottery = LotteryList::find()->where(['id' => $winner['act_id']])->asArray()->one();
        if (!$lottery) return;
        $winner['bonus_send_name'] = $lottery['bonus_send_name'];
        $winner['bonus_wishing'] = $lottery['bonus_wishing'];
        $winner['bonus_remark'] = $lottery['bonus_remark'];
        $winner['act_name'] = $lottery['act_name'];
        $this->sendBonus($winner);
    }

    /**
     * 发送红包
     */
    function sendBonus($params)
    {
        //重试一次
        $index = 1;
        while ($index < 3)
        {
            $return = $this->sendRedPack($params);
            $index++;
            //记录日志
            $log_mod = new LotteryBonusLog();
            $log_mod->return_code = $return['return_code'];
            if($return['return_msg'])
                $log_mod->return_msg = $return['return_msg'];
            if($return['result_code'])
                $log_mod->result_code = $return['result_code'];
            if($return['err_code'])
                $log_mod->err_code = $return['err_code'];
            if($return['err_code_des'])
                $log_mod->err_code_des = $return['err_code_des'];
            $log_mod->mch_billno = $params['billno'];
            $log_mod->mch_id = $this->_mch_id;
            $log_mod->wxappid = $this->_wxappid;
            $log_mod->re_openid = $params['open_id'];
            $log_mod->total_amount = $params['bonus_amount'];
            $log_mod->insert_time = time();
            $log_mod->save();
            if($return['result_code'] == 'SUCCESS')
            {
                //更新记录
                LotteryWinner::updateAll(['modify_time' => time()], ['id' => $params['id']]);
                break;
            }
            sleep(5);
        }
    }

    /**
     * 给用户发红包
     * @param $req
     */
    function sendRedPack($req)
    {

        return ['result_code' => 'SUCCESS', 'return_code' => 'SUCCESS'];   //正式使用时请注释该行

        //微信红包接口
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
        //微信红包接口KEY
        $key = '56eedbbcd9b86b315c2eee26bb1ae6ce';
        $array = array(
                'nonce_str' => md5(json_encode($req)),
                'mch_billno' => $req['billno'],
                'mch_id' => $this->_mch_id,
                'wxappid' => $this->_wxappid,
                'nick_name' => $req['bonus_send_name']?:'潇湘晨报',
                'send_name' => $req['bonus_send_name']?:'潇湘晨报',
                're_openid' => $req['open_id'],
                'total_amount' => $req['bonus_amount'],
                'total_num' => 1,
                'wishing' => $req['bonus_wishing'],
                'act_name' => $req['act_name'],
                'client_ip' => '113.240.254.2',
                'remark' => $req['bonus_remark'],
        );

        ksort($array);
        $string = '';
        foreach ($array as $k => $r)
        {
            $string .= '&' . $k . '=' . $r;
        }
        $string = ltrim($string, '&') . '&key=' . $key;
        $sign = strtoupper(md5($string));
        $array['sign'] = $sign;

        $xml = $this->array2xml($array);

        $return = $this->curl_post_ssl($url, $xml);

        //将XML转换为数组
        $res = @simplexml_load_string($return, NULL, LIBXML_NOCDATA);
        return json_decode(json_encode($res), true);
    }

    /**
     * CURL请求微信红包
     * @param $url
     * @param $vars
     * @param int $second
     * @param array $aHeader
     * @return bool|mixed
     */
    function curl_post_ssl($url, $vars, $second = 30, $aHeader = array())
    {
        $aHeader[] = "Content-type: text/xml";
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //以下两种方式需选择一种
        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, '/Data/website/data/wx_pay_certificate/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, '/Data/website/data/wx_pay_certificate/apiclient_key.pem');

        //第二种方式，两个文件合成一个.pem文件
        //curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        if(count($aHeader) >= 1)
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $data = curl_exec($ch);
        if($data)
        {
            curl_close($ch);
            return $data;
        }
        else
        {
            $error = curl_error($ch);
            curl_close($ch);
            return false;
        }
    }

    /**
     * 将数组转化为XML
     * @param $arr
     * @return string
     */
    function array2xml($arr)
    {
        $doc = '';
        $doc .= '<xml>';
        foreach ($arr as $tag => $value)
        {
            $doc .= "\r\n<$tag><![CDATA[$value]]></$tag>";
        }
        $doc .= "\r\n</xml>";
        return $doc;
    }
}