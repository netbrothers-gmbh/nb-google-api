<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NbGoogleApiExtension extends Extension
{
    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . "/../Resources/config"));
        $loader->load('services.xml');
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        $autocomplete = $container->getDefinition('netbrothers_google_api.services.autocomplete');
        $autConfig = [
            'key' => $config['nb_google_api_places_autocomplete_key'],
            'uri' => $config['nb_google_api_places_autocomplete_uri'],
            'requestType' => $config['nb_google_api_request_type'],
        ];
        $autocomplete->setArgument(0, $autConfig);
    }

    public function getAlias(): string
    {
        return 'netbrothers_google_api';
    }
}
