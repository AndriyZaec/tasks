<?php
/**
 * Created by PhpStorm.
 * User: andrij
 * Date: 10.07.15
 * Time: 9:37
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('SERVER','localhost');
define('USER','root');
define('PASS','785019');

class Env {
    /**
     * Returns an encrypted & utf8-encoded
     * @param $pure_string
     * @param $encryption_key
     * @return string
     */
    function encrypt($pure_string, $encryption_key="") {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }

    /**
     * Returns decrypted original string
     * @param $encrypted_string
     * @param $encryption_key
     * @return string
     */
    function decrypt($encrypted_string, $encryption_key="") {
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return $decrypted_string;
    }

    /**
     * Returns db result
     * @param $selectQuery
     * @return array|string
     */
    public function selectQuery($selectQuery){
        $rs = 'null';
        $conn = new mysqli(SERVER, USER, PASS);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $result = $conn->query($selectQuery);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rs=$row;
            }
        } else {
            $rs="data not found";
        }
        $conn->close();
        return $rs;
    }
}