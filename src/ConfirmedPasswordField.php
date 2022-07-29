<?php

namespace MaximeRainville\SilverstripePasswordManagerHelper;

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\ConfirmedPasswordField as BaseConfirmedPasswordField;
use SilverStripe\Forms\Form;

/**
 * Extends the ConfirmedPasswordField to set better auto-complete value.
 */
class ConfirmedPasswordField extends BaseConfirmedPasswordField
{

/**
     * @param string $name
     * @param string $title
     * @param mixed $value
     * @param Form $form
     * @param boolean $showOnClick
     * @param string $titleConfirmField Alternate title (not localizeable)
     */
    public function __construct(
        $name,
        $title = null,
        $value = "",
        $form = null,
        $showOnClick = false,
        $titleConfirmField = null
    ) {
        if ($this->forceShowConfirmPassword($form)) {
            $showOnClick = false;
        }
        parent::__construct($name, $title, $value, $form, $showOnClick, $titleConfirmField);
        $this->getPasswordField()->setAutocomplete('new-password');
        $this->getConfirmPasswordField()->setAutocomplete('new-password');
    }


    private function forceShowConfirmPassword(): bool
    {
        $session = Injector::inst()->get(HTTPRequest::class)->getSession();
        if ($session->get('ForceShowConfirmPassword')) {
            $session->clear('ForceShowConfirmPassword');
            return true;
        }
        return false;
    }

    public function setRequireExistingPassword($show)
    {
        // Store the current autocomplete value
        $oldField = $this->passwordField;
        $autocomplete = $oldField ? $oldField->getAutocomplete() : '';

        // Don't modify if already added / removed
        if ((bool)$show === $this->requireExistingPassword) {
            return $this;
        }
        $this->requireExistingPassword = $show;
        $name = $this->getName();
        $currentName = "{$name}[_CurrentPassword]";
        if ($show) {
            $passwordField = PasswordField::create($currentName, _t('SilverStripe\\Security\\Member.CURRENT_PASSWORD', 'Current Password'));
            $passwordField->setAutocomplete('current-password');
            $this->getChildren()->unshift($passwordField);
        } else {
            $this->getChildren()->removeByName($currentName, true);
        }
        return $this;
    }

}
