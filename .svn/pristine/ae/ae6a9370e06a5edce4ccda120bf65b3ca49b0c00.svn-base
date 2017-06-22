<?php
namespace common\jobs;

use shakura\yii2\gearman\JobBase;

class Lottery extends JobBase
{
    public function execute(\GearmanJob $job = null)
    {
        \components\XyXy::log('lottery:' . time());
        $params = unserialize($job->workload());
        \components\XyXy::log($params->params);
    }
}