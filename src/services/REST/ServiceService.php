<?php

namespace denbora\R_T_G_Services\services\REST;

class ServiceService extends RestService
{
    /**
     * First part in url after /api/
     */
    const APIURL = 'service';

    /**
     * @param $query
     * @param null $array
     * @param string $endpoint
     * @return mixed
     * @throws \denbora\R_T_G_Services\R_T_G_ServiceException
     */
    private function callGet($query, $array = null, $endpoint = '')
    {
        if ($query != '' || $this->validator->call('validate', $query)) {
            return $this->get($this->createGetFullUrl($query, self::APIURL, $array, $endpoint));
        }
    }

    /**
     * @param string $query
     * @return mixed
     * @throws \denbora\R_T_G_Services\R_T_G_ServiceException
     */
    public function getTypes($query = '')
    {
        return $this->callGet($query, '', 'types');
    }

    /**
     * @param string $query
     * @return mixed
     * @throws \denbora\R_T_G_Services\R_T_G_ServiceException
     */
    public function getStatuses($query = '')
    {
        return $this->callGet($query, '', 'statuses');
    }

    /**
     * @param string $query
     * @return mixed
     * @throws \denbora\R_T_G_Services\R_T_G_ServiceException
     */
    public function getCategories($query = '')
    {
        return $this->callGet($query, '', 'categories');
    }

    /**
     * @param string $query
     * @return mixed
     * @throws \denbora\R_T_G_Services\R_T_G_ServiceException
     */
    public function postComments($query = '')
    {
        if ($query != '' || $this->validator->call('validate', $query)) {
            return $this->post(
                $this->createFullUrl($query, self::APIURL, '', 'comments'),
                $query
            );
        }
    }

    public function postDownloadId($query = '')
    {
        if ($query != '' || $this->validator->call('validate', $query)) {
            return $this->post(
                $this->createFullUrl($query, self::APIURL, '', 'download-id'),
                $query
            );
        }
    }

    public function getDownloads($query = '')
    {
        if ($query != '' || $this->validator->call('validate', $query)) {
            return $this->callGet($query, '', 'downloads');
        }
    }

    public function getCurrencies($query = '')
    {
        if ($query == '') {
            return $this->callGet($query, '', 'currencies');
        }
    }
}
