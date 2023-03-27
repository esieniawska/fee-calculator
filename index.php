<?php

require __DIR__.'/vendor/autoload.php';

use PragmaGoTech\Interview\Application\Proposal\Factory\LinearFeeCalculatorFactory;
use PragmaGoTech\Interview\Application\Proposal\Service\LinearFeeCalculatorService;
use PragmaGoTech\Interview\Infrastructure\Proposal\Repository\InMemoryFeeStructureRepository;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\BinaryFeeRangeFinder;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\FeeRounderUp;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\LinearFeeFinder;
use PragmaGoTech\Interview\Presentation\Proposal\Command\LinearFeeCalculatorCommand;
use PragmaGoTech\Interview\Presentation\Proposal\Service\AmountConverter;
use Symfony\Component\Console\Application;

$application = new Application('fee-calculator', '1.0.0');
$command = new LinearFeeCalculatorCommand(
    new AmountConverter(),
    new LinearFeeCalculatorService(
        new LinearFeeCalculatorFactory(
            new InMemoryFeeStructureRepository(),
            new BinaryFeeRangeFinder(),
            new LinearFeeFinder(),
            new FeeRounderUp()
        )
    )
);

$application->add($command);

$application->setDefaultCommand($command->getName(), true);
$application->run();