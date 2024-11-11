<?php

namespace App\Service\Auth\Action;

use App\Models\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Exception\GuzzleException;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParentAuthAction
{
    use HandlesOAuthErrors;

    protected User $user;

    /** @var Client|null */
    protected ?Client $client = null;

    public function __construct(
        protected readonly AuthorizationServer $server,

        protected readonly \GuzzleHttp\Client  $guzzleClient
    )
    {
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function run(array $data): array
    {
        $this->getPassportCredentials();

        return $this->withParsedBodyToServerRequest($data);
    }

    protected function getPassportCredentials(): void
    {
        $oClientId = Config::get('passport.personal_grant_client.id');

        $client = Client::find($oClientId);

        if (!$client instanceof Client) {
            throw new NotFoundHttpException("OAuth Client not found or invalid.");
        }

        $this->client = $client;
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    protected function withParsedBodyToServerRequest(array $data): array
    {
        if (!isset($this->client->id, $this->client->secret)) {
            throw new NotFoundHttpException("Client credentials not found.");
        }

        $data = [
            'grant_type' => 'password',
            'username' => $data['email'],
            'password' => $data['password'],
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => '*',
        ];

        $response = $this->guzzleClient->request(
            'POST',
            config('app.url') . '/oauth/token',
            ['form_params' => $data]
        );

        $responseBody = json_decode($response->getBody()->getContents(), true);

        if (!is_array($responseBody)) {
            throw new \UnexpectedValueException("Invalid response from OAuth server.");
        }

        return $responseBody;
    }
}
