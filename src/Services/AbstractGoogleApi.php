<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\Services;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class AbstractGoogleApi
{

    /** @var array<string,mixed> */
    protected array $config = [];

    protected ?string $jsonp = null;

    protected mixed $result = null;

    /**
     * Abstract function to process the http request to google api.
     */
    abstract public function processRequest(): mixed;

    /**
     * @param array<string,mixed> $config
     */
    public function setConfig(array $config): static
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return array<string,mixed>
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    public function setJsonp(string $jsonp): static
    {
        $this->jsonp = $jsonp;
        return $this;
    }

    public function getJsonp(): ?string
    {
        return $this->jsonp;
    }

    public function setResult(mixed $result): static
    {
        $this->result = $result;
        return $this;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * Array of parameters for generating query uri
     *
     * @param array<mixed>|null $parameters array with parameters
     */
    public function setParameters(?array $parameters = null): static
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $method = 'set' . ucfirst($key);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }
        return $this;
    }

    /**
     * Set default settings
     */
    public function setDefaults(): void
    {
        $reflect = new \ReflectionClass(get_class($this));
        $constants = $reflect->getConstants();
        $defaultArray = [];
        foreach ($constants as $key => $constantValue) {
            $exploded = explode('_', $key);
            if (isset($exploded[1])) {
                $defaultArray[strtolower($exploded[1])] = $constantValue;
            }
        }
        $this->setParameters($defaultArray);
    }

    public function generateSessionToken(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
