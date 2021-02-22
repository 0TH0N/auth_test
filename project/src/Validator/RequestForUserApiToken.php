<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class RequestForUserApiToken extends Constraint
{
    public $invalidJson = 'Invalid JSON format.';
    public $notContainsTimestamp = "Request doesn't contain timestamp field.";
}