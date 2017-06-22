<?php
/**
 * 网站配置控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/28 20:16
 * @since    1.0
 */

namespace backend\modules\admin\controllers;


use Yii;
use backend\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use components\XyXy;
use common\models\config\SiteForm;
use common\models\config\SeoForm;
//use common\models\config\ContentForm;
use common\models\config\Config;

/**
 * SiteConfigController implements the CRUD actions for Siteconfig model.
 */
class SiteconfigController extends Controller
{
    public function actionSite()
    {
        $model = new SiteForm();
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            $model->loadModel();

            $locals = [];
            $locals['model'] = $model;
            return $this->render('site', $locals);
        }
    }

    public function actionSeo()
    {
        $model = new SeoForm();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            $model->loadModel();

            $locals = [];
            $locals['model'] = $model;

            return $this->render('seo', $locals);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', ['model' => $model]);
        }
    }

    /**
     * Finds the Siteconfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Siteconfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Siteconfig::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
