<?php
namespace Auth\Form;

/**
 * Interface LoginFormAwareInterface
 * @author ZasDev
 * @link https://github.com/zasDev
 */
interface LoginFormAwareInterface
{
    /**
     * @param LoginForm $form
     * @return mixed
     */
    public function setLoginForm(LoginForm $form);

    /**
     * @return LoginForm
     */
    public function getLoginForm();
}
