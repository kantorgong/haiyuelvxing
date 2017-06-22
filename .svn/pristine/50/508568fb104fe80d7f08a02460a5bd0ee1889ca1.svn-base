<?php
/**
 * 权限控制器
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/9/23 21:55
 * @since    1.0
 */

namespace backend\modules\admin\controllers;


use Yii;
use backend\modules\admin\models\Role;
use backend\modules\admin\models\Menu;
use backend\modules\admin\models\RolePriv;
use backend\modules\admin\models\search\RoleSearch;
use backend\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\base\Exception;


/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Role model.
     * @param string $id
     * @return mixed
     */
    public function actionPriv($id)
    {
        $model = $this->findModel($id);
        if (\Yii::$app->request->isAjax)
        {
            RolePriv::deleteAll('role_id=:id', ['id' => $id]);
            try
            {
                foreach (\Yii::$app->request->post('menu_id') as $menuId)
                {
                    RolePriv::getDb()->createCommand()->insert('admin_role_priv', [
                        'menu_id' => $menuId,
                        'role_id' => $id
                    ])->execute();
                }
                $model->delCache();
                $this->success('保存成功');
            }
            catch (Exception $exc)
            {
                $this->error('保存失败');
            }
        }
        $privs = $model->getMenu();
        $rs = Menu::find()->select('id,parentid as pId, name')->orderBy('listorder ASC')->asArray()->all();
        $menus = [];
        foreach ($rs as $menu)
        {
            $menus[$menu['id']] = $menu;
            if (isset($privs[$menu['id']]))
            {
                $menus[$menu['id']]['checked'] = true;
                $menus[$menu['id']]['open'] = true;
            }
        }

        $menus = array_values($menus);
        return $this->render('priv', [
            'model' => $model,
            'menus' => $menus,
        ]);
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role;
        $this->performAjaxValidation($model);
        if ($model->load($_POST) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);
        if ($model->load($_POST) && $model->save())
        {
            return $this->redirect(['index']);
        }
        else
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $role = $this->findModel($id);
        if(count($role->users) > 0)
        {
            $this->error('该角色下有用户，不能删除');
        }
        else
        {
            $this->findModel($id)->delete();
            $this->success('操作成功');
        }
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ($id !== null && ($model = Role::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Job $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {

        if ($model->load($_POST) && Yii::$app->request->isAjax && Yii::$app->request->post('ajax') == 'role-form')
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            Yii::$app->response->data = \yii\widgets\ActiveForm::validate($model);
            Yii::$app->response->send();
            exit;
        }
    }
}
