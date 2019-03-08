<?php
// api/src/Validator/Constraints/CorrectName.php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CorrectName extends Constraint
{
    public $message = 'The plane must have the name start with Airbus';
}