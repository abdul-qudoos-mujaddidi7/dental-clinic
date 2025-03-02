
<?php

use Illuminate\Validation\Rules\Enum;

class ResponseStatus extends Enum
{
    const SUCCESS = 'success';
    const FAILED = 'failed';

}
