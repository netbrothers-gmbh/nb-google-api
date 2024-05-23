<?php
/**
 * NetBrothers NbGoogleApi
 *
 * @copyright NetBrothers GmbH <info@netbrothers.de>
 * @date 23.05.2024
 */

declare(strict_types=1);

namespace NetBrothers\NbGoogleApiBundle\Command;

use NetBrothers\NbGoogleApiBundle\Services\Autocomplete;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'netbrothers:example:google-autocomplete',
    description: 'Test Autocomplete command',
)]
class AutocompleteCommand extends Command
{
    public function __construct(
        private readonly Autocomplete $googleAutocompleteService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $googleSession = $this->googleAutocompleteService->generateSessionToken();
        $this->googleAutocompleteService->setInput('Berlin Hauptbahnhof')->setSessionToken($googleSession);
        $this->googleAutocompleteService->processRequest();
        dd($this->googleAutocompleteService->getResult());
    }
}
