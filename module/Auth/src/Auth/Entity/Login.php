<?php
namespace Auth\Entity;

/**
 * Login entity mapped with results of LoginForm
 * @see \Application\Form\LoginForm
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class Login
{
    
    private $user;
    private $pass;
    private $remember;

	public function getUser() {
    	return $this->user;
    }
	public function setUser($user) {
    	$this->user = $user;
    	return $this;
    }
	
	public function getPass() {
    	return $this->pass;
    }
	public function setPass($pass) {
    	$this->pass = $pass;
    	return $this;
    }
	
	public function isRemember() {
    	return (bool) $this->remember;
    }
	public function setRemember($remember) {
    	$this->remember = (bool) $remember;
    	return $this;
    }
    
}