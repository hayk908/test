<?php

namespace App\Service\Auth\Action;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Laravel\Passport\Client;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use League\OAuth2\Server\AuthorizationServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParentAuthAction
{
    use HandlesOAuthErrors;

    protected User $user;
    protected Client $client;

    public function __construct(
        protected readonly AuthorizationServer $server,
        protected readonly \GuzzleHttp\Client  $guzzleClient
    )
    {
    }

    public function run(array $data): array
    {
        $this->getPassportCredentials();
        return $this->withParsedBodyToServerRequest($data);
    }

    protected function getPassportCredentials(): void
    {
        $oClientId = Config::get('passport.personal_grant_client.id');
        $this->client = Client::find($oClientId);
    }

    protected function withParsedBodyToServerRequest(array $data): array
    {
        $data = [
            'grant_type' => 'password',
            'username' => $data['email'],
            'password' => $data['password'],
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => '*',
        ];


        if (isset($this->client->id) && isset($this->client->secret)) {
            $response = $this->guzzleClient->request(
                'POST',
                config('app.url') . '/oauth/token',
                ['form_params' => $data]
            );

        } else {
            throw new NotFoundHttpException();
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
