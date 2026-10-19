
<?php
use PHPUnit\Framework\TestCase;
use Zalo\Builder\MessageBuilder;
use Zalo\Common\TransactionTemplateType;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;
class ZaloSocialAPI{
    protected $accessToken = 'fGiCCkIgxYYj30mtwApeBgu83pNgjODHn6mp5jIdX6ENVXmskTYyQ9ry9Y7LY8PFvMfaClgOoNt_StiIoPB02uvLKNUfbVSwe3HdSAFLrYcKT55QXuJyHgTIGGA2i-PAkNXm8x_Ips2vCoeQ_UoBSzKG56RywxOhno48VOU3kIF0LrHSqfRs5Er2Rdlwuz42lJmtHAYOaIsFSWivgAkzSPDt1WIHhReGbdWx18owrtYeS5iSlANMO8fXU1skjEq7ZbrOSxsceIhzH3n7vvgh4S9SCdJXXDOFubbuKgIjvobnazGiuBRfA0';
    /**
     * @var Zalo
     */
    protected $zalo;

    function __construct(){
         $config = array(
            'app_id' => '3980813874004753450',
            'app_secret' => '4B52V2ARl5627KIMFKC6'
        );

        $this->zalo = new Zalo($config);
    }

    function GetUserProfileAPI(){
        $params = ['fields' => 'id,name,picture'];
        $response = $this->zalo->get(ZaloEndpoint::API_GRAPH_ME, $this->accessToken, $params);
        $result = $response->getDecodedBody();
        return $result;
    }
    
}
?>