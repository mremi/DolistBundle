<?php

/*
 * This file is part of the Mremi\DolistBundle Symfony bundle.
 *
 * (c) Rémi Marseille <marseille.remi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Tests Dolist authentication')
            ->setName('mremi:dolist:test-authentication');
    }

    /**
     * {@inheritdoc}
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
