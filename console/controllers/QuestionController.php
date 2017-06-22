<?php
/**
 * QuestionController
 * 作者: limj
 * 版本: 17-2-23
 */

namespace console\controllers;
use yii;
use yii\console\Controller;

class QuestionController extends Controller
{
    public $preKey = 'QWERTSF';
    public $question = array(
        array('answer'=>'发下一笔奖金，你会如何犒劳自己？',
            'option'=>array(
                '请自己大吃一顿',
                '买前段时间想买贵重物品',
                '还是存着，看看投资一些股票或理财产品',
                '除了犒劳自己，也给父母或是伴侣买些东西'
            ),
            'right'=>array(
                array('请自己大吃一顿', 2),
                array('买前段时间想买贵重物品', 5),
                array('还是存着，看看投资一些股票或理财产品', 10),
                array('除了犒劳自己，也给父母或是伴侣买些东西', 5),
            )),
        array('answer'=>'你会经常借钱给别人吗？',
            'option'=>array(
                '看要是借给什么人，做什么用，才考虑要不要借',
                '只要自己有钱，这方面还是很大方的',
                '除非是拒绝不了，不然会很少借',
                '不好意思拒绝，所以别人问，基本都会借'),
            'right'=> array(
                array('看要是借给什么人，做什么用，才考虑要不要借', 10),
                array('只要自己有钱，这方面还是很大方的', 8),
                array('除非是拒绝不了，不然会很少借', 5),
                array('不好意思拒绝，所以别人问，基本都会借', 0),
            )),
        array('answer'=>'你赞成分期付款的方式买车吗？',
            'option'=>array(
                '先考虑自己承担的力度，再决定买怎样的车，分多少期',
                '赞成，只要是自己喜欢的，就会这么做',
                '压力太大了，比较起来我还是愿意先存钱后买车',
                '尽量先找父母赞助，剩余的再考虑分期的问题'),
            'right'=> array(
                array('先考虑自己承担的力度，再决定买怎样的车，分多少期', 10),
                array('赞成，只要是自己喜欢的，就会这么做', 0),
                array('压力太大了，比较起来我还是愿意先存钱后买车', 8),
                array('尽量先找父母赞助，剩余的再考虑分期的问题', 5),
            )),
        array('answer'=>'你常去商店买换季打折的物品吗？',
            'option'=>array(
                '若日常用品就会，有潮流趋势的衣物等就不会',
                '不常去。我都是想买什么就买什么，不会考虑那么多',
                '我很喜欢买打折的物品，但会根据自己的经济实力来',
                '是的，我常常会买很多换季打折的物品，省钱'),
            'right'=> array(
                array('若日常用品就会，有潮流趋势的衣物等就不会', 5),
                array('不常去。我都是想买什么就买什么，不会考虑那么多', 0),
                array('我很喜欢买打折的物品，但会根据自己的经济实力来', 10),
                array('是的，我常常会买很多换季打折的物品，省钱', 8),
            )),
        array('answer'=>'你看到想要的东西一定要得到吗？',
            'option'=>array(
                '肯定会去努力，实在得不到，再用其他东西代替',
                '是的，想尽办法都要得到',
                '心里肯定迫切想要得到，会去试试，实在要不到就算了',
                '得之我幸，不得我命，不太强求'),
            'right'=> array(
                array('肯定会去努力，实在得不到，再用其他东西代替', 8),
                array('是的，想尽办法都要得到', 0),
                array('心里肯定迫切想要得到，会去试试，实在要不到就算了', 10),
                array('得之我幸，不得我命，不太强求', 5),
            )),
        array('answer'=>'你会在公共场合捡起五块钱吗？',
            'option'=>array(
                '是自己掉的就捡，别人掉的懒得捡',
                '五块钱有什么好捡的',
                '若无人望向这边就捡',
                '捡起来，然后问周围的人是谁掉的'),
            'right'=> array(
                array('是自己掉的就捡，别人掉的懒得捡', 5),
                array('五块钱有什么好捡的', 0),
                array('若无人望向这边就捡', 10),
                array('捡起来，然后问周围的人是谁掉的', 0),
            )),
        array('answer'=>'你经常会买福利彩票或体育彩票吗？',
            'option'=>array(
                '宁愿买刮刮乐，投注彩票不靠谱，基本不回去买',
                '要么不买，一买就会买得比较多',
                '偶尔买来玩玩，中大奖还是不会去奢望',
                '常常去买，每次买几块钱，当给自己一个发财的希望'),
            'right'=> array(
                array('宁愿买刮刮乐，投注彩票不靠谱，基本不回去买', 5),
                array('要么不买，一买就会买得比较多', 0),
                array('偶尔买来玩玩，中大奖还是不会去奢望', 10),
                array('常常去买，每次买几块钱，当给自己一个发财的希望', 5),
            )),
        array('answer'=>'到退休年龄时，你还会不会想继续工作或赚钱？',
            'option'=>array(
                '应该会，毕竟得到的位置不易，退休了什么都不是了',
                '当然会想赚钱，但赚钱的方式不一定要是继续上班',
                '如果到退休年龄时，家庭状况还不错，就退休',
                '当然会想彻底退休，享受清闲的老年生活'),
            'right'=> array(
                array('应该会，毕竟得到的位置不易，退休了什么都不是了', 10),
                array('当然会想赚钱，但赚钱的方式不一定要是继续上班', 8),
                array('如果到退休年龄时，家庭状况还不错，就退休', 5),
                array('当然会想彻底退休，享受清闲的老年生活', 2),
            )),
        array('answer'=>'如果可以得到一笔一千万元的巨款，你会如何领取？',
            'option'=>array(
                '根据实际需要先领一半，剩余再做考虑',
                '一次性领玩一千万元',
                '按每年领，并设定多少年领完',
                '按每个月领，并设定多少年领完'),
            'right'=> array(
                array('根据实际需要先领一半，剩余再做考虑', 10),
                array('一次性领玩一千万元', 8),
                array('按每年领，并设定多少年领完', 6),
                array('按每个月领，并设定多少年领完', 2),
            )),
        array('answer'=>'你想要住的地方是？',
            'option'=>array(
                '郊外的别墅',
                '市中心的商住楼',
                '设施、配置齐全，交通也比较便利的高档小区',
                '园林田园式的住宅'),
            'right'=> array(
                array('郊外的别墅', 6),
                array('市中心的商住楼', 10),
                array('设施、配置齐全，交通也比较便利的高档小区', 8),
                array('园林田园式的住宅', 5),
            )),
        array('answer'=>'下列那件事会让你最开心:',
            'option'=>array(
                '你在报纸竞赛中赢了10万元',
                '你从一个富有的亲戚那里继承了10万元',
                '你冒着高风险，投资了2000元带来了10万元的收益',
                '你很高兴10万元的收益，无论是通过什么渠道'),
            'right'=> array(
                array('你在报纸竞赛中赢了10万元', 5),
                array('你从一个富有的亲戚那里继承了10万元', 5),
                array('你冒着高风险，投资了2000元带来了10万元的收益', 5),
                array('你很高兴10万元的收益，无论是通过什么渠道', 10),
            )),
        array('answer'=>'你继承了价值100万的房子。每月有2000元的租金收入。装修后，租金可以有4500元。你会:',
            'option'=>array(
                '卖掉房子',
                '保持现有租约',
                '装修它，再出租'),
            'right'=> array(
                array('卖掉房子', 2),
                array('保持现有租约', 5),
                array('装修它，再出租', 10),
            )),
        array('answer'=>'你购买一只股票，一个月后跌了15%的总价值。该股票基本面要素没有改变，你会：',
            'option'=>array(
                '坐等投资回到原有价值',
                '卖掉它，以免日后如果它不断跌价',
                '买入更多'),
            'right'=> array(
                array('坐等投资回到原有价值', 5),
                array('卖掉它，以免日后如果它不断跌价', 0),
                array('买入更多', 10),
            )),
        array('answer'=>'你在某个电视竞赛中有下列选择。你会选:',
            'option'=>array(
                '1000元现钞',
                '50%的机会获得4000元',
                '20%的机会获得10,000元',
                '5%的机会获得100,000元'),
            'right'=> array(
                array('1000元现钞', 0),
                array('50%的机会获得4000元', 2),
                array('20%的机会获得10,000元', 5),
                array('5%的机会获得100,000元', 10),
            )),
        array('answer'=>'专家估计黄金、房屋等价格会上升，债券的价格会下跌。如你现时持有大量政府债券，你会:',
            'option'=>array(
                '继续持有',
                '把债券卖掉，资金一半投资货币市场，一半投资实物资产',
                '把债券卖掉，然后把所有得来的资金投资到实质资产',
                '把债券卖掉，资金投资到实质资产，借钱来投资实质资产'),
            'right'=> array(
                array('继续持有', 8),
                array('把债券卖掉，资金一半投资货币市场，一半投资实物资产', 10),
                array('把债券卖掉，然后把所有得来的资金投资到实质资产', 5),
                array('把债券卖掉，资金投资到实质资产，借钱来投资实质资产', 0),
            )),
        array('answer'=>'你购买一只股票，一个月后暴涨了40%。基本面和市场环境没变化，你会:',
            'option'=>array(
                '卖掉它',
                '继续持有它，期待未来可能更多的收益',
                '买入更多-也许它还会涨得更高'),
            'right'=> array(
                array('卖掉它', 5),
                array('继续持有它，期待未来可能更多的收益', 10),
                array('买入更多-也许它还会涨得更高', 2),
            )),
        array('answer'=>'你承继了100万元遗产，你必须把所有遗产投资以下其中一项，你会选择:',
            'option'=>array(
                '一个储蓄户口或货币市场基金',
                '一个拥有股票和债券的基金',
                '一个拥有十五只蓝筹股票的投资组合',
                '一些保值的投资产品，如金、银或石油'),
            'right'=> array(
                array('一个储蓄户口或货币市场基金', 2),
                array('一个拥有股票和债券的基金', 10),
                array('一个拥有十五只蓝筹股票的投资组合', 8),
                array('一些保值的投资产品，如金、银或石油', 5),
            )),
        array('answer'=>'如果你今年五十岁拥有20万元并可投资，你会选择下列那一个组合?',
            'option'=>array(
                '低风险占60%，中风险占30%，高风险占10%',
                '低风险占30%，中风险占40%，高风险占30%',
                '低风险占10%，中风险占40%，高风险占50%'),
            'right'=> array(
                array('低风险占60%，中风险占30%，高风险占10%', 10),
                array('低风险占30%，中风险占40%，高风险占30%', 5),
                array('低风险占10%，中风险占40%，高风险占50%', 2),
            )),
        array('answer'=>'您平时怎么样辨别投资理财产品的风险？',
            'option'=>array(
                '看理财产品说明投资范围和风险等级越高，风险越大',
                '看理财产品说明投资范围和风险等级等级越高，风险越小',
                '听银行工作人员口头介绍'),
            'right'=> array(
                array('看理财产品说明投资范围和风险等级越高，风险越大', 10),
                array('看理财产品说明投资范围和风险等级等级越高，风险越小', 0),
                array('听银行工作人员口头介绍', 2),
            )),
        array('answer'=>'下列哪种产品不属于银行代销产品？',
            'option'=>array(
                '基金',
                '保险',
                '国债',
                '银行理财产品'),
            'right'=> array(
                array('基金', 0),
                array('保险', 0),
                array('国债', 0),
                array('银行理财产品', 10),
            )),
        array('answer'=>'您投资10万元某理财产品，年化收益率5.5%，期限90天。到期后您能收回多少钱？',
            'option'=>array(
                '10万元*5.5%=5500元',
                '10万元*5.5%*90/365=1356元',
                '10万元*5.5%*90=495000元'),
            'right'=> array(
                array('10万元*5.5%=5500元', 0),
                array('10万元*5.5%*90/365=1356元', 10),
                array('10万元*5.5%*90=495000元', 0),
            )),
        array('answer'=>'您认为下列哪种投向的理财产品风险最低？',
            'option'=>array(
                '债券、货币',
                '信托',
                '房地产',
                '银行理财产品'),
            'right'=> array(
                array('债券、货币', 10),
                array('信托', 8),
                array('房地产', 5),
                array('银行理财产品', 10),
            )),
        array('answer'=>'你认为理财产品投资周期结束日是指什么？',
            'option'=>array(
                '理财产品到期日',
                '理财本金及收益分配日',
                '理财产品提前终止日'),
            'right'=> array(
                array('理财产品到期日', 5),
                array('理财本金及收益分配日', 10),
                array('理财产品提前终止日', 0),
            )),
        array('answer'=>'当你发现你被10分钟前离开的那家饭馆少找了十块钱而你的时间相当宝贵，你该怎么办?',
            'option'=>array(
                '这是原则问题，当然要回来',
                '打电话向那家饭店提意见，并要求收回少找的钱',
                '忘掉这件事'),
            'right'=> array(
                array('这是原则问题，当然要回来', 5),
                array('打电话向那家饭店提意见，并要求收回少找的钱', 10),
                array('忘掉这件事', 0),
            )),
        array('answer'=>'你很中意一件昂贵的名牌衣服，您会考虑?',
            'option'=>array(
                '立即现金购买',
                '信用卡免息分期购买',
                '等商家促销时购买'),
            'right'=> array(
                array('立即现金购买', 0),
                array('信用卡免息分期购买', 5),
                array('等商家促销时购买', 10),
            )),
        array('answer'=>'下列哪一项符合对您消费习惯的描述?',
            'option'=>array(
                '随意性很大，看当时的心情',
                '有一定的计划，偶尔也会被情绪引导',
                '消费前会列好清单，不被情绪左右'),
            'right'=> array(
                array('随意性很大，看当时的心情', 0),
                array('有一定的计划，偶尔也会被情绪引导', 5),
                array('消费前会列好清单，不被情绪左右', 10),
            )),
        array('answer'=>'你对保险的看法是：',
            'option'=>array(
                '需要适当买一些，但要有所控制，一般在收入的10%以内',
                '保险也能存下钱，可以多买一点，占到收入的30%都没问题',
                '消费前会列好清单，不被情绪左右'),
            'right'=> array(
                array('需要适当买一些，但要有所控制，一般在收入的10%以内', 5),
                array('保险也能存下钱，可以多买一点，占到收入的30%都没问题', 10),
                array('不用买，买了也没什么用', 0),
            )),
        array('answer'=>'一朋友在早先跟你借下一笔钱没还，他又来找你借钱了，说过后一起还清，你会：',
            'option'=>array(
                '要求对方打借条，限期还钱',
                '先借给他吧，人家也有难处',
                '要求对方清前债，否则免谈',
                '催讨前债，跟他翻脸'),
            'right'=> array(
                array('要求对方打借条，限期还钱', 5),
                array('先借给他吧，人家也有难处', 0),
                array('要求对方清前债，否则免谈', 10),
                array('催讨前债，跟他翻脸', 2),
            )),
        array('answer'=>'如果你出国旅行，可以找到不少有潜在升值的物品，回国以后很难购到。你会买',
            'option'=>array(
                '书画艺品',
                '古银首饰',
                '手工织毯',
                '古董相机'),
            'right'=> array(
                array('书画艺品', 2),
                array('古银首饰', 2),
                array('手工织毯', 5),
                array('古董相机', 10),
            )),
        array('answer'=>'公司发生了财务危机，已经一个月没领薪水了，这时候你会怎么办？',
            'option'=>array(
                '要求老板至少发一半薪水',
                '再忍一个月看看，积极寻找下家',
                '要求老板加薪',
                ' 立刻辞职'),
            'right'=> array(
                array('要求老板至少发一半薪水', 5),
                array('再忍一个月看看，积极寻找下家', 10),
                array('要求老板加薪', 2),
                array(' 立刻辞职', 0),
            )),
    );

    /**
     * 描述：获取redis键
     */
    private function __getKey($name)
    {
        return $this->preKey . '_' . $name;
    }

    /**
     * 描述：生成题目
     */
    public function actionIndex()
    {
        // 获取所有
        foreach($this->question as &$value)
        {
            $right = $value['right'];
            $value['right'] = array();
            foreach($right as $key=>$val)
            {
                $vk = md5($val[0]);
                $value['right'][$vk] = $val[1];
            }
        }
        Yii::$app->redis->hset($this->__getKey('answer_question') , 'question', \GuzzleHttp\json_encode($this->question));
        var_dump($this->question);die;
    }
} 