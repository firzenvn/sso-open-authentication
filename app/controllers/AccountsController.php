<?php

class AccountsController extends \AccountingBaseController {

	public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function getViewMainAccount()
    {
        return View::make('accounts.view-main-account');
    }

    public function getViewSubAccount()
    {
        return View::make('accounts.view-sub-account');
    }
}