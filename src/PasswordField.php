<?php

namespace MaximeRainville\SilverstripePasswordManagerHelper;

use SilverStripe\Forms\PasswordField as BasePasswordField;

/**
 * Extends the PasswordFiled so it can be fill by a password manager
 */
class PasswordField extends BasePasswordField
{

    private string $autocomplete = '';

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        $attributes = parent::getAttributes();
        $autocomplete = $this->getAutocomplete();

        if ($autocomplete) {
            $attributes['autocomplete'] = $autocomplete;
        }

        return $attributes;
    }

    public function setAutocomplete(string $value): self
    {
        $this->autocomplete = $value;

        return $this;
    }

    public function getAutocomplete(): string
    {
        return $this->autocomplete;
    }

}
