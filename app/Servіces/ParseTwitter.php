<?php

namespace App\Services;

use GuzzleHttp\Client;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ParseTwitter
{
    public function getParseResult($userID)
    {
        $result = [];
        $this->getPageHTML($userID);
        $result['name'] = $this->getName($userID);
        $result['description'] = $this->getDescription($userID);
        $result['twitterId'] = $this->getTwitterId($userID);
        $result['followers'] = $this->getFollowers($userID);
        $result['following'] = $this->getFollowing($userID);
        $result['likes'] = $this->getLikes($userID);
        $result['photo'] = $this->getPhoto($userID);
        $result['tweets'] = $this->getTweets($userID);

        return $result;

    }

    protected function getPageHTML($userId)
    {

        if (!isset($userId)) {
            return false;
        }
        try {
            $url = 'https://twitter.com/' . $userId;
            $client = new Client(['header' => ['content-type' => 'text/html']]);
            $response = $client->request('GET', $url);
            $contents = trim((string)$response->getBody());
            $htmlDom = str_replace("\n", ' ', str_replace("\r\n", "\n", $contents));
            Storage::disk('local')->put($userId . '.txt', $htmlDom);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }

    }

    protected function loadingHtml($htmlDom)
    {
        if ($htmlDom) {

            $dom = new DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($htmlDom);
            libxml_clear_errors();

            return $dom;
        } else {
            return null;
        }

    }

    protected function isFileExists($userId)
    {
        if (Storage::disk('local')->exists($userId . '.txt')) {
            return true;
        } else {
            return false;
        }
    }

    protected function getHtmlDom($userId)
    {
        if (isset($userId)) {
            $htmlDom = Storage::get($userId . '.txt');
            return $htmlDom;
        } else {
            return false;
        }

    }


    protected function getName($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);

                $item = $xpath->query('//*[@class="ProfileHeaderCard-nameLink u-textInheritColor js-nav"]')->item(0);
                $name = $item->textContent;

                return $name;

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    protected function getTwitterId($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);

                $item = $xpath->query('//*[@class="ProfileHeaderCard-screenname u-inlineBlock u-dir"]')->item(0);
                $twitterId = trim($item->textContent);

                return $twitterId;

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    protected function getDescription($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);

                $item = $xpath->query('//*[@class="ProfileHeaderCard-bio u-dir"]')->item(0);

                $description = $item->textContent;

                return $description;

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    protected function getLikes($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);
                $item = $xpath->query('///li[@class="ProfileNav-item ProfileNav-item--favorites"]//a/span[@class="ProfileNav-value"]')->item(0);

                if($item!=null){
                    $likes = $item->getAttribute('data-count');
                    return $likes;
                }else{
                    return 0;
                }




            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }


    }

    protected function getTweets($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);
                $item = $xpath->query('///li[@class="ProfileNav-item ProfileNav-item--tweets is-active"]//a/span[@class="ProfileNav-value"]')->item(0);

                if($item!=null){
                    $tweets = $item->getAttribute('data-count');
                    return $tweets;
                }else{
                    return 0;
                }


            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }


    protected function getFollowers($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);
                $item = $xpath->query('///li[@class="ProfileNav-item ProfileNav-item--followers"]//a/span[@class="ProfileNav-value"]')->item(0);

                if($item!=null){
                    $followers = $item->getAttribute('data-count');
                    return $followers;
                }else{
                    return 0;
                }

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    protected function getFollowing($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);
                $item = $xpath->query('///li[@class="ProfileNav-item ProfileNav-item--following"]//a/span[@class="ProfileNav-value"]')->item(0);

                if($item !=null){
                    $following = $item->getAttribute('data-count');
                    return $following;
                }
                return 0;

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }


    protected function getPhoto($userId)
    {
        try {
            if ($this->isFileExists($userId)) {

                $htmlDom = $this->getHtmlDom($userId);
                $dom = $this->loadingHtml($htmlDom);

                $xpath = new DomXpath($dom);
                $item = $xpath->query('//*[@class="ProfileAvatar-container u-block js-tooltip profile-picture"]')->item(0);

                $imgLink = $item->getAttribute('href');

                $url = $this->saveImage($imgLink);


                return $url;

            } else {
                return null;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    protected function saveImage($imgLink)
    {
        if ($imgLink) {
            $contents = file_get_contents($imgLink);
            $name = substr($imgLink, strrpos($imgLink, '/') + 1);
            Storage::put('public/img/' . $name, $contents);
            //$url = public_path().'/storage/img/'.$name;
            $url = $name;
            return $url;
        } else {
            return null;
        }

    }


}