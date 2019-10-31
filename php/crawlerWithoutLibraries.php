<?php

$archivesUrl="https://www.berlin.de/polizei/polizeimeldungen/archiv/";
$rawPage=file_get_contents($archivesUrl);
preg_match_all('/archiv[\/](20\d{2,2})[\/]" t/', $rawPage, $years);



 foreach ($years[1] as $year)
 {
     sleep(1);
     $archivUrl="https://www.berlin.de/polizei/polizeimeldungen/archiv/".$year."/";
     $rawPage=file_get_contents($archivUrl);

     preg_match_all('/page_at_1_0=(\d{1,})"/', $rawPage, $pagination);

     $lastPage=$pagination[1][count($pagination[1])-2];

     for($i=1;$i<$lastPage;$i++)
     {
        sleep(1);
        $pageUrl="https://www.berlin.de/polizei/polizeimeldungen/archiv/2019/?page_at_1_0=".$i;
        $rawPage=file_get_contents($pageUrl);
        preg_match_all('/pressemitteilung.(\d{3,}).php/', $rawPage, $reportNumbers);
        foreach ($reportNumbers[1] as $reportNumber)
        {
            sleep(1);
            $reportUrl="https://www.berlin.de/polizei/polizeimeldungen/pressemitteilung.".$reportNumber.".php";
            $rawPage=file_get_contents($reportUrl);
            echo $rawPage;
            exit;
        }

     }

 }
