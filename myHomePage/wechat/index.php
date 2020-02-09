<?php
/*
    方倍工作室 http://www.cnblogs.com/txw1958/
    CopyRight 2013 www.fangbei.org  All Rights Reserved
*/
header('Content-type:text');
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = file_get_contents('php://input');

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            // 分开判断类型
            switch ($RX_TYPE) {
                case 'event':
                    $result = $this->receiveEvent($postObj);
                    break;
                case 'text':
                    $result = $this->receiveText($postObj);
                    break;
                case 'image':
                    $result = $this->receiveImage($postObj);
                    break;
                default:
                    $result = 'unknow message type:'.$RX_TYPE;
                    break;
            }
            echo $result;
        }else{
            echo "";
            exit;
        }


            // $fromUsername = $postObj->FromUserName;
            // $toUsername = $postObj->ToUserName;
            // $keyword = trim($postObj->Content);
            // $time = time();
            // $textTpl = "<xml>
            //             <ToUserName><![CDATA[%s]]></ToUserName>
            //             <FromUserName><![CDATA[%s]]></FromUserName>
            //             <CreateTime>%s</CreateTime>
            //             <MsgType><![CDATA[%s]]></MsgType>
            //             <Content><![CDATA[%s]]></Content>
            //             <FuncFlag>0</FuncFlag>
            //             </xml>";
            // if($keyword == "?" || $keyword == "？")
            // {
            //     $msgType = "text";
            //     $contentStr = date("Y-m-d H:i:s",time());
            //     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            //     echo $resultStr;
            // }
    }

    private function receiveEvent($object)
    {
        $content = "";
        switch ($object->Event) {
            case 'subscribe':
                $content = "欢迎关注KY_House \n请回复以下关键字获取信息: \n时间  \n单图文";
                break;
            case 'unsubscribe':
                $content = "取消关注";
                break;
            default:
                $content = "receive a new event:".$object->Event;
                break;
        }

        if (is_array($content)) {
           $result = $this->transmitNews($object,$content);
        }else{
            $result = $this->transmitText($object,$content);
        }
        return $result;
    }

    private function receiveText($object)
    {
        $keyword = trim($object->Content);
        $content = "";
        if (strstr($keyword,"时间")) {
            $content = "当前的时间是: ".date("Y-m-d H:i:s",time());
        }else if (strstr($keyword,"单图文")) {
            $content = array();
            $content[] = array("Title"=>"单图文标题","Description"=>"单图文内容","PicUrl"=>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg","Url"=>"http://www.dforest.top");
        }

        if (is_array($content)) {
            $result = $this->transmitNews($object,$content);
        }else{
            $result = $this->transmitText($object,$content);
        }
        return $result;
    }

    private function transmitText($object,$content)
    {
        if (!isset($content) || empty($content)) {
            return "";
        }

        $xmlTpl = "<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[text]]></MsgType>
                   <Content><![CDATA[%s]]></Content>
                   </xml>";
        $result = sprintf($xmlTpl,$object->FromUserName,$object->ToUserName,time(),$content);

        return $result;
    }

    private function transmitNews($object,$newsArr)
    {
        if (!is_array($newsArr)) {
            return "";
        }

        $itemTpl = "<item>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>";
        $item_str = "";
        foreach ($newsArr as $item) {
            $item_str .= sprintf($itemTpl,$item['Title'],$item['Description'],$item['PicUrl'],$item['Url']);
        }

        $xmlTpl = "<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[news]]></MsgType>
                   <ArticleCount>%s</ArticleCount>
                   <Articles>$item_str</Articles>
                   </xml>";
        $result = sprintf($xmlTpl,$object->FromUserName,$object->ToUserName,time(),count($newsArr));
        return $result;
    }
}
?>