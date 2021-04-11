<?php
namespace controllers;

 use models\Basket;
 use models\Order;
 use models\Product;
 use services\dao\OrgaRepository;
 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\USession;

 /**
 * Controller MainController
 **/
class MainController extends ControllerBase{

   use WithAuthTrait;
    #[Route(path: "/", name: "home")]

    #[Autowired]
    private OrgaRepository $repo;

    /**
     * @return OrgaRepository
     */
    public function getRepo(): OrgaRepository
    {
        return $this->repo;
    }

    /**
     * @param OrgaRepository $repo
     */
    public function setRepo(OrgaRepository $repo): void
    {
        $this->repo = $repo;
    }

    public function index() {
	    $this->loadView("MainController/index.html");
    }

    #[Route ('order', name:'order')]
    public function orders(){
        $orders = DAO::getAll(Order::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['orders'=>$orders]);
    }

    #[Route ('store', name:'store')]
    public function store(){
        $store = DAO::getAll(Product::class, false, false);
        $this->loadDefaultView(['store'=>$store]);
    }

    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }

    #[Route ('basket', name:'basket')]
    public function basket(){
        $baskets = DAO::getAll(Basket::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['baskets'=>$baskets]);
    }

    #[Route ('newBasket', name:'newBasket')]
    public function newBasket(){
        $newbasket = DAO::getAll(Order::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['newbasket'=>$newbasket]);
    }
}
