<?php
if(pg_pconnect('host=140.123.30.13 port=5432 dbname=personneldb user=ccumis password=!misdbadmin@ccu')==false){
    echo "Connect Profession Database Error!!";
}
?>