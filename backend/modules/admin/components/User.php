<?php
/**
 * 管理员类
 *
 * 管理员信息、管理员菜单的获取
 * @author   gongjt@xxcb.cn
 * @version  2015/9/16 14:00
 * @since    1.0
 */

namespace backend\modules\admin\components;

use backend\modules\admin\models\Menu;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;

class User extends \yii\web\User
{
    /**
     * @var string the session variable name used to store the value of [[id]].
     */
    public $idParam = '__adminid';
    //后台登录地址
    public $loginUrl = ['admin/default/login'];
    //身份验证类
    public $identityClass = 'backend\modules\admin\models\User';


    /**
     * 获取当前用户所在角色的菜单
     * @param string $type （m获取菜单 c获取菜单控制） 列表
     */
    public function getMenu()
    {
        if ($this->isSuperUser())
        {
            return Menu::find()->where('display=0')->orderBy('listorder ASC')->indexBy('id')->asArray()->all();
        }
        else
        {
            return $this->identity->role->getMenu();
        }
    }

    /**
     * 获取当前用户所在角色的控制器
     *
     *
     * @author     gongjt@xxcb.cn
     * @since      1.0
     */
    public function getControllers()
    {
        return $this->identity->role->getControllers();
    }

    /**
     * 判断是否是超级管理员
     *
     *
     *
     * @author     gongjt@xxcb.cn
     * @since      1.0
     */
    public function isSuperUser()
    {
        $module = Yii::$app->modules['admin'];
        if (is_object($module))
        {
            $ids = $module->superUserIds;
        }
        else
        {
            $ids = $module['superUserIds'];
        }
        return in_array($this->id, $ids);
    }

    /**
     * 获取用户对象
     * @return User
     */
    public static function getUser()
    {
        return Yii::$app->getUser();
    }

    /**
     * @param string $operation
     * @return bool|void
     */
    public function checkAccess($operation, $params = [], $allowCaching = true)
    {
        return in_array($operation, $this->getControllers());
    }
}