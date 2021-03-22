<?php
namespace controllers;

 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\attributes\items\router\Route;
 /**
 * Controller MainController
 **/
class MainController extends ControllerBase{

   use WithAuthTrait;
    #[Route(path: "/", name: "home")]

    public function index() {
	    $this->loadView("MainController/index.html");
    }



    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }
}
