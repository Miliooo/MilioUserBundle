<?php

namespace Milio\UserBundle\Tests\Services;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Milio\UserBundle\Services\SecurityPasswordService;

/**
 * Class SecurityPasswordServiceTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class SecurityPasswordServiceTest extends \PHPUnit_Framework_TestCase
{
    CONST RAW = "foo";
    CONST SALT = "hash";
    CONST ENCODED = "11565612312erereaez";

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|PasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var SecurityPasswordService
     */
    private $passwordService;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->passwordEncoder = $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');
        $this->passwordService = new SecurityPasswordService($this->passwordEncoder);
    }

    /**
     * @test
     */
    public function it_calls_the_encoder_and_returns_the_result_when_get_encoded_password()
    {
        $this->passwordEncoder->expects($this->once())->method('encodePassword')->with(self::RAW, self::SALT)
           ->will($this->returnValue(self::ENCODED));

        $this->assertSame(self::ENCODED, $this->passwordService->getEncodedPassword(self::RAW, self::SALT));
    }

    /**
     * @test
     */
    public function it_calls_the_encoder_and_returns_the_result_when_is_password_valid()
    {
        $this->passwordEncoder->expects($this->once())->method('isPasswordValid')->with(self::ENCODED, self::RAW, self::SALT)
            ->will($this->returnValue(true));

        $this->assertTrue($this->passwordService->isPasswordValid(self::ENCODED, self::RAW, self::SALT));
    }
}
