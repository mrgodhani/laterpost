<?php namespace LaterPost\Services;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use LaterPost\Repository\AccountRepo;

class TwitterService
{
    /**
     * @var AccountRepo
     */
    private $accountRepo;

    /**
     * TwitterService constructor.
     * @param AccountRepo $accountRepo
     */
    public function __construct(AccountRepo $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    /**
     * Guzzle Client
     * @param $token
     * @param $secret
     * @return Client
     */
    protected function client($token,$secret){
        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key' => env('TWITTER_CLIENT_ID'),
            'consumer_secret' => env('TWITTER_CLIENT_SECRET'),
            'token' => $token,
            'token_secret' => $secret
        ]);
        $stack->push($middleware);
        return new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }

    /**
     * Upload Media
     * @param $image
     * @param $image_data
     * @param $token
     * @param $secret
     * @return string
     */
    protected function media_upload($image,$image_data,$token,$secret)
    {
        $client = $this->client($token,$secret);
        $response = $client->post('https://upload.twitter.com/1.1/media/upload.json',[
            'multipart' => [
                [
                    'name' => 'media',
                    'contents' => $image
                ],
                [
                    'name' => 'media_data',
                    'contents' => $image_data
                ]
            ]
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Update Status
     * @param bool $media
     * @param null $image
     * @param null $base64
     * @param $data
     * @return string
     */
    public function status_update($media = false,$image = null,$base64 = null, $data){
        $media_data = null;
        $accounts  = collect(json_decode($data['accounts']))->toArray();
        foreach($accounts as $account){
            $account = $this->accountRepo->findBy('profile_id',$account->profile_id);
            $client = $this->client($account->token,$account->secret);
            if($media){
                $media_data = collect(json_decode($this->media_upload($image,$base64,$account->token,$account->secret)))->toArray();
            }
            $params = [
                'status' => $data['content'],
                'media_ids' => $media ? $media_data['media_id'] : null
            ];
            $client->post('statuses/update.json',['query' => $params]);
        }
    }
}