<?php
/*
 * This file is part of ZasDev Reader.
 *
 * ZasDev Reader is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZasDev Reader is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZasDev Reader. If not, see <http://www.gnu.org/licenses/>.
 */

namespace ZasDev\Auth\Controller;

use Auth\Entity\Login;
use Auth\Form\LoginForm;
use Auth\Form\LoginFormAwareInterface;
use Auth\Service\AuthServiceAwareInterface;
use Auth\Service\PersistentLoginInterface;
use Auth\Service\PersistentLoginServiceAwareInterface;
use Zend\Http\PhpEnvironment\Response as PhpEnvironmentResponse;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Class IndexController
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class IndexController extends AbstractActionController implements
    PersistentLoginServiceAwareInterface,
    AuthServiceAwareInterface,
    LoginFormAwareInterface
{
    /**
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;
    /**
     * @var \Auth\Service\PersistentLoginInterface
     */
    private $persistentLogin;
    /**
     * @var LoginForm
     */
    private $loginForm;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        AuthenticationService $authService,
        PersistentLoginInterface $persistentLogin,
        LoginForm $loginForm,
        TranslatorInterface $translator
    ) {
        $this->authService      = $authService;
        $this->persistentLogin  = $persistentLogin;
        $this->loginForm        = $loginForm;
        $this->translator       = $translator;
    }

    public function loginAction()
    {
        $prg = $this->prg('login');
        if ($prg instanceof PhpEnvironmentResponse) {
            return $prg;
        } elseif ($prg === false) {
            return $this->createModel();
        }

        $this->getLoginForm()->setData($prg);
        return $this->treatForm();
    }

    public function logoutAction()
    {
        // Clear authentication identity
        $this->getAuthService()->clearIdentity();
        // Delete presistent login cookie if exists
        $this->getPersistentLoginService()->delete();

        return $this->createModel();
    }

    /**
     * Checks if the login form is valid or not, and performs the proper operations for each case
     * @return ViewModel
     */
    protected function treatForm()
    {
        $model = $this->createModel();
        $form = $this->getLoginForm();

        if (!$form->isValid()) {
            $model->setVariable('message', $this->translate('The form has expired due to inactivity. Try again.'));
            $model->setVariable('error', true);
            return $model;
        }

        /** @var Login $login */
        $login = $form->getData();
        /** @var AbstractAdapter $authAdapter */
        $authAdapter = $this->getAuthService()->getAdapter();

        // Set user and password to be checked
        $authAdapter->setIdentity($login->getUser());
        $authAdapter->setCredential($login->getPass());
        $result = $this->getAuthService()->authenticate();

        // If authentication was valid, store the user data as a User entity
        if (!$result->isValid()) {
            $model->setVariable('message', $this->translate('Username or password are incorrect.'));
            $model->setVariable('error', true);
            return $model;
        }

        // Create persistent login if defined
        if ($login->isRemember()) {
            $this->getPersistentLoginService()->create($this->getAuthService()->getIdentity());
        }

        // If a redirect query param was provided, redirect to it, otherwise, redirect to home
        $redirectTo = $this->params()->fromQuery('redirect');
        if (isset($redirectTo)) {
            return $this->redirect()->toUrl($redirectTo);
        }
        return $this->redirect()->toRoute('home');
    }

    /**
     * @return ViewModel
     */
    protected function createModel()
    {
        // In adition to create a ViewModel, set the layout to be used for login actions
        $this->layout()->setTemplate('layout/login');
        // Set template to login form and return model
        $model = new ViewModel(array(
            'form' => $this->getLoginForm()
        ));
        $model->setTemplate('auth/index/login');
        return $model;
    }

    /**
     * Translates a string using injected translator
     * @param $message
     * @return string
     */
    protected function translate($message)
    {
        return $this->translator->translate($message);
    }

    /**
     * Sets the persistent login service
     * @param PersistentLoginInterface $persistentLoginService
     * @return mixed
     */
    public function setPersistentLoginService(PersistentLoginInterface $persistentLoginService)
    {
        $this->persistentLogin = $persistentLoginService;
        return $this;
    }

    /**
     * @return PersistentLoginInterface
     */
    public function getPersistentLoginService()
    {
        return $this->persistentLogin;
    }

    /**
     * @param AuthenticationService $authService
     * @return $this
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }


    /**
     * @param LoginForm $form
     * @return mixed
     */
    public function setLoginForm(LoginForm $form)
    {
        $this->loginForm = $form;
        return $this;
    }
    /**
     * @return LoginForm
     */
    public function getLoginForm()
    {
        return $this->loginForm;
    }
}
