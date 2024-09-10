<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class BelongsToUser implements ValidationRule
{
    public function __construct(protected string $class) {}

    public static function model(string $class): static
    {
        return new static($class);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $model = $this->class::findOrFail($value);
            $user = $model->user;

            if (! $user || Auth::user()->isNot($user)) {
                $fail('The Id Provided Doesnt belong to current user');
            }
        } catch (ModelNotFoundException $e) {
            $fail('The Id Provided Doesnt belong to current user');
        }
    }
}
