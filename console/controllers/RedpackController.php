<?php
/**
 * @File: RedpackController.php
 * @User: zhujw <zhjw@xxcb.cn>
 * @Date: 2016/11/28 14:55
 * @Desc: 红包发放的计划任务
 */
namespace console\controllers;

use EasyWeChat\Foundation\Application;
use yii\console\Controller;
use yii;

class RedpackController extends Controller
{
    //红包发送人
    private $bonus_send_name = '潇湘房地产风云榜';

    //红包祝福语
    private $bonus_wishing = '谢谢你的好眼光，祝您万事顺安';

    //红包备注
    private $bonus_remark = '“潇湘房地产风云榜”是由湖南省房地产业协会携手潇湘晨报社联合举办，邀请全省消费者共同甄别品牌房企，遴选品质楼盘。';

    //商户号
    private $mch_id = '1243685502';

    //微信红包接口
    private $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

    //当前使用的用于发送红包的公众号
    private $mp_type = '';

    //当前的活动ID，用于表示红包发送语言是否相同
    private $lottery_id = 0;

    //红包索引
    private $inx = 0;

    //公众号配置文件
    private $config = [];

    //实例
    private $app;

    //红包发送操作
    public function actionIndex()
    {
        $redis = Yii::$app->redis;
        $winnerModel = new \common\models\wxservice\LotteryWinner();
        while(true)
        {
            if ($winner = $redis->lpop('lottery_bonus_winner_list'))
            {
                $data = \GuzzleHttp\json_decode($winner, true);

                //发送红包操作
                $data = $this->_sendRedpack($data);

                $winnerModel->isNewRecord = true;
                $winnerModel->load($data, '');
                $winnerModel->id = 0;
                $winnerModel->save();
                unset($data);
            }
            else
            {
                sleep(60);
            }
        }
    }

    private function _sendRedpack($data)
    {
        //获取发送红包的微信公众号配置信息
        if ($data['mp_type'] != $this->mp_type)
        {
            $this->config = Yii::$app->redis->get('wx_apps:' . $data['mp_type']);
            $this->mch_id = $this->config['mch_id'];
            $this->mp_type = $data['mp_type'];
            $this->app = new Application($this->config);
        }

        //红包祝福语
        if ($data['act_id'] != $this->lottery_id)
        {
            $lottery = Yii::$app->redis->hget('lottery_group:' . $data['group_id'], 'lottery_list:' . $data['act_id']);
            $lottery = \GuzzleHttp\json_decode($lottery, true);
            $this->bonus_send_name = $lottery['bonus_send_name'];
            $this->bonus_wishing = $lottery['bonus_wishing'];
            $this->bonus_remark = $lottery['bonus_remark'];
            $this->lottery_id = $data['act_id'];
            unset($lottery);
        }

        $data['billno'] = $this->_getBillNo();
        $luckyMoneyData = [
            'mch_billno'       => $data['billno'],
            'send_name'        => $this->bonus_send_name,
            're_openid'        => $data['open_id'],
            'total_amount'     => $data['bonus_amount'],
            'wishing'          => $this->bonus_wishing,
            'act_name'         => $this->bonus_send_name,
            'remark'           => $this->bonus_remark
        ];

        //发送红包
        $rt = $this->app->lucky_money->sendNormal($luckyMoneyData);
        $data['return_log'] = \GuzzleHttp\json_encode($rt);

        //成功
        if($rt->return_code == 'SUCCESS' && $rt->result_code == 'SUCCESS')
        {
            //
        }
        else
        {
            // 用户账号异常，被拦截，加入黑名单，下次请求直接返回未中奖
            if($rt->err_code == 'NO_AUTH')
            {
                Yii::$app->redis->sadd('lottery_redpack_black', $data['open_id']);
            }
            $data['fail'] = 1;
            $data['reason'] = $rt->err_code_des;
        }
        return $data;
    }

    /**
     * @Desc: 商户红包订单号
     * @User: zhujw <zhjw@xxcb.cn>
     * @return string
     */
    private function _getBillNo()
    {
        if ($this->inx >= 888888) $this->inx = 0;   //如果超出6位则重置红包索引
        $bill_no = $this->mch_id;
        $bill_no .= date('YmdHis');
        $bill_no .= str_pad(++$this->inx, 6, '0', STR_PAD_LEFT);
        return $bill_no;
    }
}