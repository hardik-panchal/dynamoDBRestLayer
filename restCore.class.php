<?php

/**
 * A core class for REST Layer
 * Contains all the function for authentication, communication with dynamodb
 * 
 * Class is being extended by other wrapper classes
 * 
 * @author Hardik Panchal<hardikpanchal469@gmail.com>
 * @since February 16, 2014
 * 
 */
class coreDyanmoDB {

    /**
     * User Credentials: Email
     * @var String $email
     */
    protected $email = "appemail@app.com";

    /**
     * User Credentails: Password
     * @var String $password
     */
    protected $password = "appPassword";

    /**
     * App Name at DynamoDB
     * @var String $appName 
     */
    protected $appName = "Tradimate";

    /**
     * URL Endpoint for dynamoDB
     * @var String $dunamoDBURL 
     */
    protected $dynamoDBURL = "http://ec2-xx-xxx-xx-xx.ap-southeast-2.compute.amazonaws.com:80/rest/";

    /**
     * App End Point.
     * Example: 'user/session'
     * 
     * @var String $appEndPoint
     */
    protected $appEndPoint = "";

    /**
     * App Session Token
     * 
     * @var String $appSessionToken
     */
    protected $appSessionToken = "";

    /**
     * REST Method: POST/GET/DELETE
     * Example: For Retrieve: GET
     * For Creating a record: POST
     * 
     * @var type String $appRESTMEthod
     */
    protected $appRESTMethod = "POST";

    /**
     * Params to hold various parameters to call dynamo db
     * @var type array $params 
     */
    protected $params = array();

    public function __construct() {
        return $this->doAuth();
    }

    /**
     * Authenticate with dynamoDb
     */
    public function doAuth() {

        $this->appEndPoint = "user/session";

        $this->params['email'] = $this->email;
        $this->params['password'] = $this->password;
        $this->params['appEndPoint'] = "user/session";

        $response = $this->doCallDynamoDB();
        $this->appSessionToken = $response['session_id'];
    }

    /**
     * Core function to communicate with dynamoDB
     * 
     * @return array
     */
    public function doCallDynamoDB() {
        $ch = curl_init();

        $headers = array("X-DreamFactory-Application-Name: {$this->appName}");

        // set session header if appSessionToken is set
        if ($this->appSessionToken) {
            $header[] = 'X-DreamFactory-Session-Token: ' . $this->appSessionToken;
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->appRESTMethod);
        curl_setopt($ch, CURLOPT_URL, $this->dynamoDBURL . $this->params['appEndPoint']);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->params));

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    /**
     * Get All tables from DynamoDB
     * @return Array
     */
    public function getAllTables() {
        $this->appEndPoint = "DynamoDB";
        return $this->doCallDynamoDB();
    }

}
