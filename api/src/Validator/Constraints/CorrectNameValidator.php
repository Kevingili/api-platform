<?php
// api/src/Validator/Constraints/MinimalPropertiesValidator.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class CorrectNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (strpos($value, "Airbus") === false) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}