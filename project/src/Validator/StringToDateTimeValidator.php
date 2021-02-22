<?php

namespace App\Validator;

use DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class StringToDateTimeValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        /**
         * @var DateTime $userDateTime
         * @var StringToDateTime $constraint
         */
        $userDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $value);

        if ($userDateTime === false) {
            throw new BadRequestHttpException($constraint->badDateTime);
        }

        $dayDiff = $userDateTime->diff(new DateTime())->d;

        if ($dayDiff > 0) {
            throw new BadRequestHttpException($constraint->outOfRange);
        }
    }
}