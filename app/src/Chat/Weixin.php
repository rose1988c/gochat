<?php
/**
 * Weixin.php
 * 
 * @author: Cyw
 * @email: rose1988.c@gmail.com
 * @created: 2014-8-4 下午8:04:54
 * @logs: 
 *         空格 (&#x20;)
 *         Tab (&#x09;)
 *         回车 (&#x0D;)
 *         换行 (&#x0A;)
 */
namespace Chat;

use \Chat\WeixinUtils as WxUtils;

class Weixin
{
    const TOKEN = 'xzy227f480865831c2fda3885889a3649a1';
    
    private $msgCreateTime;

    /**
     * 接入验证
     */
    public function valid()
    {
        $echoStr = $_GET ["echostr"];
        if($this->checkSignature()) {
            echo $echoStr;
            exit();
        }
    }

    /**
     * 回复消息
     */
    public function responseMsg()
    {
        // get post data, May be due to the different environments
        $postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
        
        // extract post data
        if( ! empty($postStr)) {
            
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            
            $rx_type = trim($postObj->MsgType);
            
            // 消息事件，分析fakeid
            $this->msgCreateTime = $postObj->CreateTime;
            
            switch($rx_type){
                case 'text':
                    $resultStr = $this->receiveText($postObj);
                    break;
                case 'event':
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                case "image":
                    $resultStr = $this->receiveImage($postObj);
                    break;
                case "location":
                    $resultStr = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $resultStr = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $resultStr = $this->receiveLink($postObj);
                    break;
                default:
                    $resultStr = "unknow msg type: " . $rx_type;
                    break;
            }
            if( ! empty($resultStr)) {
                echo $resultStr;
            } else {
                echo "Input something...";
            }
        } else {
            echo "";
            exit();
        }
    }
    
    /* ************************************************************************ */
    /**
     * 回复文本
     *
     * @param unknown $object            
     * @return string
     */
    private function receiveText($object)
    {
        $funcFlag = 0;
        $keyword = trim($object->Content);
        
        // ---------------------------图文形式------------------------------
        if($keyword == "1024" || $keyword == "草榴" || $keyword == "cl" || $keyword == "caoliu") {
            
            $urls = WxUtils::$urls1024info;
            $codes = array_keys($urls);
            shuffle($codes);
            $code = current($codes);
            $url = $urls [$code];
            
            $dateArray = array ();
            // \nlog:2014-1-11解决腾讯安全管家屏蔽
            $dateArray [] = array (
                "Title" => "1024 大隐隐于技术区! " . $url ['title'],
                "Description" => "1024随机展示一个网址" . "\n如不能访问请再呐喊1024" . "\n查看全部请回复2048" . "\nLog:" . "\n    01-11解决腾讯安全管家屏蔽" . "\n    03-08更新链接" . "\nPs:" . "\n    建议请回复jy@你的建议" . "\n    邀请码请回复yqm@你的理由",
                "Picurl" => "http://gochat.duapp.com/www/img/weixin/cartoon.jpg",
                "Url" => 'http://gochat.duapp.com/url/jump/?to=' . $code 
            );
            
            $resultStr = $this->transNews($object, $dateArray, $funcFlag);
            // ---------------------------多图文形式------------------------------
        } else if($keyword == "1x") {
            $dateArray = WxUtils::getPicTextContent('2048');
            $resultStr = $this->transNews($object, $dateArray, $funcFlag);
        } else if($keyword == "2048") {
            $dateArray = WxUtils::getPicTextContent('2048');
            $resultStr = $this->transNews($object, $dateArray, $funcFlag);
        } else {
            // ---------------------------文本形式------------------------------
            $contentStr = WxUtils::getTextContent($keyword); // 文本特殊处理 - 转url转发
            $resultStr = $this->transText($object, $contentStr, $funcFlag);
        }
        
        return $resultStr;
        
        // $funcFlag = 0;
        // $keyword = trim($object->Content);
        // $resultStr = "";
        // $contentStr = "";
        
        // if ($keyword == "文本") {
        // $contentStr = "这是个文本消息";
        // $resultStr = $this->transText($object, $contentStr, $funcFlag);
        // } else if ($keyword == "图文" || $keyword == "单图文") {
        // $dateArray = array ();
        // $dateArray [] = array (
        // "Title" => "单图文标题",
        // "Description" => "单图文内容",
        // "Picurl" => "http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",
        // "Url" => "http://m.cnblogs.com/?u=txw1958"
        // );
        // $resultStr = $this->transNews($object, $dateArray, $funcFlag);
        // } else if ($keyword == "多图文") {
        // $dateArray = array ();
        // $dateArray [] = array (
        // "Title" => "多图文1标题",
        // "Description" => "",
        // "Picurl" => "http://discuz.comli.com/weixin/weather/icon/cartoon.jpg",
        // "Url" => "http://m.cnblogs.com/?u=txw1958"
        // );
        // $dateArray [] = array (
        // "Title" => "多图文2标题",
        // "Description" => "",
        // "Picurl" => "http://d.hiphotos.bdimg.com/wisegame/pic/item/f3529822720e0cf3ac9f1ada0846f21fbe09aaa3.jpg",
        // "Url" => "http://m.cnblogs.com/?u=txw1958"
        // );
        // $dateArray [] = array (
        // "Title" => "多图文3标题",
        // "Description" => "",
        // "Picurl" => "http://g.hiphotos.bdimg.com/wisegame/pic/item/18cb0a46f21fbe090d338acc6a600c338644adfd.jpg",
        // "Url" => "http://m.cnblogs.com/?u=txw1958"
        // );
        // $resultStr = $this->transNews($object, $dateArray, $funcFlag);
        // } else if ($keyword == "音乐") {
        // $musicArray = array (
        // "Title" => "最炫民族风",
        // "Description" => "歌手：凤凰传奇",
        // "MusicUrl" => "http://121.199.4.61/music/zxmzf.mp3",
        // "HQMusicUrl" => "http://121.199.4.61/music/zxmzf.mp3"
        // );
        // $resultStr = $this->transMusic($object, $musicArray, $funcFlag);
        // }
        // return $resultStr;
    }

