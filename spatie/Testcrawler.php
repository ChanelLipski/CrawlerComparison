<?php


use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObserver;


class Testcrawler extends \Spatie\Crawler\CrawlObserver
{
    private $pages =[];

    public function willCrawl(UriInterface $uri) {
        echo "Now crawling: " . (string) $uri . PHP_EOL;
        $pages[]=$uri;
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null)
    {



        if (str_replace("https://www.berlin.de/polizei/polizeimeldungen/pressemitteilung","",$url) !=$url){

            $mysqli = new mysqli("", "", "", "");
            $domain="https://www.berlin.de/";
            $string =  (string)  $response->getBody();

            $document=$mysqli->real_escape_string( $string  );
            $query = "INSERT INTO Downloaded (document,domain,uri) VALUES ('$document','$domain','$url')";
            $mysqli->query($query);
            $mysqli->close();
            echo "Page saved.\n";
        }




    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param \Psr\Http\Message\UriInterface $url
     * @param \GuzzleHttp\Exception\RequestException $requestException
     * @param \Psr\Http\Message\UriInterface|null $foundOnUrl
     */
    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null)
    {
        echo 'failed';
    }

    public function finishedCrawling()
    {
        echo 'crawled ' . count($this->pages) . ' urls' . PHP_EOL;
        foreach ($this->pages as $page){
            echo sprintf("Url  path: %s Page title: %s%s", $page['path'], $page['title'], PHP_EOL);
        }
    }


}