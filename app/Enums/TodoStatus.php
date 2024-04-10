<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class TodoStatus extends Enum implements LocalizedEnum
{
    const TODO = 'todo';
    const INPROGRESS = 'inprogress';
    const COMPLETED = 'completed';
    const BLOCKED = 'blocked';
}
