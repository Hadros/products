<?php

namespace App\Command;

use App\Service\ProductService;
use App\Service\XmlParser;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:parse-products-xml')]
class ParseProductsXmlCommand extends Command
{

    use LockableTrait;

    private XmlParser $xmlParser;

    private ProductService $productService;

    protected string $url;

    public function __construct(XmlParser $xmlParser, ProductService $productService, string $url = '')
    {
        // best practices recommend to call the parent constructor first and
        // then set your own properties. That wouldn't work in this case
        // because configure() needs the properties set in this constructor
        $this->url = $url;
        $this->xmlParser = $xmlParser;
        $this->productService = $productService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('url',
                InputArgument::REQUIRED,
                'URL of the file, which needs to parse'
            )
        ;

        $this->setHelp('This command allows you to parse a xml file.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::SUCCESS;
        }

        if (filter_var($input->getArgument('url'), FILTER_VALIDATE_URL) === FALSE) {
            $output->writeln([
                'Error!',
                'Not a valid URL.'
            ]);
            return Command::INVALID;
        }

        try {
            $productsData = $this->xmlParser->getProductsData($input->getArgument('url'));
            $this->productService->createProducts($productsData);

            $output->writeln([
                'Success',
            ]);
        }
        catch (\Exception $exception) {
            $output->writeln([
                'Error!',
                $exception->getMessage()
            ]);
            return Command::FAILURE;
        }

        $this->release();

        return Command::SUCCESS;
    }
}