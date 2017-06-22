<?php

namespace backend\modules\admin\controllers;

use components\XyXy;
use Yii;
use backend\modules\admin\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use components\deploy\GlobalHelper;
use components\helper\LogHelper;
use yii\data\Pagination;//分页类


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \backend\modules\admin\components\Controller
{
    public $enableCsrfValidation = false;

    // 头像大小限制200k
    const AVATAR_SIZE = 200000;

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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return $this->redirect(['index']);
            }
        }
        else
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
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

    //修改自己的信息
    public function actionUpdateme()
    {
        $model = $this->findModel(Yii::$app->user->identity->getId());
        $model->scenario = 'update';
//        var_dump(Yii::$app->request->post());die;
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            $this->success('操作成功');
        }
        else
        {
            return $this->render('updateme', [
                'model' => $model,
            ]);
        }
    }

    //修改皮肤
    public function actionUpdateskin()
    {
        $model = $this->findModel(Yii::$app->user->identity->getId());

        if (Yii::$app->request->post() && isset(Yii::$app->request->post()['User']['setting']['skin']))
        {
            //设置密码为空，则不更改密码
            $model['password'] = '';
            $skin = Yii::$app->request->post()['User']['setting']['skin'];
            $newskin = ['skin' => $skin];
            $oldsetting = $model['setting'];
            //已经存储个人设置
            if ($oldsetting != '')
            {
                //覆盖原来的皮肤参数
                $oldsettingObj = json_decode($oldsetting);
                $oldsettingObj->skin = $skin;
                $model['setting'] = json_encode($oldsettingObj);
            }
            else
            {
                $model['setting'] = json_encode($newskin);
            }
            $model->scenario = 'update';
            $model->save();
            $this->success('操作成功');

        }

    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($id == yii::$app->user->getId())
        {
            $this->error('不能删除自己');
        }
        else
        {
            $this->findModel($id)->delete();
            $this->success('操作成功');
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @Desc: 上传头像
     * @User: zhujw <zhjw@xxcb.cn>
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAvatar()
    {
        $fileParts = pathinfo($_FILES['avatar']['name']);
        if ($_FILES['avatar']['error'])
        {
            $this->renderJson([], -1, yii::t('user', 'upload failed'));
        }
        if ($_FILES['avatar']['size'] > static::AVATAR_SIZE)
        {
            $this->renderJson([], -1, yii::t('user', 'attached\'s size too large'));
        }
        if (!in_array(strtolower($fileParts['extension']), \Yii::$app->params['user.avatar.extension']))
        {
            $this->renderJson([], -1, yii::t('user', 'type not allow', [
                    'types' => join(', ', \Yii::$app->params['user.avatar.extension'])
            ]));
        }
        $tempFile   = $_FILES['avatar']['tmp_name'];
        $baseName   = sprintf('%s-%d.%s', date("YmdHis", time()), rand(10, 99), $fileParts['extension']);
        $newFile    = XyXy::formatAvatar($baseName);
        $targetFile = sprintf("%s/web/%s", rtrim(\Yii::$app->basePath, '/'),  ltrim($newFile, '/'));
        $ret = move_uploaded_file($tempFile, $targetFile);
        if ($ret)
        {
            $model = $this->findModel(Yii::$app->user->identity->getId());
            $model->avatar = $baseName;
            $ret = $model->save();
        }

        $this->renderJson(['url' => $newFile, 'name' => $baseName], !$ret, $ret ?: yii::t('user', 'update avatar failed'));
    }
}
