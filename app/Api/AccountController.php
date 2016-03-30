<?php

namespace LaterPost\Api;

use Illuminate\Http\Request;

use LaterPost\Http\Requests;
use LaterPost\Services\AccountService;

class AccountController extends BaseController
{
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * AccountController constructor.
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Delete Account
     * @param $id
     */
    public function deleteAccount($id)
    {
        try {
            $this->accountService->delete($id);
        } catch(\Exception $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * Delete or disconnect Bitly Account
     */
    public function deleteBitly()
    {
        try {
            $this->accountService->deleteBitlyAccount();
        } catch(\Exception $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
