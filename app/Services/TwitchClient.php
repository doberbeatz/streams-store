<?php

namespace App\Services;

use App\Models\Game;
use GuzzleHttp\Client;

class TwitchClient extends Client
{

    const PER_PAGE = 100;
    const URL_STREAMS_SUFFIX = '/helix/streams';
    const URL_AUTH_SUFFIX = '/kraken/oauth2/token';
    const ACCEPT_HEADER = 'application/vnd.twitchtv.v5+json';

    /** @var string */
    protected $url;

    /**
     * @inheritdoc
     */
    public function __construct(array $config = [])
    {
        $this->url = config('app.twitch_url');

        parent::__construct(
            array_merge([
                'headers' => [
                    'Accept'        => self::ACCEPT_HEADER,
                    'Authorization' => 'Bearer ' . $this->getAuthToken(),
                ],
            ], $config)
        );
    }


    /**
     * @return array
     */
    public function getStreams(): array
    {
        $data = [];

        $gameIds = Game::active()->get()->modelKeys();

        try {
            do {
                $response = $this->request('GET', $this->url . self::URL_STREAMS_SUFFIX, [
                    'query' => [
                        'game_id' => $gameIds,
                        'first'   => self::PER_PAGE,
                        'after'   => $cursor ?? '',
                    ],
                ]);
                $result = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

                if (!empty($result['data'])) {
                    $data = array_merge($data, $result['data']);
                }
            } while ($cursor = ($result['pagination']['cursor'] ?? ''));
        } catch (\Exception $e) {
            echo 'Something gone wrong. Error: ' . $e->getMessage();
        }

        return $data;
    }

    /**
     * @return string
     */
    protected function getAuthToken()
    {
        try {
            $response = (new parent(['headers' => ['Accept' => self::ACCEPT_HEADER]]))
                ->request('POST', $this->url . self::URL_AUTH_SUFFIX, [
                    'query' => [
                        'client_id'     => config('app.twitch_client_id'),
                        'client_secret' => config('app.twitch_client_secret'),
                        'grant_type'    => 'client_credentials',
                    ],
                ]);
            $result = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            $token = $result['access_token'];
        } catch (\Exception $e) {
            echo 'Something gone wrong. Error: ' . $e->getMessage();
        }

        return $token ?? '';
    }
}