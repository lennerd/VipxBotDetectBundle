<?php

namespace Vipx\BotDetectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vipx\BotDetect\Metadata\Metadata;

/**
 * Test a user agent with the Symfony CLI.
 */
class TestUserAgentCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this->setName('bot-detect:test-user-agent')
            ->setDescription('Test a user agent')
            ->addArgument(
                'user-agent',
                InputArgument::REQUIRED,
                'The user agent to test'
            )->setHelp(<<<EOT
Test a user agent against the vipx-bot-detect library and shows the results:

<info>php app/console bot-detect:test-user-agent "AddThis"</info>
EOT
            );
    }

    /**
     * @param InputInterface  $input  The input
     * @param OutputInterface $output The output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $this->getHelper('formatter'); /** @var FormatterHelper $formatter */
        $userAgent = $input->getArgument('user-agent');

        $output->writeln($formatter->formatBlock('--------------------------', 'info'));
        $output->writeln($formatter->formatBlock('-- Vipx/BotDetectBundle --', 'info'));
        $output->writeln($formatter->formatBlock('--------------------------', 'info'));
        $output->writeln(sprintf(' > Testing user agent "%s" ...', $userAgent));

        $metaData = $this->getContainer()->get('vipx_bot_detect.detector')->detect($userAgent, null);

        if ($metaData instanceof Metadata) {
            $output->writeln(' > This agent was found !');
            $rows[] = ['Name', $metaData->getName()];
            $rows[] = ['Type', $metaData->getType()];

            $ip = $metaData->getIp();
            if (!empty($ip)) {
                $rows[] = ['IP', $metaData->getIp()];
            }

            $meta = $metaData->getMeta();
            if (!empty($meta)) {
                foreach ($meta as $key => $value) {
                    $metaInf[] = [$key, $value];
                }
            }

            $table = new Table($output);
            $table
                ->setHeaders(array('Info', 'Value'))
                ->addRows($rows );
            if (!empty($metaInf)) {
                $table->addRow(new TableSeparator());
                $table->addRow([new TableCell('Metadata', array('colspan' => 2))]);
                $table->addRow(new TableSeparator());
                $table->addRows($metaInf);
            }
            $table->render();
        } else {
            $output->writeln(sprintf(' > This agent is unknown, if you think it should be added, send a PR to lennerd/vipx-bot-detect on Github.', $userAgent));
        }

        $output->writeln('');
    }
}