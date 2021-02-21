<?php

declare(strict_types=1);

namespace SmallSung\Hyperf\Server\Middleware\JsonWebToken;

use Hyperf\Contract\ConfigInterface;
use Lcobucci\Clock\Clock;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class Constant
{
    protected Configuration $configuration;
    protected Signer $signer;
    protected Key $signingKey;

    protected Clock $clock;


    public function __construct(ContainerInterface $container)
    {
        $secret = $container->get(ConfigInterface::class)->get('jsonWebToken.secret', null);
        if (empty($secret)){
            $container->get(LoggerInterface::class)->warning('config.jsonWebToken.secret 未定义。将创建空Signer');
            $this->signingKey = InMemory::empty();
        }else{
            $this->signingKey = InMemory::base64Encoded($secret);
        }
        $this->signer = new Sha256();
        $this->configuration = Configuration::forSymmetricSigner(
            $this->signer
            ,$this->signingKey
        );

        $this->clock = SystemClock::fromSystemTimezone();

        $validationConstraints = $container->get(ConfigInterface::class)->get('jsonWebToken.validationConstraints', []);
        $validationConstraints = array_values(array_merge($this->defaultValidationConstraints(), $validationConstraints));
        $this->configuration->setValidationConstraints(...$validationConstraints);
    }

    protected function defaultValidationConstraints(): array
    {
        $list = [];
        $list[Constraint\SignedWith::class] = new Constraint\SignedWith($this->signer, $this->signingKey);
        $list[Constraint\LooseValidAt::class] = new Constraint\LooseValidAt($this->clock);
        return $list;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    /**
     * @return Signer|Sha256
     */
    public function getSigner()
    {
        return $this->configuration->signer();
    }

    /**
     * @return Key|InMemory
     */
    public function getSigningKey()
    {
        return $this->configuration->signingKey();
    }

    /**
     * @return Clock|SystemClock
     */
    public function getClock()
    {
        return $this->clock;
    }
}