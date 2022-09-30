<?php
/**
 * AdministrationApi
 * PHP version 5
 *
 * @category Class
 * @package  idcheckio
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * IdCheck.IO API
 *
 * Check identity documents
 *
 * OpenAPI spec version: 0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace idcheckio\api;

use \idcheckio\ApiClient;
use \idcheckio\ApiException;
use \idcheckio\Configuration;
use \idcheckio\ObjectSerializer;

/**
 * AdministrationApi Class Doc Comment
 *
 * @category Class
 * @package  idcheckio
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AdministrationApi
{
    /**
     * API Client
     *
     * @var \idcheckio\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \idcheckio\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\idcheckio\ApiClient $apiClient = null)
    {
        if ($apiClient === null) {
            $apiClient = new ApiClient();
        }

        $this->apiClient = $apiClient;
    }

    /**
     * Get API client
     *
     * @return \idcheckio\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \idcheckio\ApiClient $apiClient set the API client
     *
     * @return AdministrationApi
     */
    public function setApiClient(\idcheckio\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation getHealth
     *
     * HTTP GET health
     *
     * @throws \idcheckio\ApiException on non-2xx response
     * @return \idcheckio\model\HealthResponse
     */
    public function getHealth()
    {
        list($response) = $this->getHealthWithHttpInfo();
        return $response;
    }

    /**
     * Operation getHealthWithHttpInfo
     *
     * HTTP GET health
     *
     * @throws \idcheckio\ApiException on non-2xx response
     * @return array of \idcheckio\model\HealthResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getHealthWithHttpInfo()
    {
        // parse inputs
        $resourcePath = "/v0/admin/health";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/json; charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\idcheckio\model\HealthResponse',
                '/v0/admin/health'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\idcheckio\model\HealthResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\HealthResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\ErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 503:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\ErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation getUser
     *
     * HTTP GET user
     *
     * @param string $accept_language Accept language header (optional)
     * @throws \idcheckio\ApiException on non-2xx response
     * @return \idcheckio\model\UserResponse
     */
    public function getUser($accept_language = null)
    {
        list($response) = $this->getUserWithHttpInfo($accept_language);
        return $response;
    }

    /**
     * Operation getUserWithHttpInfo
     *
     * HTTP GET user
     *
     * @param string $accept_language Accept language header (optional)
     * @throws \idcheckio\ApiException on non-2xx response
     * @return array of \idcheckio\model\UserResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getUserWithHttpInfo($accept_language = null)
    {
        // parse inputs
        $resourcePath = "/v0/admin/user";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['application/json; charset=utf-8']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);

        // header params
        if ($accept_language !== null) {
            $headerParams['Accept-Language'] = $this->apiClient->getSerializer()->toHeaderValue($accept_language);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires HTTP basic authentication
        if (strlen($this->apiClient->getConfig()->getUsername()) !== 0 or strlen($this->apiClient->getConfig()->getPassword()) !== 0) {
            $headerParams['Authorization'] = 'Basic ' . base64_encode($this->apiClient->getConfig()->getUsername() . ":" . $this->apiClient->getConfig()->getPassword());
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\idcheckio\model\UserResponse',
                '/v0/admin/user'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\idcheckio\model\UserResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\UserResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\ErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\ErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\idcheckio\model\ErrorResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }
}
