<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;
//use Symfony\Component\Security\Core\Authentication\SimpleFormAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class WebserviceUserAuthenticator implements SimpleFormAuthenticatorInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        try {
            $user = $userProvider->loadUserByUsername($token->getUsername());
        } catch (UsernameNotFoundException $e) {
            //throw new AuthenticationException('Invalid username or password');
            throw new CustomUserMessageAuthenticationException('Invalid username or password');
        }

        //$passwordencode = $this->encoder->encodePassword($user, $token->getCredentials());
        //$user->setpassword($passwordencode);
        
        //dump($passwordencode);
        //sleep(5);
        //$passwordValid = $this->encoder->isPasswordValid($user, $passwordencode);
        $passwordValid = $this->encoder->isPasswordValid($user, $token->getCredentials());
        //$passwordValid = $this->encoder->isPasswordValid($user, "123{123}");
        

        
        //$passwordencode = $this->encoder->encodePassword($user, $token->getCredentials());
        //$passwordValid=true;
        //dump($token,$passwordencode);
        //dump('authenticateToken ',$token,$user,$passwordValid,$token->getCredentials(),$this->encoder);//,$passwordencode

        if ($passwordValid) {
            return new UsernamePasswordToken(
                  $user,
                  $user->getPassword(),
                  $providerKey,
                  $user->getRoles()
            );
        }

        //throw new AuthenticationException('Invalid password');
        throw new CustomUserMessageAuthenticationException('Invalid username or password');
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof UsernamePasswordToken && $token->getProviderKey() === $providerKey;
    }

    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new UsernamePasswordToken($username, $password, $providerKey);
    }
}