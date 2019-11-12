<?php

use Spatie\Crawler\Url;
use Spatie\Crawler\CrawlProfile;

class Testprofile extends CrawlProfile
{

    public function shouldCrawl(Psr\Http\Message\UriInterface $url):bool {

        $whitelist=array("https://www.berlin.de/polizei/polizeimeldungen/pressemitteilung","https://www.berlin.de/polizei/polizeimeldungen/archiv/");
        return (str_replace($whitelist,"",$url) !=$url);


    }
}