<?php

namespace backend\modules\admin\controllers;

use Yii;
use backend\modules\admin\models\Department;
use backend\modules\admin\models\search\DepartmentSearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DepartmentController implements the CRUD actions for Department model.
 */
class DepartmentController extends \backend\modules\admin\components\Controller
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
     * Lists all Department models.
     * @return mixed
     */
    public function actionIndex()
    {
        $rs = DepartmentSearch::find()->select('id, name, display, parentid, listorder, description')
            ->orderBy('listorder ASC')
            ->asArray()
            ->all();

        foreach ($rs as $k => $r)
        {
            $rs[$k]['display'] = ($r['display'] == 1) ? '是' : '否';
            $rs[$k]['str_manage'] = '
                <a class="green" style="padding:0px 2px;white-space:nowrap; " title="更新" href="' . Url::to(['update', 'id' => $r['id']]) . '"><i class="ace-icon fa fa-pencil bigger-130"></i> </a>
                <a class="red" style="padding:0px 2px;white-space:nowrap; "  title="删除" href="#" onclick ="gridViewConfirm(\'确定要删除吗？\', \'' . Url::to(['delete', 'id' => $r['id']]) . '\')"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
			';
        }
        $str = "
			<tr>

				<td style='width: 60px'><input  name='listorders[\$id]' type='text' vid='\$id' size='3' style='margin-bottom:0;padding:0px; text-align: center' value='\$listorder' class='form-control listorders'></td></td>
				<td>\$spacer \$name </td>
				<td>\$display </td>
				<td>\$description</td>

				<td class='button-column'>
					\$str_manage
				</td>
			</tr>
		";

        $tree = \components\helper\Tree::getInstance();

        $tree->icon = array ('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $tree->setData($rs);

        return $this->render('index', array (
            'lists' => $tree->get_tree(0, $str)
        ));
    }

    /**
     * 排序
     */
    public function actionListorder()
    {

        $orders = \Yii::$app->request->post('listorders');

        foreach ($orders as $k => $v)
        {
            $model = Department::findOne($k);
            $model->listorder = $v;
            $model->save();
        }
        $this->success('更新排序成功');
    }


    /**
     * Creates a new Department model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Department();
        if ($model->load(Yii::$app->request->post()) && $model->save())
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
     * Updates an existing Department model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
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
     * Deletes an existing Department model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $this->success('操作成功');
    }

    /**
     * Finds the Department model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Department the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Department::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
