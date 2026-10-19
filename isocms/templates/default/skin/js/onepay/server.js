//TODO Execute on server =======================================================================================
//var vpc_AccessCode = "6BEB2546"; //Your AccessCode
//var vpc_Merchant = "TESTONEPAY"; //Your MerchantID
//var secret = "6D0870CDE5F24F34F3915FB0045120DB";//For merchant id TESTONEPAY
var secrets = {
    "TESTONEPAY": "6D0870CDE5F24F34F3915FB0045120DB",
    "TESTAMWAY1": "56E8513033E49FEC8CA1D10D6D1FA010",
    "TESTAMWAY2": "F87B9AB93548076755177734BC29EDB1"
};

var accessCodes = {
    "TESTONEPAY": "6BEB2546",
    "TESTAMWAY1": "E11596A9",
    "TESTAMWAY2": "A5A62B9F"
};

function createLookupParamsOnServer(vpc_Merchant, vpc_Customer_Id, vpc_TokenNum, vpc_TokenExp) {
    var vpc_AccessCode = accessCodes[vpc_Merchant];
    var secret = secrets[vpc_Merchant];
    var vpc_Command = "lookup";
    var vpc_MerchTxnRef = "LOOKUP_" + (new Date().getTime()); //Unique for txn
    var stringToHash =
        "vpc_AccessCode=" + vpc_AccessCode
        + "&vpc_Command=" + vpc_Command
        + "&vpc_Customer_Id=" + vpc_Customer_Id
        + "&vpc_MerchTxnRef=" + vpc_MerchTxnRef
        + "&vpc_Merchant=" + vpc_Merchant
        + "&vpc_TokenExp=" + vpc_TokenExp
        + "&vpc_TokenNum=" + vpc_TokenNum;

    var vpc_SecureHash = CryptoJS.HmacSHA256(stringToHash, CryptoJS.enc.Hex.parse(secret)).toString(CryptoJS.enc.Hex);
    return "vpc_AccessCode=" + vpc_AccessCode
        + "&vpc_Command=" + vpc_Command
        + "&vpc_Customer_Id=" + vpc_Customer_Id
        + "&vpc_MerchTxnRef=" + vpc_MerchTxnRef
        + "&vpc_Merchant=" + vpc_Merchant
        + "&vpc_TokenExp=" + vpc_TokenExp
        + "&vpc_TokenNum=" + vpc_TokenNum
        + "&vpc_SecureHash=" + vpc_SecureHash;
}

function createOrderOnServer(vpc_Merchant, vpc_OrderInfo, vpc_Locale, vpc_Amount, vpc_Customer_Phone, vpc_Customer_Email, vpc_Customer_Id, vpc_CreateToken, vpc_TokenNum, vpc_TokenExp, vpc_VerType) {
    var vpc_AccessCode = accessCodes[vpc_Merchant];
    var secret = secrets[vpc_Merchant];
    var AgainLink = "https://mtf.onepay.vn/client/qt/";
    var Title = "VPC 3-Party";
    var user_MerchantDefinedField = "Merchant Defined Field";
    var vpc_Command = "pay";
    var vpc_Version = "2";
    var vpc_ReturnURL = "https://mtf.onepay.vn/client/qt/dr/?mode=TEST"; //Your return URL
    var vpc_TicketNo = "127.0.0.1";//Client IP
    var vpc_MerchTxnRef = "TEST_" + (new Date().getTime()); //Unique for txn

    var stringToHash =
        "user_MerchantDefinedField=" + user_MerchantDefinedField
        + "&vpc_AccessCode=" + vpc_AccessCode
        + "&vpc_Amount=" + vpc_Amount
        + "&vpc_Command=" + vpc_Command
        + (vpc_CreateToken !== "" ? "&vpc_CreateToken=" + vpc_CreateToken : "")
        + "&vpc_Customer_Email=" + vpc_Customer_Email
        + "&vpc_Customer_Id=" + vpc_Customer_Id
        + "&vpc_Customer_Phone=" + vpc_Customer_Phone
        + "&vpc_Locale=" + vpc_Locale
        + "&vpc_MerchTxnRef=" + vpc_MerchTxnRef
        + "&vpc_Merchant=" + vpc_Merchant
        + "&vpc_OrderInfo=" + vpc_OrderInfo
        + "&vpc_ReturnURL=" + vpc_ReturnURL
        + "&vpc_TicketNo=" + vpc_TicketNo
        + (vpc_TokenExp !== "" ? "&vpc_TokenExp=" + vpc_TokenExp : "")
        + (vpc_TokenNum !== "" ? "&vpc_TokenNum=" + vpc_TokenNum : "")
        + (vpc_VerType !== "" ? "&vpc_VerType=" + vpc_VerType : "")
        + "&vpc_Version=" + vpc_Version;

    var vpc_SecureHash = CryptoJS.HmacSHA256(stringToHash, CryptoJS.enc.Hex.parse(secret)).toString(CryptoJS.enc.Hex);

    console.log("StringToHash: " + stringToHash + ", vpc_SecureHash: " + vpc_SecureHash);
    var order = {
        "AgainLink": AgainLink,
        "Title": Title,
        "user_MerchantDefinedField": user_MerchantDefinedField,
        "vpc_Version": vpc_Version,
        "vpc_Command": vpc_Command,
        "vpc_AccessCode": vpc_AccessCode,
        "vpc_MerchTxnRef": vpc_MerchTxnRef,
        "vpc_Merchant": vpc_Merchant,
        "vpc_OrderInfo": vpc_OrderInfo,
        "vpc_ReturnURL": vpc_ReturnURL,
        "vpc_Locale": vpc_Locale,
        "vpc_TicketNo": vpc_TicketNo,
        "vpc_Amount": vpc_Amount,        
        "vpc_Customer_Phone": vpc_Customer_Phone,
        "vpc_Customer_Email": vpc_Customer_Email,
        "vpc_Customer_Id": vpc_Customer_Id,
        "vpc_SecureHash": vpc_SecureHash
    };
	console.log(order);

    if (vpc_CreateToken !== "") order["vpc_CreateToken"] = vpc_CreateToken;
    if (vpc_TokenNum !== "") order["vpc_TokenNum"] = vpc_TokenNum;
    if (vpc_TokenExp !== "") order["vpc_TokenExp"] = vpc_TokenExp;
    if (vpc_VerType !== "") order["vpc_VerType"] = vpc_VerType;

    return order;
}

