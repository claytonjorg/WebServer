<?php
	function IDto64($steamId) 
	{
        $iServer = "0";
        $iAuthID = "0";
         
        $szTmp = strtok($steamId, ":");
         
        while(($szTmp = strtok(":")) !== false)
        {
            $szTmp2 = strtok(":");
            if($szTmp2 !== false)
            {
                $iServer = $szTmp;
                $iAuthID = $szTmp2;
            }
        }
        if($iAuthID == "0")
            return "0";
     
        $steamId64 = bcmul($iAuthID, "2");
        $steamId64 = bcadd($steamId64, bcadd("76561197960265728", $iServer));
            if (strpos($steamId64, ".")) 
			{
                $steamId64=strstr($steamId64,'.', true);
            }     
        return $steamId64;
    }
    
    ////Get STEAM_0:1:6656620 from 76561197973578969
    function IDfrom64($steamId64) 
	{
        $iServer = "1";
        if(bcmod($steamId64, "2") == "0") 
		{
            $iServer = "0";
        }
        $steamId64 = bcsub($steamId64,$iServer);
        if(bccomp("76561197960265728",$steamId64) == -1) 
		{
            $steamId64 = bcsub($steamId64,"76561197960265728");
        }
        $steamId64 = bcdiv($steamId64, "2");
        if (strpos($steamId64, ".")) 
		{
			$steamId64=strstr($steamId64,'.', true);
        }     
        return ("STEAM_1:" . $iServer . ":" . $steamId64);
    }
?>