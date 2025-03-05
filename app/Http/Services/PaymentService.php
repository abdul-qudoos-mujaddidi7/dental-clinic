<?php

namespace App\Http\Services;


use App\Models\PeopleAccount;
use InvalidArgumentException;
use App\Enums\TransactionType;
use Illuminate\Support\Facades\Auth;
use App\Models\PeopleAccountTransaction;
use App\Enums\{PaymentType, OperationType};

class PaymentService
{
    
    public function paySalary(array $request)
    {
        $data = $this->prepareData($request,OperationType::PAY_SALARY);
        return PeopleAccountTransaction::create($data);
    }

    public function generatePaySlip(array $request)
    {
        $data = $this->prepareData($request,OperationType::PAYSLIP);
        return PeopleAccountTransaction::create($data);
    }

    public function prepareData(array $request,$operationType)
    {
        $request[PeopleAccountTransaction::COLUMN_MONEY_ACCOUNT_ID] = TransactionType::getType($operationType) == TransactionType::PAYMENT ? 1 : NULL;
        $request[PeopleAccountTransaction::COLUMN_PEOPLE_ACCOUNT_ID] = $this->getPeopleAccount($request['people_id']);
        $request[PeopleAccountTransaction::COLUMN_TRANSACTION_TYPE] = TransactionType::getType($operationType);
        $request[PeopleAccountTransaction::COLUMN_OPERATION_TYPE] = $operationType;
        $request[PeopleAccountTransaction::COLUMN_PAYMENT_TYPE] = PaymentType::getPaymentType($operationType); 
        return $request;
    }

    public function getPeopleAccount($peopleId)
    {
        $peopleAccount = PeopleAccount::firstOrCreate(
            [PeopleAccount::COLUMN_PEOPLE_ID => $peopleId],
            [PeopleAccount::COLUMN_ACCOUNT_BALANCE => 0] // Assuming a default balance of 0 for new accounts
        );

        return $peopleAccount->id;
    }
}
