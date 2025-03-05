<?php

namespace App\Services;


use App\Models\PeopleAccount;
use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use App\Models\PeopleAccountTransaction;
use App\Enums\{PaymentType, OperationType};

class PaymentService
{
    /**
     * Handles different payment operations.
     */
    public function handlePayment(array $data, string $operationType, string $crudOperation)
    {
        $operationsMap = [
            // Expense Section

            OperationType::INVOICE_EXPENSE => 'processInvoiceExpense',
            OperationType::INVOICE_EXPENSE_PAYMENT => 'processInvoiceExpensePayment',

            // Payment Section
            OperationType::MONEY_PAID => 'processMoneyPaid',
            OperationType::MONEY_RECEIVED => 'processMoneyReceived',

            // Salary Section
            OperationType::PAYSLIP => 'processPayslip',
            OperationType::PAY_SALARY => 'processPaySalary',

        ];

        if (!isset($operationsMap[$operationType])) {
            throw new \Exception("Invalid operation type: " . $operationType);
        }

        return $this->{$operationsMap[$operationType]}($data, $crudOperation);
    }

    /**
     * Process Purchase Transaction.
     */
    private function processPurchase(array $data, string $crudOperation)
    {

    }

}
