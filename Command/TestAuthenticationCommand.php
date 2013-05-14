<?php

namespace Mremi\DolistBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test authentication command.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TestAuthenticationCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Tests Dolist authentication')
            ->setName('mremi:dolist:test-authentication');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $token = $this->getAuthenticationManager()->getAuthenticationTokenContext();

        $output->writeln(sprintf('<info>Account identifier:</info> %s', $token->getAccountId()));
        $output->writeln(sprintf('<info>Key:</info> %s', $token->getKey()));
    }

    /**
     * Gets the authentication service
     *
     * @return \Mremi\Dolist\Authentication\AuthenticationManagerInterface
     */
    private function getAuthenticationManager()
    {
        return $this->getContainer()->get('mremi_dolist.api.authentication_manager');
    }
}