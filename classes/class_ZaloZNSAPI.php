
<?php
use Zalo\Util\PKCEUtil;
use PHPUnit\Framework\TestCase;
use Zalo\Authentication\OAuth2Client;
use Zalo\Authentication\ZaloToken;
use Zalo\Exceptions\ZaloSDKException;
use Zalo\Exceptions\ZaloOAException;
use Zalo\Exceptions\ZaloResponseException;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class ZaloZNSAPI{
    /**
     * @var Zalo
     */
    protected $zalo;
    protected $oauth2Client;
    protected $accessToken;
    

   function __construct(){
       global $clsConfiguration;
         $config = array(
            'app_id' => $clsConfiguration->getValue('ZaloAppId')?$clsConfiguration->getValue('ZaloAppId'):'3312502072358315825',
            'app_secret' => $clsConfiguration->getValue('ZaloSecret')?$clsConfiguration->getValue('ZaloSecret'):'5BS4T8FlCW6Pjo0Mg15R'
        );

       $this->zalo = new Zalo($config);
	   $this->oauth2Client = new OAuth2Client($this->zalo->getApp(), $this->zalo->getClient()); 
    }
    
    function SendZNS($param=NULL){
        global $clsConfiguration;
        $ZaloRefreshToken=$clsConfiguration->getValue('ZaloRefreshToken');
        
        $ZaloToken=$this->oauth2Client->getZaloTokenFromRefreshTokenByOA($ZaloRefreshToken);
        $ZaloRefreshTokenUpdate= $ZaloToken->getRefreshToken();
        if(!empty($ZaloRefreshTokenUpdate)){
            $clsConfiguration->updateValue('ZaloRefreshToken', $ZaloRefreshTokenUpdate);
        }
        $ZaloAccessToken=$ZaloToken->getAccessToken();
        $ZaloAccessTokenExpiresAt= $ZaloToken->getAccessTokenExpiresAt();
        
        $response = $this->zalo->post(ZaloEndPoint::API_SEND_ZNS, $ZaloAccessToken, $param);
        
        return $response;
        
        $result = $response->getDecodedBody();
        return $result;
    }
    
    
    function getQuota(){
        global $clsConfiguration;
        $ZaloRefreshToken=$clsConfiguration->getValue('ZaloRefreshToken');
        
        $ZaloToken=$this->oauth2Client->getZaloTokenFromRefreshTokenByOA($ZaloRefreshToken);
        $ZaloRefreshTokenUpdate= $ZaloToken->getRefreshToken();
        if(!empty($ZaloRefreshTokenUpdate)){
            $clsConfiguration->updateValue('ZaloRefreshToken', $ZaloRefreshTokenUpdate);
        }
        $ZaloAccessToken=$ZaloToken->getAccessToken();
        $response = $this->zalo->get(ZaloEndPoint::API_OA_QUOTA, $ZaloAccessToken);
        $result = $response->getDecodedBody();
        return $result;
    }
 }

?>