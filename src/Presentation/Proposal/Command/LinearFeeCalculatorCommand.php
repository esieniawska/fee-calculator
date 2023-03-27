<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Command;

use PragmaGoTech\Interview\Application\Proposal\Dto\CreateLoanProposalInput;
use PragmaGoTech\Interview\Application\Proposal\Exception\ApplicationException;
use PragmaGoTech\Interview\Application\Proposal\Service\LinearFeeCalculatorService;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Shared\Exception\DomainException;
use PragmaGoTech\Interview\Infrastructure\Proposal\Exception\InfrastructureException;
use PragmaGoTech\Interview\Presentation\Proposal\Exception\InvalidValueException;
use PragmaGoTech\Interview\Presentation\Proposal\Service\AmountConverter;
use PragmaGoTech\Interview\Presentation\Proposal\Specification\SpecificationValidator;
use PragmaGoTech\Interview\Presentation\Proposal\Specification\StringIsNotNullSpecification;
use PragmaGoTech\Interview\Presentation\Proposal\Specification\ValueIsBetweenAcceptedValuesSpecification;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class LinearFeeCalculatorCommand extends Command
{
    protected static $defaultName = 'fee-calculator';

    public function __construct(
        private readonly AmountConverter $amountConverter,
        private readonly LinearFeeCalculatorService $linearFeeCalculator
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this->setDescription('Calculate fee');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $term = $io->ask('Enter term (loan duration) in number of months. The accepted value is 12 or 24 months.');
        $amount = $io->ask('Enter the amount requested in number up to 2 decimal places.');

        try {
            $this->validate($term, $amount);

            $output = $this->linearFeeCalculator->calculateFee(
                new CreateLoanProposalInput(
                    (int)$term,
                    $this->amountConverter->getAmountInPennies($amount)
                )
            );
            $io->success(
                sprintf(
                    'Fee: %s PLN',
                    $output->getFee()
                )
            );
        } catch (InvalidValueException|ApplicationException|DomainException|InfrastructureException $exception) {
            $io->error($exception->getMessage());

            return 0;
        }

        return 0;
    }

    private function validate(?string $term, ?string $amount): void
    {
        $this->validateTerm($term);
        $this->validateAmount($amount);
    }

    private function validateTerm(?string $term): void
    {
        $this->ensureIsSatisfiedValue($term, [
            new SpecificationValidator(
                new StringIsNotNullSpecification(),
                'Term not entered.'
            ),
            new SpecificationValidator(
                new ValueIsBetweenAcceptedValuesSpecification(LoanDuration::toArray()),
                'Invalid term.'
            ),
        ]);
    }

    private function validateAmount(?string $amount): void
    {
        $this->ensureIsSatisfiedValue($amount, [
            new SpecificationValidator(
                new StringIsNotNullSpecification(),
                'Amount not entered.'
            ),
        ]);
    }

    private function ensureIsSatisfiedValue(?string $value, array $validators): void
    {
        foreach ($validators as $validator) {
            $validator->checkIsValidSpecification($value);
        }
    }
}
