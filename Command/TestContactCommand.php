<?php

namespace Mremi\DolistBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Test contact command.
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class TestContactCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Tests Dolist contact')
            ->setName('mremi:dolist:test-contact');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contact = $this->getContactManager()->create();
        $contact->setEmail('test@example.com');
        $contact->addField($this->getFieldManager()->create('firstname', 'Firstname'));
        $contact->addField($this->getFieldManager()->create('lastname', 'Lastname'));

        $ticket = $this->getContactManager()->save($contact);

        $output->writeln(sprintf('<info>Ticket:</info> %s', $ticket));

        $saved = $this->getContactManager()->getStatusByTicket($ticket);

        if ($saved->isOk()) {
            $output->writeln(sprintf('<info>Description:</info> %s', $saved->getDescription()));
            $output->writeln(sprintf('<info>Member identifier:</info> %s', $saved->getMemberId()));
        } else {
            $output->writeln(sprintf('<error>Description:</error> %s', $saved->getDescription()));
            $output->writeln(sprintf('<error>Returned code:</error> %s', $saved->getReturnCode()));
        }

        $contacts = $this->getContactManager()->getContacts();

        $output->writeln(sprintf('<info>Count of returned contacts:</info> %s', $contacts->getReturnContactsCount()));
        $output->writeln(sprintf('<info>Total count of contacts:</info> %s', $contacts->getTotalContactsCount()));
    }

    /**
     * Gets the contact manager service
     *
     * @return \Mremi\Dolist\Contact\ContactManagerInterface
     */
    private function getContactManager()
    {
        return $this->getContainer()->get('mremi_dolist.api.contact_manager');
    }

    /**
     * Gets the field manager service
     *
     * @return \Mremi\Dolist\Contact\FieldManager
     */
    private function getFieldManager()
    {
        return $this->getContainer()->get('mremi_dolist.api.field_manager');
    }
}
