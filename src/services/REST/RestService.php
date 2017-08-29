<?php

namespace denbora\R_T_G_Services\services\REST;

use denbora\R_T_G_Services\R_T_G_ServiceException;
use denbora\R_T_G_Services\responses\RestResponse;
use denbora\R_T_G_Services\validators\ValidatorInterface;
use Httpful\Request;

class RestService implements RestServiceInterface
{
    private $certificate;
    private $key;
    private $password;
    protected $validator;
    private $response;
    protected $baseUrl;

    public function __construct(
        string $certificate,
        string $key,
        string $password,
        ValidatorInterface $validator,
        RestResponse $response,
        string $baseUrl
    ) {
        $this->certificate = $certificate;
        $this->key = $key;
        $this->password = $password;
        $this->validator = $validator;
        $this->response = $response;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param string $url
     * @return mixed
     * @throws R_T_G_ServiceException
     */
    public function get(string $url)
    {
        try {
            $response = Request::get($url)
                ->authenticateWithCert($this->certificate, $this->key, $this->password)
                ->send();

            $result = $this->response->getContent($response);

            return $result;
        } catch (\Exception $e) {
            $errorPrefix = 'Error in ' . __FUNCTION__ . ' - ';
            throw new R_T_G_ServiceException($errorPrefix . $e->getMessage());
        }
    }

    /**
     * @param string $url
     * @param string $data
     * @return mixed
     * @throws R_T_G_ServiceException
     */
    public function post(string $url, $data = '')
    {
        try {
            $response = Request::post($url)
                ->authenticateWithCert($this->certificate, $this->key, $this->password)
                ->sendsJSON()
                ->body($data)
                ->send();

            $result = $this->response->getContent($response);

            return $result;
        } catch (\Exception $e) {
            $errorPrefix = 'Error in ' . __FUNCTION__ . ' - ';
            throw new R_T_G_ServiceException($errorPrefix . $e->getMessage());
        }
    }

    /**
     * @param string $url
     * @param string $data
     * @return mixed
     * @throws R_T_G_ServiceException
     */
    public function put(string $url, $data = '')
    {
        try {
            $response = Request::put($url)
                ->authenticateWithCert($this->certificate, $this->key, $this->password)
                ->body($data)
                ->send();

            $result = $this->response->getContent($response);

            return $result;
        } catch (\Exception $e) {
            $errorPrefix = 'Error in ' . __FUNCTION__ . ' - ';
            throw new R_T_G_ServiceException($errorPrefix . $e->getMessage());
        }
    }

    /**
     * @param string $url
     * @param string $data
     * @return mixed
     */
    public function delete(string $url, $data = '')
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param object $request
     * @return string
     */
    protected function toUrlFormat($request)
    {
        $partUrl = '';
        $i = 0;
        foreach ($request as $key => $value) {
            if ($i == 0) {
                $partUrl .= '?' . $key . '=' . $value;
            } else {
                $partUrl .= '&' . $key . '=' . $value;
            }
            $i++;
        }
        return $partUrl;
    }

    /**
     * @param string $query
     * @param string $serviceApiUrl
     * @param null $pathParams
     * @param null $queryParams
     * @param string $endpoint
     * @return string
     * @internal param array|null $inlineParams
     */
    protected function createFullUrl(
        string $query,
        string $serviceApiUrl,
        $pathParams = null,
        $queryParams = null,
        string $endpoint = ''
    ) {
        if ($query != '') {
            $path = '';
            $queryData = '';
            $url = $this->baseUrl . $serviceApiUrl;
            $queryObject = json_decode($query);
            if (is_array($pathParams)) {
                foreach ($pathParams as $value) {
                    if (property_exists($queryObject, $value)) {
                        $path .= $queryObject->$value . '/';
                        unset($queryObject->$value);
                    }
                }
            }

            if (is_array($queryParams)) {
                $i = 0;
                foreach ($queryParams as $key => $value) {
                    if (property_exists($queryObject, $value)) {
                        if ($i == 0) {
                            $queryData .= '?' . $key . '=' . $value;
                        } else {
                            $queryData .= '&' . $key . '=' . $value;
                        }

                        $queryData .= $queryObject->$value . '/';
                        unset($queryObject->$value);
                    }
                    $i++;
                }
            }

            if ($path != '') {
                $url .= '/' . $path;
                if ($endpoint != '') {
                    $url .= $endpoint;
                }
            }
            $url .= $queryData;
        } else {
            $url = $this->baseUrl . $serviceApiUrl;

            if ($endpoint != '') {
                $url .= '/' . $endpoint;
            }
        }
        return $url;
    }
}
