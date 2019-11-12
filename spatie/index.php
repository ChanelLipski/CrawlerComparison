<?php
include("vendor/autoload.php");

use Spatie\Crawler\Crawler;
require_once "Testcrawler.php";
require_once "testprofile.php";




Crawler::create()
    ->setCrawlProfile(new Testprofile())
    ->setCrawlObserver(new Testcrawler())
    ->ignoreRobots()
    ->setUserAgent('Spongebob')
    ->setConcurrency(1)
    ->setDelayBetweenRequests(2000)
    #->setMaximumCrawlCount(3)
    ->setMaximumDepth(3)
    ->startCrawling("https://www.berlin.de/polizei/polizeimeldungen/archiv/");