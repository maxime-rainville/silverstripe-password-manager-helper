<?php

namespace MaximeRainville\SilverstripePasswordManagerHelper;

use SilverStripe\Admin\CMSProfileController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;

/**
 * Redirect to the My profile page wher the user can change their password.
 */
class WellKnown extends Controller
{
    public function index(HTTPRequest $request): HTTPResponse
    {
        //** @var CMSProfileController $profile  */
        $profile = CMSProfileController::create();
        return $this->redirect($profile->Link());
    }
}
