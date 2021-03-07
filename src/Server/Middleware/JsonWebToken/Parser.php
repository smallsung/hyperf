<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Exception;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Psr\Container\ContainerInterface;

class Parser
{
    protected Configuration $configuration;

    public function __construct(ContainerInterface $container)
    {
        $this->configuration = $container->get(Constant::class)->getConfiguration();
    }

    /**
     * @param string $tokenString
     * @return Token
     * @throws Exception
     */
    public function parse(string $tokenString): Token
    {
        try {
            $token = $this->configuration->parser()->parse($tokenString);
            if ($this->configuration->validator()->validate($token, ...$this->configuration->validationConstraints())){
                return $token;
            }
        }catch (Exception $exception){

        }
        throw new Exception();
    }
}