    private function receiveImage($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是图片，地址为：" . $object->PicUrl;
        $resultStr = $this->transText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLocation($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是位置，纬度为：" . $object->Location_X . "；经度为：" . $object->Location_Y . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
        $resultStr = $this->transText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVoice($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是语音，媒体ID为：" . $object->MediaId;
        $resultStr = $this->transText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVideo($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是视频，媒体ID为：" . $object->MediaId;
        $resultStr = $this->transText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLink($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
        $resultStr = $this->transText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveEvent($object)
    {
        $contentStr = "";
        switch($object->Event){
            case "subscribe":
                $contentStr = "欢迎关注比特熊";
                break;
            case "unsubscribe":
                $contentStr = "";
                break;
            case "CLICK":
                switch($object->EventKey){
                    default:
                        $contentStr = "你点击了: " . $object->EventKey;
                        break;
                }
                break;
            default:
                $contentStr = "receive a new event: " . $object->Event;
                break;
        }
        $resultStr = $this->transText($object, $contentStr);
        return $resultStr;
    }
    
    
    /* ************************************************************************ */
    /**
     * 信息 - 文本信息
     *
     * @param unknown $object            
     * @param unknown $content            
     * @param number $flag            
     * @return string
     */
    private function transText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>%d</FuncFlag>
                    </xml>";
        
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), 'text', $content, $flag);
        return $resultStr;
    }

    private function transNews($object, $arr_item, $flag = 0)
    {
        if( ! is_array($arr_item))
            return;
        
        $itemTpl = "<item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                    </item>";
        $item_str = "";
        foreach($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item ['Title'], $item ['Description'], $item ['Picurl'], $item ['Url']);
        
        $newsTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <Content><![CDATA[]]></Content>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>
                        $item_str</Articles>
                        <FuncFlag>%s</FuncFlag>
                    </xml>";
        
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $flag);
        return $resultStr;
    }

    private function transMusic($object, $musicArray, $flag = 0)
    {
        $itemTpl = "<Music>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <MusicUrl><![CDATA[%s]]></MusicUrl>
                        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>";
        
        $item_str = sprintf($itemTpl, $musicArray ['Title'], $musicArray ['Description'], $musicArray ['MusicUrl'], $musicArray ['HQMusicUrl']);
        
        $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[music]]></MsgType>
                        $item_str
                        <FuncFlag>%d</FuncFlag>
                        </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $flag);
        return $resultStr;
    }
    
    /* ************************************************************************ */

    /**
     * 检查签名
     *
     * @return boolean
     */
    private function checkSignature()
    {
        $signature = $_GET ["signature"];
        $timestamp = $_GET ["timestamp"];
        $nonce = $_GET ["nonce"];
        
        $token = self::TOKEN;
        $tmpArr = array (
            $token,
            $timestamp,
            $nonce 
        );
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        
        if($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}

