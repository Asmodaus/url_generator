<?php
namespace SocialAuther\Adapter;
class Instagram extends AbstractAdapter
{
    public function __construct($config)
    {
        parent::__construct($config);
        $this->socialFieldsMap = array(
            'socialId' => 'id',
            'name'     => 'full_name',
            'email'    => 'email',
            'sex'      => 'sex',
            'url' => 'username'
        );
        $this->provider = 'instagram';
        $this->responseType = 'oauth_token';
    }
    /**
     * Get user social id or null if it is not set
     *
     * @return string|null
     */
    public function getSocialPage()
    {
        $result = null;
        if (isset($this->userInfo['screen_name'])) {
            $result = 'http://instagram.com/' . $this->userInfo['screen_name'];
        }
        return $result;
    }
    /**
     * Get url of user's avatar or null if it is not set
     *
     * @return string|null
     */
    public function getAvatar()
    {
        $result = null;
        if (isset($this->userInfo['profile_image_url'])) {
            $result = implode('', explode('_normal', $this->userInfo['profile_image_url']));
        }
        return $result;
    }
    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool
     */
	 
	public function getOAuthToken($code, $token = false)
    {
        $apiData = array(
            'grant_type' => 'authorization_code',
            'client_id' => $this->getApiKey(),
            'client_secret' => $this->getApiSecret(),
            'redirect_uri' => $this->getApiCallback(),
            'code' => $code
        );
        $result = $this->_makeOAuthCall($apiData);
        return !$token ? $result : $result->access_token;
    }

	 protected function _makeCall($function, $auth = false, $params = null, $method = 'GET')
    {
        if (!$auth) {
            // if the call doesn't requires authentication
            $authMethod = '?client_id=' . $this->getApiKey();
        } else {
            // if the call needs an authenticated user
            if (!isset($this->_accesstoken)) {
              // // throw new InstagramException("Error: _makeCall() | $function - This method requires an authenticated users access token.");
            }
            $authMethod = '?access_token=' . $this->getAccessToken();
        }
        $paramString = null;
        if (isset($params) && is_array($params)) {
            $paramString = '&' . http_build_query($params);
        }
        $apiCall = self::API_URL . $function . $authMethod . (('GET' === $method) ? $paramString : null);
        // we want JSON
        $headerData = array('Accept: application/json');
        if ($this->_signedheader) {
            $apiCall .= (strstr($apiCall, '?') ? '&' : '?') . 'sig=' . $this->_signHeader($function, $authMethod, $params);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiCall);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, ltrim($paramString, '&'));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $jsonData = curl_exec($ch);
        // split header from JSON data
        // and assign each to a variable
        list($headerContent, $jsonData) = explode("\r\n\r\n", $jsonData, 2);
        // convert header content into an array
        $headers = $this->processHeaders($headerContent);
        // get the 'X-Ratelimit-Remaining' header value
        $this->_xRateLimitRemaining = $headers['X-Ratelimit-Remaining'];
        if (!$jsonData) {
           // throw new InstagramException('Error: _makeCall() - cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($jsonData);
    }
    /**
     * The OAuth call operator.
     *
     * @param array $apiData The post API data
     *
     * @return mixed
     *
     * @throws \MetzWeb\Instagram\InstagramException
     */
    private function _makeOAuthCall($apiData)
    {
        $apiHost = self::API_OAUTH_TOKEN_URL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiHost);
        curl_setopt($ch, CURLOPT_POST, count($apiData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        $jsonData = curl_exec($ch);
        if (!$jsonData) {
           // throw new InstagramException('Error: _makeOAuthCall() - cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($jsonData);
    }
    /**
     * Sign header by using endpoint, parameters and the API secret.
     *
     * @param string
     * @param string
     * @param array
     *
     * @return string The signature
     */
    private function _signHeader($endpoint, $authMethod, $params)
    {
        if (!is_array($params)) {
            $params = array();
        }
        if ($authMethod) {
            list($key, $value) = explode('=', substr($authMethod, 1), 2);
            $params[$key] = $value;
        }
        $baseString = '/' . $endpoint;
        ksort($params);
        foreach ($params as $key => $value) {
            $baseString .= '|' . $key . '=' . $value;
        }
        $signature = hash_hmac('sha256', $baseString, $this->_apisecret, false);
        return $signature;
    }
    /**
     * Read and process response header content.
     *
     * @param array
     *
     * @return array
     */
    private function processHeaders($headerContent)
    {
        $headers = array();
        foreach (explode("\r\n", $headerContent) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
                continue;
            }
            list($key, $value) = explode(':', $line);
            $headers[$key] = $value;
        }
        return $headers;
    }
	
    public function authenticate()
    {
        $result = false;
        if (isset($_GET['code'])  ) {
            $params = array(
				'client_id'=>$this->client_id,
				'client_secret'=>$this->client_secret,
				'grant_type' => 'authorization_code',
				'redirect_uri'=>$this->redirect_uri,
                'code'    => $_GET['code'] 
            );
            $accessTokenUrl = 'https://api.instagram.com/oauth/access_token'; 
            $accessTokens = $this->get($accessTokenUrl, $params, false);
			
			
			$json = json_decode($accessTokens);
			
			$this->userInfo = $json->user;
			
            if ($json->user->id>0) return true;
        }
        return false;
    }
    /**
     * Prepare params for authentication url
     *
     * @return array
     */
    public function prepareAuthParams()
    {  
        return array(
            'auth_url'    => 'https://api.instagram.com/oauth/authorize/',
            'auth_params' => array(
				'client_id'     =>$this->client_id,
				'client_secret' => $this->client_secret,
				'redirect_uri'  => $this->redirect_uri,
				'response_type'=>'code'
			)  ),
        );
    }
    /**
     * Prepare url-params with signature
     *
     * @return array
     */
    private function prepareUrlParams($url, $params = array(), $oauth_token = '', $type = 'GET') 
    {
        $params += array(
            'oauth_consumer_key'     => $this->clientId,
            'oauth_nonce'            => md5(uniqid(rand(), true)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp'        => time(),
            'oauth_token'            => $oauth_token,
            'oauth_version'          => '1.0',
        );
        ksort($params);
        $sigBaseStr = $type . '&' . urlencode($url) . '&' . urlencode(http_build_query($params));
        $key = $this->clientSecret . '&' . $oauth_token;
        $params['oauth_signature'] = base64_encode(hash_hmac("sha1", $sigBaseStr, $key, true));
        $params = array_map('urlencode', $params);
        return $params;
    }
}