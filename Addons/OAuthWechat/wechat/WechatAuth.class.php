<?php
namespace Addons\OAuthWechat\wechat;

class WechatAuth {
    /**
     * 微信开发者申请的appID
     * @var string
     */
    private $appId = '';
    /**
     * 微信开发者申请的appSecret
     * @var string
     */
    private $appSecret = '';
    /**
     * 获取到的access_token
     * @var string
     */
    private $accessToken = '';

    /**
     * 微信api根路径
     * @var string
     */
    private $apiURL = 'https://api.weixin.qq.com/cgi-bin';
    private $requestWebCodeURL = 'https://open.weixin.qq.com/connect/qrconnect';
    private $oauthApiURL = 'https://api.weixin.qq.com/sns';

    /**
     * 构造方法，调用微信高级接口时实例化SDK
     * @param string $appid  微信appid
     * @param string $secret 微信appsecret
     * @param string $token  获取到的access_token
     */
    public function __construct($appid, $secret, $token = null){
        if($appid && $secret){
            $this->appId     = $appid;
            $this->appSecret = $secret;

            if(!empty($token)){
                $this->accessToken = $token;
            }
        } else {
            throw new \Exception('缺少参数 APP_ID 和 APP_SECRET!');
        }
    }

    public function getRequestCodeURL($redirect_uri){
        $query = array(
            'appid'         => $this->appId,
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code',
            'scope'         => 'snsapi_login',
        );
        $query = http_build_query($query);
        return "{$this->requestWebCodeURL}?{$query}#wechat_redirect";
    }

    /**
     * 获取access_token，用于后续接口访问
     * @return array access_token信息，包含 token 和有效期
     */
    public function getAccessToken($type = 'client', $code = null){
        $param = array(
            'appid'  => $this->appId,
            'secret' => $this->appSecret
        );

        switch ($type) {
            case 'client':
                $param['grant_type'] = 'client_credential';
                $url = "{$this->apiURL}/token";
                break;

            case 'code':
                $param['code'] = $code;
                $param['grant_type'] = 'authorization_code';
                $url = "{$this->oauthApiURL}/oauth2/access_token";
                break;
            
            default:
                throw new \Exception('不支持的grant_type类型！');
                break;
        }

        $token = self::http($url, $param);
        $token = json_decode($token, true);

        if(is_array($token)){
            if(isset($token['errcode'])){
                throw new \Exception($token['errmsg']);
            } else {
                $this->accessToken = $token['access_token'];
                return $token;
            }
        } else {
            throw new \Exception('获取微信access_token失败！');
        }
    }

    /**
     * 获取授权用户信息
     * @param  string $openid 用户的OpenID
     * @param  string $lang   指定的语言
     * @return array          用户信息数据，具体参见微信文档
     */
    public function getUserInfo($openid, $lang = 'zh_CN'){
        $query = array(
            'access_token' => $this->accessToken,
            'openid'       => $openid,
            'lang'         => $lang,
        );
        $info = self::http("{$this->oauthApiURL}/userinfo", $query);
        return json_decode($info, true);
    }

    /**
     * 发送HTTP请求方法，目前只支持CURL发送请求
     * @param  string $url    请求URL
     * @param  array  $param  GET参数数组
     * @param  array  $data   POST的数据，GET请求时该参数无效
     * @param  string $method 请求方法GET/POST
     * @return array          响应数据
     */
    public static function http($url, $param, $data = '', $method = 'GET'){
        $opts = array(
            CURLOPT_TIMEOUT        => 300,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        );
        /* 根据请求类型设置特定参数 */
        $opts[CURLOPT_URL] = $url . '?' . http_build_query($param);
        if(strtoupper($method) == 'POST'){
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $data;
            if(is_string($data)){ //发送JSON数据
                $opts[CURLOPT_HTTPHEADER] = array(
                    'Content-Type: application/json; charset=utf-8',  
                    'Content-Length: ' . strlen($data),
                );
            }
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        //发生错误，抛出异常
        if($error) throw new \Exception('请求发生错误：' . $error);
        return  $data;
    }
}
