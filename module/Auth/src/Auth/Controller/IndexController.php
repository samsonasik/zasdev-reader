<?php
namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Form\LoginFormAwareInterface;
use Auth\Service\AuthServiceAwareInterface;
use Auth\Service\PersistentLoginInterface;
use Auth\Service\PersistentLoginServiceAwareInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @author ZasDev
 * @link https://github.com/zasDev
 */
class IndexController extends AbstractActionController implements PersistentLoginServiceAwareInterface,
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

    public function loginAction()
    {
        $form = $this->getLoginForm();
        $params = array("form" => $form);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $login          = $form->getData();
                $user           = $login->getUser();
                $authAdapter    = $this->getAuthService()->getAdapter();

                // Set user and password to be checked
                $authAdapter->setIdentity($user);
                $authAdapter->setCredential($login->getPass());
                $result = $this->getAuthService()->authenticate();

                // If authentication was valid, store the user data as a User entity
                if ($result->isValid()) {
                    $this->getAuthService()->getStorage()->write($this->getAuthService()->getIdentity());

                    // Create persistent login if defined
                    if ($login->isRemember())
                        $this->getPersistentLoginService()->create($this->getAuthService()->getIdentity());

                    $this->redirect()->toRoute("home");
                } else {
                    $params['message']  = "El nombre de usuario o contraseña son incorrectos";
                    $params['error']    = true;
                }
            } else {
                $params['message']  = "El formulario ha caducado por inactividad. Introduzca los datos de nuevo.";
                $params['error']    = true;
            }
        }

        $this->layout()->setTemplate("layout/login-layout.phtml");
        // Set template to login form and return model
        $model = new ViewModel($params);
        return $model;
    }

    public function logoutAction()
    {
        // Clear identity
        $this->getAuthService()->clearIdentity();
        // Delete presistent login cookie if exists
        $this->getPersistentLoginService()->delete();

        $this->layout()->setTemplate("layout/login-layout.phtml");
        // Set template to login form and return model
        $model = new ViewModel(array(
            "form" => $this->getLoginForm()
        ));
        $model->setTemplate("auth/index/login");
        return $model;
    }

    /**
     * Sets the persistent login service
     * @param PersistentLoginInterface $persistentLoginService
     * @return mixed
     */
    public function setPersistentLoginService(PersistentLoginInterface $persistentLoginService) {
        $this->persistentLogin = $persistentLoginService;
        return $this;
    }
    /**
     * @return PersistentLoginInterface
     */
    public function getPersistentLoginService() {
        if (!($this->persistentLogin instanceof PersistentLoginInterface))
            $this->setPersistentLoginService($this->getServiceLocator()->get('Auth\Service\PersistentLoginService'));

        return $this->persistentLogin;
    }

    /**
     * @param AuthenticationService $authService
     * @return $this
     */
    public function setAuthService(AuthenticationService $authService) {
        $this->authService = $authService;
        return $this;
    }
    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthService() {
        if (!($this->authService instanceof AuthenticationService))
            $this->setAuthService($this->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));

        return $this->authService;
    }


    /**
     * @param LoginForm $form
     * @return mixed
     */
    public function setLoginForm(LoginForm $form) {
        $this->loginForm = $form;
        return $this;
    }
    /**
     * @return LoginForm
     */
    public function getLoginForm() {
        if (!($this->loginForm instanceof LoginForm))
            $this->setLoginForm($this->getServiceLocator()->get('Auth\Form\LoginForm'));

        return $this->loginForm;
    }

}
