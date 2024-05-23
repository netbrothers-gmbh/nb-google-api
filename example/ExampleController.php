<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace App\Controller;

use NetBrothers\NbGoogleApiBundle\Services\Autocomplete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExampleController extends AbstractController
{
    public function __construct(
        private readonly Autocomplete $googleAutocompleteService
    ) {
    }

    /** Fetching data from Google
     *  url like "?query=[USER_INPUT]&sessionToken=[sessionToken]
     *
     */
    public function getGoogleAutocompleteResponse(Request $request): JsonResponse
    {
        $searchValue = $request->query->get('query', '');
        if (empty($searchValue)) {
            return $this->json([]);
        }
        $sessionToken = $request->query->get('sessionToken', '');
        $result = $this->googleAutocompleteService
            ->setInput($searchValue)
            ->setSessionToken($sessionToken)
            ->processRequest()
            ->getResult()
            ->getResponseData()
        ;
        $data = [];
        foreach ($result as $item) {
            $data[] = [
                'id' => $item['placeId'],
                'name' => $item['description'],
            ];
        }
        return $this->json($data);
    }

    public function newSessionToken(): JsonResponse
    {
        return $this->json(['data' => $this->googleAutocompleteService->generateSessionToken()]);
    }

}
