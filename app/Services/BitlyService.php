<?php namespace LaterPost\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use LaterPost\Repository\AccountRepo;
use LaterPosts\Repository\UserRepo;

class BitlyService
{
    /**
     * @var AccountRepo
     */
    private $accountRepo;

    /**
     * BitlyService constructor.
     * @param AccountRepo $accountRepo
     * @internal param UserRepo $userRepo
     */
    public function __construct(AccountRepo $accountRepo)
    {

        $this->accountRepo = $accountRepo;
    }


    /**
     * Shorten long link
     * @param $link
     * @return mixed
     */
    public function shortenLink($link)
    {
        $token = $this->accountRepo->getBitlyToken(Auth::user()->id);
        $params = [
            'longUrl' => $link,
            'domain' => Auth::user()->default_shortener,
            'access_token' => $token,
            'format' => 'json'
        ];
        $client = new Client(['base_uri' => 'https://api-ssl.bitly.com/v3/']);
        $response = $client->get('shorten',['query' => $params]);
        return $response->getBody()->getContents();
    }
}