<?php
/**
 * WeixinUtils.php
 * 
 * @author: Cyw
 * @email: rose1988.c@gmail.com
 * @created: 2014-8-4 下午8:11:52
 * @logs: 
 *       
 */

namespace Chat;

class WeixinUtils
{
    public static $urls1024info = array (
        'cl0' => array (
            'title' => '主站',
            'url' => 'http://url.zxzwb.com/cl0' 
        ),
        'cl1' => array (
            'title' => '[站一]',
            'url' => 'http://url.zxzwb.com/cl1' 
        ),
        'cl2' => array (
            'title' => '[站二]无需翻墙',
            'url' => 'http://url.zxzwb.com/cl2' 
        ),
        'cl3' => array (
            'title' => '[站三]',
            'url' => 'http://url.zxzwb.com/cl3' 
        ),
        'cl4' => array (
            'title' => '[站四]',
            'url' => 'http://url.zxzwb.com/cl4' 
        ),
        'clfarbox' => array (
            'title' => '[收藏发布页]',
            'url' => 'https://github.com/rose1988c/Caoliu.plug' 
        ) 
    );

    /**
     * 图文形式
     *
     * @param string $keyword            
     * @return array
     */
    public static function getPicTextContent($keyword = '')
    {
        $picTextContent = array ();
        
        if($keyword == '2048') {
            foreach((array)self::$urls1024info as $key => $value) {
                
                $title = $value ['title'];
                $description = '';
                $picUrl = $key == 0 ? 'http://gochat.duapp.com/www/img/weixin/cartoon.jpg' : 'http://gochat.duapp.com/www/img/weixin/ma_duixiang.jpg';
                // 使用跳转地址，过腾讯管家
                $url = 'http://gochat.duapp.com/url/jump/?to=' . $key;
                
                $picTextContent [] = array (
                    "Title" => $title,
                    "Description" => $description,
                    "Picurl" => $picUrl,
                    "Url" => $url 
                );
            }
        }
        return $picTextContent;
    }

    /**
     * 文本形式
     *
     * @param string $keyword            
     */
    public static function getTextContent($keyword = '')
    {
        $keyword = '';
        
        switch($keyword){
            case '比特熊':
                $keyword = '欢迎大家关注比特熊，为了保持干净清爽的体验，比特熊只提供特定关键字功能性的服务，绝对不会发任何广告信息骚扰大家。';
                break;
            default:
                $keyword = "Sorry, 目前比特熊只支持指定的关键字！\n暂时也没有help指令，关键字获取就靠您的智慧了！\n比特熊只提供特定关键字功能性的服务，绝对不会发任何广告信息骚扰大家。";
                break;
        }
        return $keyword;
    }

}
