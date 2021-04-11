<?php
namespace controllers;

 use models\Basket;
 use models\Order;
 use models\Product;
 use models\Section;
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

    //Chargement page index
    public function index() {
	    $this->loadView("MainController/index.html");
    }

    //Route des commandes
    #[Route ('order', name:'order')]
    public function orders(){
        $orders = DAO::getAll(Order::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['orders'=>$orders]);
    }

    //Route du store
    #[Route ('store', name:'store')]
    public function store(){
        $store = DAO::getAll(Product::class, false, false);
        $listsections = DAO::getAll(Section::class,'', ['products']);
        $listProm = DAO::getAll(Product::class, 'promotion< ?', false, [0]);
        //$nbprodSection = DAO::count(Product::class, 'section= ?', false?);
        $this->loadDefaultView(['store'=>$store, 'listProm'=>$listProm, 'listSection'=>$listsections]);
    }
    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }

    //Creation du panier
    #[Route ('basket', name:'basket')]
    public function basket(){
        $baskets = DAO::getAll(Basket::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['baskets'=>$baskets]);
    }

    //Route de l'ajout de panier
    #[Route ('newBasket', name:'newBasket')]
    public function newBasket(){
        $newbasket = DAO::getAll(Order::class, 'idUser= ?', false, [USession::get("idUser")]);
        $this->loadDefaultView(['newbasket'=>$newbasket]);
    }

    //La route pour les sections
    #[Route ('section/{id}', name:'section')]
    public function section($id){
        $product = DAO::getAll(Product::class, 'idSection= '.$id, [USession::get("idSection")]);
        $section = DAO::getById(Section::class,$id,['products']);
        $listsections = DAO::getAll(Section::class,'', ['products']);
        $this->loadDefaultView(['section'=>$section, 'listSection'=>$listsections, 'product'=>$product]);
    }

    //Route produit
    #[Route ('product/{idSection}/{idProduct}', name:'product')]
    public function product($idSection,$idProduct){
        $product = DAO::getAll(Product::class, 'idSection= '.$idProduct, [USession::get("idSection")]);
        $productid = DAO::getById(Product::class,$idProduct,['sections']);
        $section = DAO::getById(Section::class,$idSection,['products']);
        $listsections = DAO::getAll(Section::class,'', ['products']);
        $this->loadDefaultView(['section'=>$section, 'listSection'=>$listsections, 'product'=>$product, 'productid'=>$productid]);
    }
}
