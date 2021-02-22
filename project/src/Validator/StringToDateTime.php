<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StringToDateTime extends Constraint
{
    public $badDateTime = 'Bad DateTime format in string.';
    public $outOfRange = 'User DateTime has difference with server DateTime more than 24 hours.';
}