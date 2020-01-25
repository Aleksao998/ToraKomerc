<?php
    class O3ON_API_Connector {
        private static $instance = NULL;
        private $token = NULL;

        public static function getInstance(){
            if(is_null(self::$instance)){
                self::$instance = new self();
                self::$instance->CallAPILogin();
            }
            return self::$instance;
        }

        private $apirooturl = 'http://api.promobay.net/';
        private $apiloginendpoint = 'Token';

        //login
        private $username = 'Torakomerc';
        private $password = 'ug27cxAUug27cxAU#';

        function CallAPILogin()
        {
          $data = "";

            //Example: 'https://apiv1.promosolution.services/Token';
            $url = $this->apirooturl . $this->apiloginendpoint;

            $data = array('grant_type' => 'password', 'username' => $this->username, 'password' => $this->password);

            //format data for the POST
            $fields_string="";
            foreach($data as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = json_decode(curl_exec($curl));

            curl_close($curl);
            //var_dump($result->token_type . ' ' . $result->access_token);
            $this->token = $result->token_type . ' ' . $result->access_token;
        }

        function CallAPI($apiname, $culture, $id = '')
        {
            //Example: 'https://apiv1.promosolution.services/sr-Latin-CS/api/Model/MASTER';
            $url = $this->apirooturl . $culture . '/' . 'api/' . $apiname . '/';

            if ($id != "")
            {
                $url .= '?id='.$id;
            }

            $curl = curl_init($url);

            $headr = array();
            $headr[] = 'Authorization: ' . $this->token;
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headr);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $result = json_decode(curl_exec($curl));

            curl_close($curl);

            return $result;
        }
    }
?>
