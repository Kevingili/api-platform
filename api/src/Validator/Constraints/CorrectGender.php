<?php
// api/src/Validator/Constraints/CorrectGender.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CorrectGender extends Constraint
{
    public $message = 'The gender of passenger must have the minimal properties required ("male", "female")';
}