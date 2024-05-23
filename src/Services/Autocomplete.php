<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\Services;

use NetBrothers\NbGoogleApiBundle\Services\Result\AutocompleteResult;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class Autocomplete extends AbstractGoogleApi
{
    public const DEFAULT_LANGUAGE = 'de';
    public const DEFAULT_SENSOR = 'false';
    public const DEFAULT_COMPONENTS = 'country:de';
    public const DEFAULT_OFFSET = 3;
    public const DEFAULT_RADIUS = 500;

    public const DEFAULT_LOCATION = '51.166667,10.45';

    /**
     * @var string lag,lng
     */
    private string $location = self::DEFAULT_LOCATION;

    /**
     * Radius
     */
    private int $radius = self::DEFAULT_RADIUS;

    /**
     * Input language
     */
    private string $language = self::DEFAULT_LANGUAGE;

    /**
     * Decides if the client has GPS
     *
     * @var string (true|false)
     */
    private string $sensor = self::DEFAULT_SENSOR;

    private int $offset = self::DEFAULT_OFFSET;

    private mixed $components = self::DEFAULT_COMPONENTS;

    /**
     * String to be searched for
     */
    private string $input;

    private UuidInterface|string $sessionToken;

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getRadius(): int
    {
        return $this->radius;
    }

    public function setRadius(int $radius): self
    {
        $this->radius = $radius;
        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function getComponents(): mixed
    {
        return $this->components;
    }

    public function setComponents(mixed $components): self
    {
        $this->components = $components;
        return $this;
    }

    public function getInput(): string
    {
        return $this->input;
    }

    public function setInput(string $input): self
    {
        $this->input = $input;
        return $this;
    }

    public function getSensor(): string
    {
        return $this->sensor;
    }

    public function setSensor(string $sensor): self
    {
        $this->sensor = $sensor;
        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function getSessionToken(): string
    {
        return $this->sessionToken;
    }

    public function setSessionToken(UuidInterface|string $sessionToken): static
    {
        $this->sessionToken = $sessionToken;
        return $this;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->setDefaults();
        $this->setConfig($config);
    }

    /**
     * Process a http request to googles autocomplete api.
     */
    public function processRequest(): Autocomplete
    {
        // get options array
        $options = get_object_vars($this);
        if (!isset($options['key'])) {
            $options['key'] = $this->config['key'];
        }

        // create http query string and process http request
        $queryString = $this->config['uri'] . $this->config['requestType'] . '?';
        if (!empty($options['input'])) {
            $options['offset'] = strlen($options['input']) - 1;
        }
        $options['input'] = rawurlencode($options['input']);
        foreach ($options as $key => $value) {
            if (!is_array($value) && !empty($value)) {
                $queryString .= $key . '=' . $value . '&';
            }
        }
        $queryString = rtrim($queryString, '&');
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $queryString);
        $this->result = new AutocompleteResult(json_decode($response->getContent()));
        return $this;
    }
}
