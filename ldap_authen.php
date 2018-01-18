<?php
function ldap_authen($server,$base_dn,$useraccount,$password){

    $ldapserver = ldap_connect($server);
    // If Server Ldap Version=3
    ldap_set_option($ldapserver,LDAP_OPT_PROTOCOL_VERSION,3);
    ldap_set_option($ldapserver, LDAP_OPT_TIMELIMIT, 6);
    $bind = @ldap_bind($ldapserver);
    $authen = true;
    if(!$bind) return false;
    $filter = "uid=" . $useraccount;
    $inforequired = array("uid");
    $result = @ldap_search($ldapserver,$base_dn,$filter,$inforequired);
    $info = @ldap_get_entries($ldapserver,$result);
    if(!$result)
    {
        $authen = false;
    }
	//Count = 1, True 		<- found account
	//Count = 0,>1 False 	<- not found account or found more than 1 account 
    if($info["count"] == 0)
    {
        $authen = false;
    }
    if($info["count"] > 1)
    {
        $authen = false;
    }
	if(isset($info[0]["dn"])){
  	  	$user_dn = $info[0]["dn"];
	}else{
		$user_dn = "";
	}
	//use dn for authen with password
    $bind = @ldap_bind($ldapserver,$user_dn,$password);
    if(!$bind)
    {
        $authen = false;
    }

    ldap_close($ldapserver);

    return($authen);
}

function ldap_authen_ku_bkn($useraccount,$password) {
    return ldap_authen("ldap.ku.ac.th","ou=bkn,dc=ku,dc=ac,dc=th",$useraccount,$password);
}
?>

