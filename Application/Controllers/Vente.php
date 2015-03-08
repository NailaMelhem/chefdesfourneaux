<?php

namespace Application\Controllers;

class Vente extends \Library\Controller\Controller{

	private $message;
	private $tinyMCE;
	private $modelProduits;
	private $modelViewProduit; 
	private $modelPopUpProduit;
	private $modelPanier;
	private $modelShowDiv;
	private $modelAjax;


	public function __construct(){

		$this->setLayout("carousel");
		$this->message 				= new \Library\Message\Message();
		$this->tinyMCE 				= new \Library\TinyMCE\tinyMCE();
		$this->modelProduits 		= new \Application\Models\Produit('localhost');
		$this->modelViewProduit 	= new \Application\Models\ViewProduit('localhost');
		$this->modelPanier			= new \Application\Models\Panier('localhost');
		$this->modelPopUpProduit	= new \Application\Models\PopUpProduit();
		$this->modelShowDiv 		= new \Application\Models\ShowDiv();
		$this->modelAjax 			= new \Application\Models\Ajax();
		
		
	}


	

	public function indexProduitAction(){
		echo "<br><br><br><br><br>";
		echo "";
		

		$produits = $this->modelProduits->getAllProduits();
		$produits = $produits['response'];
		

		

		// Ajoute les infos du produits au html
		foreach ($produits as $key => $produit) {

			$produits[$key]['modifierpopup']=$this->modelPopUpProduit->getModifPopup(
																$produit['id_produit'], 
																$produit['prix'], 
																$produit['ref'],
																$produit['value']);

			$tst=$this->modelPanier->existeDansPanier($_SESSION['user']['id_user'], $produit['id_produit']);
			
			if (!$tst['response']) {
				$produits[$key]['acheterpopup']=$this->modelPopUpProduit->getAcheterPopup(
																$produit['id_produit'], 
																$produit['prix'], 
																$produit['ref'],
																$produit['value']);
			}else{		//si le produit est deja dans le panier
				$produits[$key]['acheterpopup']="";
			}
		}
		
		
		$this->setDataView(array(
			'pageTitle' => "Vente d'ustensile de cuisine, vente d'électroménager semi-pro",
			'produits' => $produits,
			
			"parametresJs"			=> "
			<script type='text/javascript'>
				urlWebService='".WEBSERVICE_ROOT."/index.php';
				id_user ='".$_SESSION['user']['id_user']."';
			</script>"));

		$this->setStyleView('popup.css');

		$this->setScriptView('produit.js');

	}

	public function produitAction($idProduit){
		$produit = $this->modelProduits->getProduit($idProduit);
		//var_dump($produit);


		$this->setDataView(array(
			'pageTitle' => "Vente d'ustensile de cuisine, vente d'électroménager semi-pro",
			'produit' => $produit['response'][0],
			"urlWebService"			=> "
			<script type='text/javascript'>
				urlWebService='".WEBSERVICE_ROOT."/index.php';\n
			</script>"));

	}







	public function indexLivreAction(){
		


		$modelAjax 	= new \Application\Models\Ajax('localhost');
		

		$this->setDataView(array(
			"pageTitle" => "Livres de Cuisine",
			"ajax" => $ajax
			));
	}

	public function livreAction(){
		
	}

	public function indexRestaurantAction(){
		


		$modelAjax 	= new \Application\Models\Ajax('localhost');
		

		$this->setDataView(array(
			"pageTitle" => "Nos restaurants partenaires",
			"ajax" => $ajax
			));


	}

	public function restaurantAction(){
		
	}
}