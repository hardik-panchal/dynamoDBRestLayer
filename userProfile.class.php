<?php

/**
 * Wrapper function to interact with dynamoDB
 *
 * @author Hardik Panchal<hardikpanchal469@gmail.com>
 * @since February 16, 2014
 */
class userProfile extends coreDyanmoDB {

    public $dbFields = array();

    public function __construct() {
        parent::__construct();
        $this->prepareFields();
        $this->appEndPoint = "user";
    }

    /**
     * Signature function for DB Fields
     * This will follow as stackMob pattern
     * 
     */
    public function prepareFields() {
        $this->dbFields['companyid'] = "";
        $this->dbFields['username'] = "";
        $this->dbFields['password'] = "";
        $this->dbFields['account_status'] = "";
        $this->dbFields['emailaddress'] = "";
        $this->dbFields['firstname'] = "";
        $this->dbFields['surname'] = "";
        $this->dbFields['invoice_terms_days'] = "";
        $this->dbFields['quote_terms_days'] = "";
        $this->dbFields['account_enddate'] = "";
        $this->dbFields['createddate'] = "";
        $this->dbFields['company_name'] = "";
        $this->dbFields['company_abn'] = "";
        $this->dbFields['company_acn'] = "";
        $this->dbFields['company_suburb'] = "";
        $this->dbFields['company_postcode'] = "";
        $this->dbFields['company_state'] = "";
        $this->dbFields['company_acn'] = "";
        $this->dbFields['company_BSB'] = "";
        $this->dbFields['company_acctnumber'] = "";
        $this->dbFields['company_mobilephone'] = "";
        $this->dbFields['company_acctname'] = "";
    }

    /**
     * Create User At DynamoDB
     * 
     * @return Array
     */
    public function createUser() {
        $this->params = $this->dbFields;
        $this->appRESTMethod = "POST";
        return $this->doCallDynamoDB();
    }

    /**
     * Retrieve User from DynamoDB
     * 
     * @return Array
     */
    public function getUsers() {
        $this->appRESTMethod = "GET";
        return $this->doCallDynamoDB();
    }

    /**
     * Update User at DynamoDB
     * @param type $userName
     * @return Array
     */
    public function updateUser($userName) {
        $this->appRESTMethod = "PATCH";
        $this->params = $this->dbFields;
        $this->appEndPoint .= "?ids={$userName}";
        return $this->doCallDynamoDB();
    }

}

/**
 * Demo of REST  Layer
 */
# Get Users
$userDB = new userProfile();
$user = $userDB->getUsers();

# Create  User
$userDB->dbFields = array("companyid" => $inputCompanyID,
    "username" => $inputUsername,
    "password" => $inputPassword,
    "account_status" => $inputAccountStatus,
    "account_type" => $inputAccountType,
    "emailaddress" => $inpuEmailAddress,
    "firstname" => $inputFirstname,
    "surname" => $inputSurname,
    "invoice_terms_days" => $inputInvoiceTerms,
    "quote_terms_days" => $inputQuoteTerms,
    "account_enddate" => 0,
    "createddate" => $currentTime);
$userDB->createUser();