<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\Services\Result;

class AutocompleteResult extends AbstractResult
{

    public function __construct(?\stdClass $response = null)
    {
        if ($response !== null) {
            $this->setResponseData($response);
            $this->setStatus($response);
        }
    }

    /**
     * Parsing the response
     */
    public function setResponseData(\stdClass $responseData): static
    {
        $resultResponseData = [];
        $predictions = $responseData->predictions;

        foreach ($predictions as $prediction) {
            $predictionData = [];
            $predictionData['description'] = $prediction->description;
            $predictionData['placeId'] = (isset($prediction->place_id)) ? $prediction->place_id : null;
            $resultResponseData[] = $predictionData;
        }
        $this->responseData = $resultResponseData;
        return $this;
    }

    /**
     * Setter for status
     */
    public function setStatus(\stdClass $responseData): static
    {
        $this->status = $responseData->status;
        return $this;
    }
}
