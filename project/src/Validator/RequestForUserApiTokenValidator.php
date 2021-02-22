<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RequestForUserApiTokenValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        /**
         * @var Request $value
         * @var RequestForUserApiToken $constraint
         */
        $requestBodyArray = json_decode($value->getContent(), true);

        if ($requestBodyArray === false) {
            throw new BadRequestHttpException($constraint->invalidJson);
        }

        if (!array_key_exists('timestamp', $requestBodyArray)) {
            throw new BadRequestHttpException($constraint->notContainsTimestamp);
        }
    }
}