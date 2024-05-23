<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\Services\Result;

abstract class AbstractResult
{
    /**
     * @var array<mixed> Response data parsed into array
     */
    protected array $responseData;

    /**
     * Statuscode returned by google api
     */
    protected string $status;

    /**
     * Getter for response data
     * @return array<mixed>
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }

    /**
     * Getter for status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * To jso converter
     * Supporting jsonp callback
     */
    public function toJson(string $jsonp = ''): string
    {
        $resultArray = [];
        $resultArray['status'] = $this->status;
        $resultArray['result'] = $this->responseData;
        if (empty($jsonp)) {
            $result = json_encode($resultArray);
        } else {
            $result = $jsonp . '(' . json_encode($resultArray) . ');';
        }
        return $result;
    }
}
