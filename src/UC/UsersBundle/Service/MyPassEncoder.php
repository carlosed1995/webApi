<?php
// UC/UsersBundle/Service/MyPassEncoder.php
 
namespace UC\UsersBundle\Service;
 
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
 
class MyPassEncoder implements PasswordEncoderInterface
{
 
    public function encodePassword($raw, $salt)
    {
    	// Implementamos nuestro encoder personalizado
        return md5($salt . $raw); 
    }
 
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return $encoded === $this->encodePassword($raw, $salt);
    }
 
}