<?php

namespace Api\Controller;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Exception\OAuthServerException;

use Api\Auth\AccessTokenRepository;
use Api\Auth\ClientRepository;
use Api\Auth\RefreshTokenRepository;
use Api\Auth\ScopeRepository;
use Api\Auth\UserRepository;

/**
 * Class to handle client authorization and authentication
 * 
 * Responsible for generating auth tokens
 */
class AuthController {
    
    public static function getAccessToken($args) {
        $token = array('token_type' => '',
            'expires_in' => '',
            'access_token' => '',
            'refresh_token' => '');
        
        $client_id = $args['client_id'] ?: '';
        $client_secret = $args['client_secret'] ?: '';
        $scope = $args['scope'] ?: '';
        $username = $args['username'] ?: '';
        $password = $args['password'] ?: '';
        
        // Init our repositories
        $clientRepository = new ClientRepository(); // instance of ClientRepositoryInterface
        $scopeRepository = new ScopeRepository(); // instance of ScopeRepositoryInterface
        $accessTokenRepository = new AccessTokenRepository(); // instance of AccessTokenRepositoryInterface
        $userRepository = new UserRepository(); // instance of UserRepositoryInterface
        $refreshTokenRepository = new RefreshTokenRepository(); // instance of RefreshTokenRepositoryInterface

        // Path to public and private keys
        $privateKey = 'file://path/to/private.key';
        //$privateKey = new CryptKey('file://path/to/private.key', 'passphrase'); // if private key has a pass phrase
        $encryptionKey = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen'; // generate using base64_encode(random_bytes(32))

        // Setup the authorization server
        $server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        $grant = new PasswordGrant(
             $userRepository,
             $refreshTokenRepository
        );

        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

        // Enable the password grant on the server
        $server->enableGrantType($grant,new \DateInterval('PT1H')); // access tokens will expire after 1 hour
        
        
        //Implementation
        try {
            // Try to respond to the request
            return $server->respondToAccessTokenRequest($request, $response);
        }
        catch (OAuthServerException $exception) {
            // All instances of OAuthServerException can be formatted into a HTTP response
            //return $exception->generateHttpResponse($response);
            
        } 
        catch (\Exception $exception) {
            // Unknown exception
            
        }

        return $token;
    }
    
    public static function refreshAccessToken($args) {
        $token = array('token_type' => '',
            'expires_in' => '',
            'access_token' => '',
            'refresh_token' => '');
        
        $client_id = $args['client_id'] ?: '';
        $client_secret = $args['client_secret'] ?: '';
        $scope = $args['scope'] ?: '';
        $refresh_token = $args['refresh_token'] ?: '';
        
        
        // Init our repositories
        $clientRepository = new ClientRepository();
        $accessTokenRepository = new AccessTokenRepository();
        $scopeRepository = new ScopeRepository();
        $refreshTokenRepository = new RefreshTokenRepository();

        // Path to public and private keys
        $privateKey = 'file://path/to/private.key';
        //$privateKey = new CryptKey('file://path/to/private.key', 'passphrase'); // if private key has a pass phrase
        $encryptionKey = 'lxZFUEsBCJ2Yb14IF2ygAHI5N4+ZAUXXaSeeJm6+twsUmIen'; // generate using base64_encode(random_bytes(32))

        // Setup the authorization server
        $server = new \League\OAuth2\Server\AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKey,
            $encryptionKey
        );

        $grant = new \League\OAuth2\Server\Grant\RefreshTokenGrant($refreshTokenRepository);
        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // new refresh tokens will expire after 1 month

        // Enable the refresh token grant on the server
        $server->enableGrantType(
            $grant,
            new \DateInterval('PT1H') // new access tokens will expire after an hour
        );
        
        // Try to respond to the request
        try {
            return $server->respondToAccessTokenRequest($request, $response);
        } 
        catch (\League\OAuth2\Server\Exception\OAuthServerException $exception) {
            //return $exception->generateHttpResponse($response);

        } 
        catch (\Exception $exception) {
            
        }
        
        return $token;
    }
    
}
