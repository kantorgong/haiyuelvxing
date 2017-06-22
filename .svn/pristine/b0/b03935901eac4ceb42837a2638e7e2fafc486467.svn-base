<?php

namespace backend\modules\xxcb\controllers;

use \backend\modules\admin\components\Controller;
use common\models\xxcb\search\TicketActivitySearch;
use common\models\xxcb\TicketActivity;
use components\helper\CommonUtility;
/**
 * Default controller for the `xxcb` module
 */
class TicketController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TicketActivitySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        CommonUtility::getDicts('ticket_type', 0);

        $model = new TicketActivity();
        if($model->load(\Yii::$app->request->post()))
        {

        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
