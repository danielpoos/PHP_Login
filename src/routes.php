<?php

use Petrik\Loginapp\Token;
use Petrik\Loginapp\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
return function(App $app){
    $app->get('/hello', function (Request $request, Response $response, array $args) {
        #$name = $args['name'];
        $response->getBody()->write("Go Barbara, go!");
        return $response;
    });
    $app->post('/register', function (Request $request, Response $response) {
        $userData = json_decode($request->getBody(), true);
        $user = new User();
        #validation
        $user->email = $userData['email'];
        $user->password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->save();
        $response->getBody()->write($user->toJson());
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    });
    $app->post('/login', function (Request $request, Response $response) {
        $loginData = json_decode($request->getBody(), true);
        #validation
        $email = $loginData['email'];
        $password = $loginData['password'];
        $user = User::where('email', $email)->firstOrFail();
        if (!password_verify($password, $user->$password)) {
            throw new Exception("Valami nem jó");
        }
        $token = new Token();
        $token->user_id = $user->id;
        $token->token = bin2hex(random_bytes(128));
        $token->save();
        $response->getBody()->write(json_encode(['email' => $user->email, 'token' =>$token->token]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    });

};