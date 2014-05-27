<?php
/**
 * @copyright 2014 Instaclick Inc.
 */

namespace IC\Bundle\Base\HadoopBundle\Service;

use Guzzle\Http\Message\Response;
use Guzzle\Http\Client;

/**
 * Hdfs Service
 *
 * @author Eldar Gafurov <eldarg@nationalfibre.net>
 */
class HdfsService
{
    /**
     * @var \Guzzle\Http\Client
     */
    private $client;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $username;

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Set client
     *
     * @param \Guzzle\Http\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set host
     *
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * Set port
     *
     * @param string $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Send curl request
     *
     * @param string $path
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function listStatus($path = null)
    {
        $request = $this->prepareRequest("listStatus", $path);

        return $request->send();
    }

    /**
     * Send curl request
     *
     * @param null|string $path
     * @param null|string $content
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function create($path = null, $content = null)
    {
        $requestDataNode = $this->prepareRequest("create", $path);
        $requestDataNode->getParams()->set('redirect.disable', true);

        $response   = $requestDataNode->send();
        $headerList = $response->getHeaders();

        $requestCreateFile = $this->client->createRequest(
            "PUT",
            (string) $headerList['location'],
            array('Content-type' => 'application/octet-stream'),
            $content
        );

        return $requestCreateFile->send();
    }

    /**
     * Send curl request
     *
     * @param null|string $path
     * @param null|string $content
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function append($path = null, $content = null)
    {
        $requestDataNode = $this->prepareRequest("append", $path);
        $requestDataNode->getParams()->set('redirect.disable', true);

        $response   = $requestDataNode->send();
        $headerList = $response->getHeaders();

        $requestAppendFile = $this->client->createRequest(
            "POST",
            (string) $headerList['location'],
            array('Content-type' => 'application/octet-stream'),
            $content
        );

        return $requestAppendFile->send();
    }

    /**
     * Send curl request
     *
     * @param string $path
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function mkdirs($path = null)
    {
        $request = $this->prepareRequest("mkdirs", $path);

        return $request->send();
    }

    /**
     * Send curl request
     *
     * @param string $path
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function open($path = null)
    {
        $request = $this->prepareRequest("open", $path);

        return $request->send();
    }

    /**
     * Send curl request
     *
     * @param string $path
     * @param string $pathTo
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function rename($path = null, $pathTo = null)
    {
        $request = $this->prepareRequest("rename", $path, array('destination' => $pathTo));

        return $request->send();
    }

    /**
     * Send curl request
     *
     * @param null|string $path
     * @param string      $recursive
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function delete($path = null, $recursive = 'true')
    {
        $request = $this->prepareRequest("delete", $path, array('recursive' => $recursive));

        return $request->send();
    }

    /**
     * Prepare request
     *
     * @param string $requestType
     * @param string $path
     * @param array  $optionList
     *
     * @return string
     */
    private function prepareRequest($requestType, $path, $optionList = array())
    {
        $request = $this->client->createRequest($this->getHttpMethodType($requestType), $this->generateUrl($path));
        $query   = $request->getQuery();

        $query->set('op', strtoupper($requestType));
        $query->set('user.name', $this->getUsername());

        foreach ($optionList as $optionKey => $optionValue) {
            $query->set($optionKey, $optionValue);
        }

        return $request;
    }

    /**
     * Generate url
     *
     * @param string $path
     *
     * @return string
     */
    private function generateUrl($path)
    {
        return sprintf(
            "http://%s:%s%s%s",
            $this->host,
            $this->port,
            $this->path,
            $path
        );
    }

    /**
     * Get HTTP method type
     *
     * @param string $requestType
     *
     * @return string
     */
    private function getHttpMethodType($requestType)
    {
        $methodList = array(
            'listStatus' => 'GET',
            'create'     => 'PUT',
            'append'     => 'POST',
            'mkdirs'     => 'PUT',
            'open'       => 'GET',
            'rename'     => 'PUT',
            'delete'     => 'DELETE',
        );

        return isset($methodList[$requestType]) ? $methodList[$requestType] : null;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
}
