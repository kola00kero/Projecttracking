<?php 

function encryptIt( $q ) {
    $cryptKey = 'S2FzZXRzYXJ0IFVuaXZlcnNpdHk=';
    $qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

function decryptIt( $q ) {
    $cryptKey  = 'S2FzZXRzYXJ0IFVuaXZlcnNpdHk=';
    $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}

?>