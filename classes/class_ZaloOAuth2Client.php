<?php

use PHPUnit\Framework\TestCase;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class ZaloOAuth2Client
{
    protected $appId = '3980813874004753450';
    protected $appSecret = '4B52V2ARl5627KIMFKC6';
    protected $userCallbackUrl = 'put_your_user_callback_url_here';
    protected $oaCallbackUrl = 'https://isocms.com';
    protected $userCodeVerifier = 'put_your_user_code_verifier_here';
    protected $userCodeChallenge = '';
    protected $userState = '';
    protected $oauthCodeByUser = 'put_your_oauth_code_by_user_here';
    protected $oaCodeVerifier = 'put_your_oa_code_verifier_here';
    protected $oaCodeChallenge = 'put_your_oa_code_challenge_here';
    protected $oaState = 'put_your_oa_state_here';
    protected $oauthCodeByOA = 'put_your_oauth_code_by_oa_here';
    /**
     * @var OAuth2Client
     */
    protected $oauth2Client;
    function __construct(string $name = null, array $data = [], $dataName = '')
    {
        $config = [
            'app_id' => $this->appId,
            'app_secret' => $this->appSecret,
        ];
        $zalo = new Zalo($config);
        $this->oauth2Client = new OAuth2Client($zalo->getApp(), $zalo->getClient());
    }
    function getAuthorizationUrlByUser()
    {
        $url = $this->oauth2Client->getAuthorizationUrlByUser($this->userCallbackUrl, $this->userCodeChallenge, $this->userState);
        return $url;
    }
    function getAuthorizationUrlByOA()
    {
        $url = $this->oauth2Client->getAuthorizationUrlByOA($this->oaCallbackUrl, $this->oaCodeChallenge, $this->oaState);
        return $url;
    }
    function getZaloTokenByUser()
    {
        $userZaloToken = $this->oauth2Client->getZaloTokenFromCodeByUser($this->oauthCodeByUser, $this->userCodeVerifier);
        // test getZaloTokenFromByUserRefreshToken
        $this->oauth2Client->getZaloTokenFromRefreshTokenByUser($userZaloToken->getRefreshToken());
        $this->assertTrue(true);
    }
    function getZaloTokenByOA()
    {
        $oaZaloToken = $this->oauth2Client->getZaloTokenFromCodeByOA($this->oauthCodeByOA, $this->oaCodeVerifier);
        // test getZaloTokenFromRefreshTokenByOA
        $this->oauth2Client->getZaloTokenFromRefreshTokenByOA($oaZaloToken->getRefreshToken());
        $this->assertTrue(true);
    }
}
