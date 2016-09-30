<?php

namespace yeesoft\comments\components;

use yii\helpers\Url;
use TijsVerkoyen\Akismet\Akismet as AkismetAPI;

class Akismet extends \yii\base\Component
{

    /** @var string Akismet API key */
    public $apiKey;

    /** @var \TijsVerkoyen\Akismet\Akismet Akismet instance */
    private $_akismet;

    public function init()
    {
        if (!$this->_akismet instanceof AkismetAPI) {
            $akismet = new AkismetAPI($this->apiKey, Url::base(true));

            if (!$akismet->verifyKey()) {
                throw new \yii\base\InvalidConfigException('Invalid Akismet API key.');
            }

            $this->_akismet = $akismet;
        }
    }

    /**
     * Check if the comment is spam or not.
     * 
     * @param string $content The content that was submitted.
     * @param string $author The author name.
     * @param string $email The author email address.
     * @param string $url The URL.
     * @param string $permalink The permanent location of the entry the comment was submitted to.
     * @param string $type The type, can be blank, comment, trackback, pingback, or a made up.
     * 
     * @return bool If the comment is spam true will be returned, otherwise false.
     */
    public function isSpam($content, $author = null, $email = null, $url = null, $permalink = null, $type = null)
    {
        return $this->_akismet->isSpam($content, $author, $email, $url, $permalink, $type);
    }

    /**
     * Submit ham to Akismet. This call is intended for the marking of false positives, 
     * things that were incorrectly marked as spam.
     * 
     * @param string $userIp The address of the comment submitter.
     * @param string $userAgent The agent information.
     * @param string $content The content that was submitted.
     * @param string $author The name of the author.
     * @param string $email The email address.
     * @param string $url The URL.
     * @param string $permalink The permanent location of the entry the comment was submitted to.
     * @param string $type The type, can be blank, comment, trackback, pingback, or a made up value like "registration".
     * @param string $referrer The content of the HTTP_REFERER header should be sent here.
     * @param array $others Extra data (the variables from $_SERVER).
     * 
     * @return bool If everything went fine true will be returned, otherwise an exception will be triggered.
     */
    public function submitHam($userIp, $userAgent, $content, $author = null, $email = null, $url = null, $permalink = null, $type = null, $referrer = null, $others = null)
    {
        return $this->_akismet->submitHam($userIp, $userAgent, $content, $author, $email, $url, $permalink, $type, $referrer);
    }

    /**
     * Submit spam to Akismet. This call is for submitting comments that weren't 
     * marked as spam but should have been.
     * 
     * @param string $userIp The address of the comment submitter.
     * @param string $userAgent The agent information.
     * @param string $content The content that was submitted.
     * @param string $author The name of the author.
     * @param string $email The email address.
     * @param string $url The URL.
     * @param string $permalink The permanent location of the entry the comment was submitted to.
     * @param string $type The type, can be blank, comment, trackback, pingback, or a made up value like "registration".
     * @param string $referrer The content of the HTTP_REFERER header should be sent here.
     * @param string $others Extra data (the variables from $_SERVER).
     * 
     * @return bool If everything went fine true will be returned, otherwise an exception will be triggered.
     */
    public function submitSpam($userIp, $userAgent, $content, $author = null, $email = null, $url = null, $permalink = null, $type = null, $referrer = null, $others = null)
    {
        return $this->_akismet->submitSpam($userIp, $userAgent, $content, $author, $email, $url, $permalink, $type, $referrer);
    }

}
