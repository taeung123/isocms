
<?php
use Zalo\Util\PKCEUtil;
use PHPUnit\Framework\TestCase;
use Zalo\Authentication\OAuth2Client;
use Zalo\Authentication\ZaloToken;
use Zalo\Exceptions\ZaloSDKException;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class ZaloOpenAPI{
    /**
     * @var Zalo
     */
    protected $zalo;
    protected $oauth2Client;
    protected $accessToken;
    

   function __construct(){
       global $clsConfiguration;
         $config = array(
            'app_id' => $clsConfiguration->getValue('ZaloAppId')?$clsConfiguration->getValue('ZaloAppId'):'1602668563430577375',
            'app_secret' => $clsConfiguration->getValue('ZaloSecret')?$clsConfiguration->getValue('ZaloSecret'):'JW4FP8d7CLnVG2L1i7gV'
        );

       $this->zalo = new Zalo($config);
	   $this->accessToken = $clsConfiguration->getValue('ZaloAccessToken'); 
	   $this->oauth2Client = new OAuth2Client($this->zalo->getApp(), $this->zalo->getClient()); 
    }
    
	function GetZaloTokenByOA($RefreshToken) {
        $ZaloToken=$this->oauth2Client->getZaloTokenFromRefreshTokenByOA($RefreshToken);
        return $ZaloToken;
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
        $result = $response->getDecodedBody();
        return $result;
    }
        
    function getAuthorizationUrlByOA(){
        $oaCallbackUrl = "https://isocms.com";
        $codeVerifier = PKCEUtil::genCodeVerifier();
        $codeChallenge = PKCEUtil::genCodeChallenge($codeVerifier);
        $state = "";
        $url = $this->oauth2Client->getAuthorizationUrlByOA($oaCallbackUrl, $codeChallenge, $state);
        return $url;
    }
    function getlinkOAGrantPermission2App(){
        $helper = $this->zalo -> getRedirectLoginHelper();
        $oaCallbackUrl = "https://isocms.com";
        $codeVerifier = PKCEUtil::genCodeVerifier();
        $codeChallenge = PKCEUtil::genCodeChallenge($codeVerifier);
        $state = "";
        $linkOAGrantPermission2App = $helper->getLoginUrlByOA($oaCallbackUrl, $codeChallenge, $state);
        return $linkOAGrantPermission2App; 
        
    }
    
    
    function sendMessage($type='text'){
        switch ($type){
            case 'text':
                #Gửi tin nhắn text    
                $msgBuilder = new MessageBuilder('text');
                $msgBuilder->withUserId('431220974785605841');
                $msgBuilder->withText('Message Text');
                $msgText = $msgBuilder->build();
                // send request
                $response = $this->zalo->post(ZaloEndpoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgText);
                $result = $response->getDecodedBody(); // result    
                break;
            case 'media':
                #Gửi tin nhắn hình    
                $msgBuilder = new MessageBuilder('media');
                $msgBuilder->withUserId('431220974785605841');
                $msgBuilder->withText('Message Image');
                $msgBuilder->withAttachment('O5DQPI_gKq9iMbDZBET7L6jDHNKk_4XCUKTIOpxvNaTdKr9mAFa24Ia1IJvpfXDPPKzOE3sg4qfbKaCmPBLLNt1P0sHplnH2CWSROtE-4a4_11rXUheJGJe616PzkWX6RLO5Dotd2n4x30ioUxm42MH4MpvzTOWu5MxvKr8');
                
                
                $msgBuilder->withMediaUrl('https://stc-developers.zdn.vn/images/bg_1.jpg');

                $msgImage = $msgBuilder->build();

                // send request
                $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgImage);
                $result = $response->getDecodedBody();
                break;
            case 'list':
                $msgBuilder = new MessageBuilder('list');
                $msgBuilder->withUserId('431220974785605841');

                $actionOpenUrl = $msgBuilder->buildActionOpenURL('https://www.google.com');
                $msgBuilder->withElement('Open Link Google', 'https://img.icons8.com/bubbles/2x/google-logo.png', 'Search engine', $actionOpenUrl);

                $actionQueryShow = $msgBuilder->buildActionQueryShow('query_show');
                $msgBuilder->withElement('Query Show', 'https://www.computerhope.com/jargon/q/query.jpg', '', $actionQueryShow);

                $actionQueryHide = $msgBuilder->buildActionQueryHide('query_hide');
                $msgBuilder->withElement('Query Hide', 'https://www.computerhope.com/jargon/q/query.jpg', '', $actionQueryHide);

                $actionOpenPhone = $msgBuilder->buildActionOpenPhone('0919018791');
                $msgBuilder->withElement('Open Phone', 'https://cdn.iconscout.com/icon/premium/png-256-thumb/phone-275-123408.png', '', $actionOpenPhone);

                $actionOpenSMS = $msgBuilder->buildActionOpenSMS('0919018791', 'sms text');
                $msgBuilder->withElement('Open SMS', 'https://cdn0.iconfinder.com/data/icons/new-design/512/42-Chat-512.png', '', $actionOpenSMS);

                $msgList = $msgBuilder->build();
                $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgList);
                $result = $response->getDecodedBody(); // result
                break;
            case 'gif':
                #Gửi tin nhắn dạng Gif
                $msgBuilder = new MessageBuilder('media');
                $msgBuilder->withUserId('431220974785605841');
                $msgBuilder->withText('Message Image');
                $msgBuilder->withAttachment('pEq6ALHczYF1w0OpGMFcDT3h42LGOV0ZnkW2CqPbuZN6j5Hz57wiRfcb735QRweWbQKFCL1rgoE8g0SnN7_gESRm73rNU-mspFCNE5PouJ3D_GnjMtV_Dv-lM6WDS_XcbgWFRGHth7EAx5jj4dVn9SI-G2D9AE1jYF1H9GSau7w8xKejNZkcQvtc2db9CUTnqh4LVaWyvdFJl1DxI3RfTT-t17eSE_H_sh5GSau_yIYAj05r7ZkdPzRo0dbzehd2F1LszJS');
                $msgBuilder->withMediaType('gif');
                $msgBuilder->withMediaSize(120, 120);
                $msgImage = $msgBuilder->build();

                $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgImage);
                $result = $response->getDecodedBody(); // result
                break;
            case 'file':
                 # Gửi File
                $msgBuilder = new MessageBuilder('file');
                $msgBuilder->withUserId('431220974785605841');
                $msgBuilder->withFileToken('PkkPJZzjmrbliDeEQ6h6MYVxrmrkSenF8A3N0MGpcWailOnLPpZDM7lbsG9YRSe8VxEG0MSuqmv_l945R3NM2d6vb0ThDhvQCgUYKo1vW0nwlRO6EdUnNoQWeo5sUUTqA8JM7cXHuNPqeiK81569QLtRcHSWEDWUFBQO7aa-taK6vvn473xS7m2xa1ySCzmUL-wR54mpYaXGxfj0CIgyTJWa8vW6');//call_upload_file_api_to_get_file_token
            $msgFile = $msgBuilder->build();
            $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgFile);
            $result = $response->getDecodedBody(); // result
                break;
            default:
                $msgBuilder = new MessageBuilder('text');
                $msgBuilder->withUserId('431220974785605841xxx');
                $msgBuilder->withText('Message Text');

                $msgText = $msgBuilder->build();
                // send request
                $response = $this->zalo->post(ZaloEndpoint::API_OA_SEND_MESSAGE, $this->accessToken, $msgText);
                $result = $response->getDecodedBody(); // result    

            
        }
        return $result;
    }
    function uploadMessage($type='photo',$filePath = 'put your file path'){
    switch ($type){
        case 'photo':
            ## Upload hình
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_PHOTO, $this->accessToken, $data);
            $result = $response->getDecodedBody(); // result
            break;
        case 'gif':
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_GIF, $this->accessToken, $data);
            $result = $response->getDecodedBody(); // result
            break;
        case 'file':
            $data = array('file' => new ZaloFile($filePath));
            $response = $this->zalo->post(ZaloEndpoint::API_OA_UPLOAD_FILE, $this->accessToken, $data);
            $result = $response->getDecodedBody(); // result
            break;
        case 'photo':
            break;
        case 'photo':
            break;
        }
        return $result;
    }
    function getListTagOfOAAPI(){
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_TAG, $this->accessToken, []);
        $result = $response->getDecodedBody();
        return $result;
    }

   function removeTagOfOAAPI(){
      $data = array('tag_name' => 'vip');
      $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_TAG, $this->accessToken, $data);
      $result = $response->getDecodedBody();
      return $result;
    }

    function removeUserFromTagAPI(){
        $data = array(
            'user_id' => 'user_id',
            'tag_name' => 'tag_name'
        );
        $response = $this->zalo->post(ZaloEndPoint::API_OA_REMOVE_USER_FROM_TAG, $this->accessToken, $data);
        $result = $response->getDecodedBody();
        return $result;
    }

    function addUserToTagAPI(){
        $data = array(
            'user_id' => 'user_id',
            'tag_name' => 'tag_name'
        );
        $response = $this->zalo->post(ZaloEndPoint::API_OA_TAG_USER, $this->accessToken, $data);
        $result = $response->getDecodedBody();
        return $result;
    }

    function oAGetListFollowerAPI(){
        $data = ['data' => json_encode(array(
            'offset' => 0,
            'count' => 10
        ))];
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_FOLLOWER, $this->accessToken, $data);
        $result = $response->getDecodedBody(); // result
        return $result;
    }

    function oAGetUserProfileAPI(){
        $data = ['data' => json_encode(array(
            'user_id' => 'user_id'
        ))];
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_USER_PROFILE, $this->accessToken, $data);
        $result = $response->getDecodedBody(); // result
        return $result;
    }

    function oAGetProfileAPI(){
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_PROFILE, $this->accessToken, []);
        $result = $response->getDecodedBody(); // result
        return $result;
    }

    function oAGetListRecentChatAPI(){
        $data = ['data' => json_encode(array(
            'offset' => 0,
            'count' => 10
        ))];
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_LIST_RECENT_CHAT, $this->accessToken, $data);
        $result = $response->getDecodedBody(); // result
        return $result;
    }

    function oAGetConversationAPI(){
        $data = ['data' => json_encode(array(
            'user_id' => 'user_id',
            'offset' => 0,
            'count' => 10
        ))];
        $response = $this->zalo->get(ZaloEndPoint::API_OA_GET_CONVERSATION, $this->accessToken, $data);
        $result = $response->getDecodedBody(); // result
        return $result;
    }

    function oASendConsultationTextMessageAPI(){
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_TXT);
        $msgBuilder->withUserId('user_id');
        $msgBuilder->withText('Message Text');

        $msgText = $msgBuilder->build();

        // send request
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();
        return $result;
    }

    function oASendImageConsultationMessageAPI(){
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_MEDIA);
        $msgBuilder->withUserId('user_id');
        $msgBuilder->withText('Message Image');
        $msgBuilder->withMediaUrl('https://stc-developers.zdn.vn/images/bg_1.jpg');

        $msgImage = $msgBuilder->build();

        // send request
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgImage);
        $result = $response->getDecodedBody();
        return $result;
    }

    function oARequestUserInfoConsultationMessageAPI(){
        $msgBuilder = new MessageBuilder(MessageBuilder::MSG_TYPE_REQUEST_USER_INFO);
        $msgBuilder->withUserId('user_id');

        $element = array(
            "title" => "OA Chatbot (Testing)",
            "subtitle" => "Äang yÃªu cáº§u thÃ´ng tin tá»« báº¡n",
            "image_url" => "https://stc-oa-chat-adm.zdn.vn/images/request-info-banner.png"
        );
        $msgBuilder->addElement($element);

        $msgText = $msgBuilder->build();

        // send request
        $response = $this->zalo->post(ZaloEndPoint::API_OA_SEND_CONSULTATION_MESSAGE_V3, $this->accessToken, $msgText);
        $result = $response->getDecodedBody();
        return $result;
    }
 }

?>