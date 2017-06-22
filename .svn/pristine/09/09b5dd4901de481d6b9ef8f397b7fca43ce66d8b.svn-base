<?php
/**
 * url处理类
 *
 * 描述
 * @author   gongjt@xxcb.cn
 * @version  2015/11/10 10:46
 * @since    1.0
 */

namespace components\helper;


use components\helper\StringHelper;
use yii\helpers\Html;
use components\XyXy;
use yii\helpers\Url;

class UrlUtility
{
    public static function getChannelUrl($id)
    {
        $cachedChannels = XyXy::getAppParam('cachedChannels');
        $channel = $cachedChannels[$id];

        if(! empty($channel['redirect_rul']))
        {
            return $channel['redirect_rul'];
        }

        $actionId = $channel['is_leaf'] ? 'list' : 'channel';

        return Url::to(['content/' . $actionId, 'chnid' => $id]);
    }

    public static function getChannelLink($id, $options = [])
    {
        $cachedChannels = XyXy::getAppParam('cachedChannels');
        $channel = $cachedChannels[$id];

        if(isset($options['title']))
        {
            $title = $options['title'];
            unset($options['title']);
        }
        else
        {
            $title = $channel['name'];
        }

        $url = self::getChannelUrl($id);
        return Html::a($title, $url, $options);
    }

    public static function getContentUrl($row)
    {
        if(isset($row['redirect_rul']) && ! empty($row['redirect_rul']))
        {
            return $row['redirect_rul'];
        }
        return Url::to(['content/detail', 'id' => $row['id'], 'chnid' => $row['channel_id']]);
    }

    public static function getContentLink($row, $length = 0, $options = [])
    {
        if(isset($options['title']))
        {
            $title = $options['title'];
            unset($options['title']);
        }
        else
        {
            $title = $row['title'];
        }

        if(is_integer($length) && $length > 0)
        {
            $title = StringHelper::subStr($title, $length);
        }

        $url = self::getContentUrl($row);
        return Html::a($title, $url, $options);
    }

    public static function getPageUrl($row)
    {
        return Url::to(['page/detail', 'id' => $row['id']]);
    }

    public static function getPageLink($row, $length = 0, $options = [])
    {
        if(isset($options['title']))
        {
            $title = $options['title'];
            unset($options['title']);
        }
        else
        {
            $title = $row['title'];
        }

        if(is_integer($length) && $length > 0)
        {
            $title = StringHelper::subStr($title, $length);
        }

        $url = self::getPageUrl($row);
        return Html::a($title, $url, $options);
    }
}
