<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('netbrothers_google_api');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->booleanNode('nb_google_api_enable')
                    ->defaultFalse()
                    ->info('Enable NbGoogleApi [default to no]')
                ->end()
                ->scalarNode('nb_google_api_places_autocomplete_uri')
                    ->defaultValue('https://maps.googleapis.com/maps/api/place/autocomplete/')
                    ->info('Uri Places Autocomplete')
                ->end()
                ->scalarNode('nb_google_api_places_autocomplete_request_type')
                    ->defaultValue('json')
                    ->info('Google-Api Request Type')
                ->end()
                ->scalarNode('nb_google_api_places_autocomplete_key')
                    ->defaultValue('YOUR_GOOGLE_API_KEY')
                    ->info('Google-Api-Key for Places Autocomplete')
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
