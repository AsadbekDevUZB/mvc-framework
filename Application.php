<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;

class Application
{
    public string $userClass;
    public static string $ROOTDIR;
    public Router $route;
    public Response $response;
    public Request $request;
    public Database $db;
    public Session $session;
    public ?DbModel $user;
    public View $view;
    public static  $app;
    public ?Controller $controller = null;
    public string  $layout = 'main';

    public function __construct($rootPath,$config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOTDIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
        $this->session = new Session();
        $this->route = new Router($this->request,$this->response);
        $this->db = new Database($config['db']);

        $primaryValue = $this->session->get('user');
        if($primaryValue){
            $primaryKey  = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = null;
        }
    }

    public static function isGuest() : bool
    {
        return !self::$app->user;
    }

    public function run()
    {
        try {
           echo  $this->route->resolve();
        }catch (\Exception $e){
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('_error',[
                'exception'=>$e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    public function login(DbModel $user) : bool
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user',$primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}