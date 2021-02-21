<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\RegisteredClaims;
use Psr\Container\ContainerInterface;

class Generator
{
    protected Configuration $configuration;

    public function __construct(ContainerInterface $container)
    {
        $this->configuration = $container->get(Constant::class)->getConfiguration();
    }

    public function generate(array $data = []): Token
    {
        $builder = $this->generateBuilder($data);
        return $builder->getToken($this->configuration->signer(), $this->configuration->signingKey());
    }

    public function generateBuilder(array $data = []): Builder
    {
        $builder = $this->configuration->builder();

        if (in_array(RegisteredClaims::AUDIENCE, $data)){
            $aud = $data[RegisteredClaims::AUDIENCE];
            is_array($aud) or $aud = [$aud];
            $builder->permittedFor(...$aud);
            unset($data[RegisteredClaims::AUDIENCE]);
        }
        if (in_array(RegisteredClaims::EXPIRATION_TIME, $data)){
            $builder->expiresAt($data[RegisteredClaims::EXPIRATION_TIME]);
            unset($data[RegisteredClaims::EXPIRATION_TIME]);
        }
        if (in_array(RegisteredClaims::ID, $data)){
            $builder->identifiedBy($data[RegisteredClaims::ID]);
            unset($data[RegisteredClaims::ID]);
        }
        if (in_array(RegisteredClaims::ISSUED_AT, $data)){
            $builder->issuedAt($data[RegisteredClaims::ISSUED_AT]);
            unset($data[RegisteredClaims::ISSUED_AT]);
        }
        if (in_array(RegisteredClaims::ISSUER, $data)){
            $builder->issuedBy($data[RegisteredClaims::ISSUER]);
            unset($data[RegisteredClaims::ISSUER]);
        }
        if (in_array(RegisteredClaims::NOT_BEFORE, $data)){
            $builder->canOnlyBeUsedAfter($data[RegisteredClaims::NOT_BEFORE]);
            unset($data[RegisteredClaims::NOT_BEFORE]);
        }
        if (in_array(RegisteredClaims::SUBJECT, $data)){
            $builder->relatedTo($data[RegisteredClaims::SUBJECT]);
            unset($data[RegisteredClaims::SUBJECT]);
        }

        foreach ($data as $index=>$item) {
            $builder->withClaim($index, $item);
        }
        return $builder;
    }
}