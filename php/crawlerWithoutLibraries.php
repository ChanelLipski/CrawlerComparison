<?php
$mysqli = new mysqli("db.f4.htw-berlin.de", "s0557964", "", "_s0557964__suchmaschine");
$domain="https://www.berlin.de/";
$archivesUrl=$domain."polizei/polizeimeldungen/archiv/";
$rawPage=file_get_contents($archivesUrl);
$maxDocs=5;
$counterDocs=0;
preg_match_all('/archiv[\/](20\d{2,2})[\/]" t/', $rawPage, $years);

 foreach ($years[1] as $year)
 {
     sleep(1);
     $archivUrl=$domain."polizei/polizeimeldungen/archiv/".$year."/";
     $rawPage=file_get_contents($archivUrl);

     preg_match_all('/page_at_1_0=(\d{1,})"/', $rawPage, $pagination);

     $lastPage=$pagination[1][count($pagination[1])-2];
     echo "Year: ".$year."\n";
     for($i=1;$i<$lastPage;$i++)
     {
        sleep(1);
        $pageUrl=$domain."polizei/polizeimeldungen/archiv/2019/?page_at_1_0=".$i;
        $rawPage=file_get_contents($pageUrl);
        preg_match_all('/pressemitteilung.(\d{3,}).php/', $rawPage, $reportNumbers);
         echo "     Pages:".$i."/".$lastPage."\n";
        foreach ($reportNumbers[1] as $reportNumber)
        {

            sleep(1);
            $uri="polizei/polizeimeldungen/pressemitteilung.".$reportNumber.".php";
            $reportUrl=$domain.$uri;
            $document=file_get_contents($reportUrl);
            $document=$mysqli->real_escape_string($document );
            $query = "INSERT INTO Downloaded (document,domain,uri) VALUES ('$document','$domain','$uri')";
            $mysqli->query($query);

            echo "          Report:".$reportNumber."\n";
            $counterDocs++;
            if($counterDocs>= $maxDocs){ $mysqli->close(); exit;}
            sleep(1);
        }

     }

 }
$mysqli->close();