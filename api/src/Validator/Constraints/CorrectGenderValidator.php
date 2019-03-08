<?php
// api/src/Validator/Constraints/CorrectGenderValidator.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
final class CorrectGenderValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if ($value != "male" && $value != "female") {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}