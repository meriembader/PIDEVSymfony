<?php

namespace DonBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use DonBundle\Entity\Don;
use DonBundle\Entity\DonArgent;
use DonBundle\Entity\DonProd;
use DonBundle\Entity\Produit;
use DonBundle\Form\DonArgentType;
use DonBundle\Form\DonProdType;
use DonBundle\Form\DonType;
use DonBundle\Form\ProduitType;
use DonBundle\Form\Type1;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DonController extends Controller
{
    public function addProdAction(Request $request,Produit $produit=null){
        //            lehne aamlna creation taa form
        if (!$produit) {
            $produit = new Produit();
        }
        $form=$this->createForm(ProduitType::class,$produit);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            $em->persist($produit);
            //tawa nflushiw
            $em->flush();
            return $this->redirectToRoute('don_listProds');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/addProd.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdProd() != null));
    }
    public function listProdsAction(){
        $em=$this->getDoctrine()->getRepository(Produit::class);
        $list_Prod=$em->findAll();
        return $this->render('@Don/DonViews/listProds.html.twig',array('list_Prod'=>$list_Prod));
    }
    public function  deleteProdAction($idProd){
        $produit=$this->getDoctrine()->getRepository(Produit::class)->find($idProd);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('don_listProds');

    }
    public function addDonProduAction(Request $request){
        //            lehne aamlna creation taa form
        //$dateDon=date('Y-m-d');
        //  $heureDon=date('H:i:s');
        $produit = new Don(0,0,$this->getUser()->getId());
        $form=$this->createForm(DonType::class,$produit);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            //      $dateDon=date('Y-m-d');
            //    $heureDon=date('H:i:s');
            $produit = new Don(0,0,$this->getUser()->getId());
            $em->persist($produit);
            //tawa nflushiw
            $em->flush();
            return $this->redirectToRoute('don_listProds');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/addDonProd.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdDon() != null));
    }

    public function addDonProdAction(Request $request,DonProd $donProd = null){

        //            lehne aamlna creation taa form
        $donprod=new DonProd();
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT max(p.idDon)
            FROM DonBundle\Entity\Don p
            ');

        // returns an array of Product objects
        $idd=$query->getResult();
        //$idd=$this->findMax();
        //$iddd=reset($idd);
        // $produit.setidDon(100);
        $form=$this->createForm(DonProdType::class,$donprod);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            //$produit.setidDon();
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            //$prodd = new Produit();
            //$prodd = $form->get('idProd')->getData();
           // $donprod->setIdProd($prodd->getIdProd());

            $em->persist($donprod);
            //tawa nflushiw
            $em->flush();
            $em->createQuery("UPDATE DonBundle:DonProd c SET c.idDon = :ids WHERE c.idDon in (0)")
                ->setParameter(':ids',$idd[0])
                ->execute();
            return $this->redirectToRoute('don_listDonProdsf');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/addDonProd.html.twig',array('form'=>$form->createView(),'edit'=>$donprod->getIdDon() != null));
    }
    public function addDonPAction(){

        //            lehne aamlna creation taa form
        //$dateDon=date('Y-m-d');
        //$heureDon=date('H:i:s');
        $produit = new Don(0,0,$this->getUser()->getId());
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        //hne jebnaaa doctrine
        $em=$this->getDoctrine()->getManager();
        //tawa bsh npersistiw
        $em->persist($produit);
        //tawa nflushiw
        $em->flush();
        $form=$this->createForm(DonType::class);
        return $this->redirectToRoute('don_addDonProd');

        //hne rajaa3na render taa page ajout
        //  return $this->render('@Don/DonViews/addDonProd.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdDon() != null));
    }
    /* function idproduit($str){
         $sql="select id from produit where nom like '".$str."' ";
         $db = config::getConnexion();
         try{
             $liste=$db->query($sql);
             return $liste;
         }
         catch (Exception $e){
             die('Erreur: '.$e->getMessage());
         }
     }*/

    public function findMax()
    {
        /*  $entityManager = $this->getDoctrine()->getManager();

          $query = $entityManager->createQuery(
              'SELECT max(id_don)
              FROM DonBundle\Entity\Don p
              ');

          // returns an array of Product objects
          return $query->getResult();*/
        $connection = $this->getDoctrine()->getConnection('Don');

        $result = $connection->fetchAll('SELECT max(id_don) FROM Don');

    }
    public function listDonProdsAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT f.username,p.idDon,p.qt,p.date,p.heure,p.lieu,d.libelleProd FROM DonBundle\Entity\DonProd p inner join DonBundle\Entity\Produit d WHERE d.idProd = p.idProd INNER JOIN DonBundle\Entity\Don a WHERE a.idDon = p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE a.idUser = f.id 
            ');

        // returns an array of Product objects
        $list_DonProd=$query->getResult();

        return $this->render('@Don/DonViews/listDonProds.html.twig',array('list_DonProd'=>$list_DonProd));
    }
    public function listDonProdsfAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT a.idDon,a.dateDon,a.heureDon,p.qt,p.date,p.heure,p.lieu,d.libelleProd FROM DonBundle\Entity\DonProd p inner join DonBundle\Entity\Produit d WHERE d.idProd = p.idProd INNER JOIN DonBundle\Entity\Don a WHERE a.idDon = p.idDon where a.idUser=:ids ORDER BY a.dateDon desc , a.heureDon desc')
->setParameter(':ids',$this->getUser()->getId());
        // returns an array of Product objects
        $list_DonProd=$query->getResult();

        return $this->render('@Don/DonViews/listDonProdsf.html.twig',array('list_DonProd'=>$list_DonProd));
    }
    public function  deleteDonProdAction($idDon){
        $produit=$this->getDoctrine()->getRepository(DonProd::class)->find($idDon);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $em->createQuery("Delete from DonBundle:Don c  WHERE c.idDon = :ids")
            ->setParameter(':ids',$idDon)
            ->execute();
        return $this->redirectToRoute('don_listDonProdsf');

    }
    public function editDonArgentAction(Request $request,DonArgent $produit=null){
        //            lehne aamlna creation taa form
        if (!$produit) {
            $produit = new DonArgent();
        }
        $form=$this->createForm(DonArgentType::class,$produit);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            $em->persist($produit);
            //tawa nflushiw
            $em->flush();
            return $this->redirectToRoute('don_listDonArgentf');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/editDonArgent.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdDon() != null));
    }
    public function editDonProdAction(Request $request,DonProd $produit=null){
        //            lehne aamlna creation taa form
        if (!$produit) {
            $produit = new DonProd();
        }
        $form=$this->createForm(DonProdType::class,$produit);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            $em->persist($produit);
            //tawa nflushiw
            $em->flush();
            return $this->redirectToRoute('don_listDonProdsf');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/editDonProd.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdDon() != null));
    }
    public function addDonArgentAction(Request $request,DonArgent $donArgent = null){

        //            lehne aamlna creation taa form
        $donArgent=new DonArgent();
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT max(p.idDon)
            FROM DonBundle\Entity\Don p
            ');

        // returns an array of Product objects
        $idd=$query->getResult();
        //$idd=$this->findMax();
        //$iddd=reset($idd);
        // $produit.setidDon(100);
        $form=$this->createForm(DonArgentType::class,$donArgent);
        //lehne bsh naadyw requete
        $form=$form->handleRequest($request);
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        if($form->isSubmitted() && $form->isValid()){
            //hne jebnaaa doctrine
            //$produit.setidDon();
            $em=$this->getDoctrine()->getManager();
            //tawa bsh npersistiw
            $em->persist($donArgent);
            //tawa nflushiw
            $em->flush();
            $em->createQuery("UPDATE DonBundle:DonArgent c SET c.idDon = :ids WHERE c.idDon in (0)")
                ->setParameter(':ids',$idd[0])
                ->execute();
            return $this->redirectToRoute('don_listDonArgentf');

        }
        //hne rajaa3na render taa page ajout
        return $this->render('@Don/DonViews/addDonArgent.html.twig',array('form'=>$form->createView(),'edit'=>$donArgent->getIdDon() != null));
    }
    public function addDonAAction(){

        //            lehne aamlna creation taa form
        //$dateDon=date('Y-m-d');
        //$heureDon=date('H:i:s');
        $produit = new Don(0,1,$this->getUser()->getId());
        //taw bsh nshoufo ken aanbina form valid o jawou behi naaemlou persist(ajout)
        //hne jebnaaa doctrine
        $em=$this->getDoctrine()->getManager();
        //tawa bsh npersistiw
        $em->persist($produit);
        //tawa nflushiw
        $em->flush();
        $form=$this->createForm(DonType::class);
        return $this->redirectToRoute('don_addDonArgent');

        //hne rajaa3na render taa page ajout
        //  return $this->render('@Don/DonViews/addDonProd.html.twig',array('form'=>$form->createView(),'edit'=>$produit->getIdDon() != null));
    }
    public function listDonArgentAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT f.username,p.idDon,p.somme FROM DonBundle\Entity\DonArgent p  INNER JOIN DonBundle\Entity\Don a WHERE a.idDon = p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE a.idUser = f.id 
            ');

        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function listDonArgentfAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT p.idDon,p.somme,a.dateDon,a.heureDon FROM DonBundle\Entity\DonArgent p  INNER JOIN DonBundle\Entity\Don a WHERE a.idDon = p.idDon WHERE a.idUser =:ids order by  a.dateDon desc ,a.heureDon desc
         ')
->setParameter(':ids',$this->getUser()->getId());
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgentf.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function  deleteDonArgentAction($idDon){
        $produit=$this->getDoctrine()->getRepository(DonArgent::class)->find($idDon);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        $em->createQuery("Delete from DonBundle:Don c  WHERE c.idDon = :ids")
            ->setParameter(':ids',$idDon)
            ->execute();
        return $this->redirectToRoute('don_listDonArgentf');

    }
    public function QtProdAction($id){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select sum(qt) from DonBundle\Entity\DonProd p INNER JOIN DonBundle\Entity\Don d ON d.idDon=p.idDon where d.idUser=:ids'
        )
        ->setParameter(':ids',$id);
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function SommeArgAction($id){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT sum(somme) from DonBundle\Entity\DonArgent a inner JOIN DonBundle\Entity\Don d on a.idDon = d.idDon WHERE idUser=:ids
')
            ->setParameter(':ids',$id);
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function PointsAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT sum(a.somme) from 
DonBundle\Entity\DonArgent a inner JOIN DonBundle\Entity\Don d WHERE a.idDon = d.idDon and d.idUser=:ids
')



            ->setParameter(':ids',$this->getUser()->getId());
        $list_DonArgent=$query->getResult();

        $query = $entityManager->createQuery(
            'SELECT sum(p.qt) from DonBundle\Entity\DonProd p INNER JOIN DonBundle\Entity\Don d WHERE d.idDon=p.idDon and d.idUser=:ids
')
            ->setParameter(':ids',$this->getUser()->getId());
        // returns an array of Product objects

        $idd=$query->getResult();

        $i=$idd[0];
        $s=$list_DonArgent[0];
        return $this->render('@Don/DonViews/AddDon.html.twig',array('i'=>$i,'s'=>$s));
    }
    public function topdonprodAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select f.username,d.idUser,sum(p.qt) as prods from DonBundle\Entity\DonProd p INNER JOIN DonBundle\Entity\Don d WHERE d.idDon=p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE d.idUser = f.id group by d.idUser order by prods 
desc');
// returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/TopDonneursProd.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function topdonargAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select f.username,d.idUser,sum(p.somme) as sommes from DonBundle\Entity\DonArgent p INNER JOIN DonBundle\Entity\Don d WHERE d.idDon=p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE d.idUser = f.id  GROUP BY d.idUser ORDER BY sommes desc ');
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/TopDonneursArg.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function StatArgAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            '
select (select count(*) from DonBundle\Entity\Don where etat=1)/( select count(*) from DonBundle\Entity\Don ) *100
');
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function StatProdAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            '
select (select count(*) from DonBundle\Entity\Don where etat=0)/( select count(*) from DonBundle\Entity\Don ) *100');
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function TopMoisProdAction($date1,$date2){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select idUser,sum(qt) as \'prods\' from DonBundle\Entity\DonProd p INNER JOIN DonBundle\Entity\Don d on d.idDon=p.idDon where dateDon < :date1 and 
dateDon > :date2 group by idUser order by prods desc')
            ->setParameter(':date1',$date1)
            ->setParameter(':date2',$date2);
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }
    public function TopMoisArgAction($date1,$date2){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select id_user,sum(somme) as \'sommes\' from DonBundle\Entity\DonArgent p INNER JOIN DonBundle\Entity\Don d on d.idDon=p.idDon where dateDon < \'2020-05-31\' 
and dateDon > \'2020-05-01\' group by idUser order by prods desc')
            ->setParameter(':date1',$date1)
            ->setParameter(':date2',$date2);
        // returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgent.html.twig',array('list_DonArgent'=>$list_DonArgent));
    }

    public function StatAction()
    {
        $pieChart = new PieChart();
        $em = $this->getDoctrine();
        $prods=$em->getRepository(DonProd::class)->findAll();
        $totprods=0;
        foreach($prods as $prod){
            $totprods=$totprods+1;
        }
        $arg=$em->getRepository(DonArgent::class)->findAll();
        $totarg=0;
        foreach($arg as $arr){
            $totarg=$totarg+1;
        }
        // returns an array of Product objects
        $data=array();
        $stat=['type','nbDons'];
        array_push($data,$stat);
        $stat=['Produit',$totprods];
        array_push($data,$stat);
        $stat=['Argent',$totarg];
        array_push($data,$stat);
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des dons par type');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'select p.libelleProd,sum(d.qt) as tot from DonBundle\Entity\DonProd d inner join DonBundle\Entity\Produit p where p.idProd=d.idProd group by d.idProd order by tot');


        $tt=$query->getResult();
        $stat=['Produits', 'Quantité donné'];
        $data=array();
        array_push($data,$stat);
        foreach ($tt as $t)
        {
            $stat=[ $t['libelleProd'], $t['tot'] ];
            array_push($data,$stat);
        }
        $chart = new ColumnChart();
        $chart->getData()->setArrayToDataTable(
           $data
        );
        $chart->getOptions()->getChart()
            ->setTitle('Quantité des produits donnés');
        $chart->getOptions()->getTitleTextStyle()->setBold(true);
        $chart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $chart->getOptions()->getTitleTextStyle()->setItalic(true);
        $chart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $chart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $chart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(900)
            ->setColors(['#1b9e77', '#d95f02', '#7570b3'])
            ->getVAxis()
            ->setFormat('decimal');





        $entityManager3 = $this->getDoctrine()->getManager();
        $query3 = $entityManager3->createQuery(
            'select YEAR(d.dateDon) as y , count(d.idDon) as dn from DonBundle\Entity\Don d group by y');


        $tt3=$query3->getResult();
        $stat3=[['label' => 'x', 'type' => 'number'], ['label' => 'values', 'type' => 'number']];
        $data3=array();
        array_push($data3,$stat3);
//        array_push($data3,$stat3);
        foreach ($tt3 as $t)
        {
            $stat3=[ $t['y'], $t['dn'] ];
            array_push($data3,$stat3);
        }

        $line = new LineChart();
        $line->getData()->setArrayToDataTable(
            $data3

        );
        $line->getOptions()->setTitle('Courbe d\'evolution des dons par années');
//        $line->getOptions()->setCurveType('function');
        $line->getOptions()->setLineWidth(4);
        $line->getOptions()->getLegend()->setPosition('none');
        $line->getOptions()->getTitleTextStyle()->setBold(true);
        $line->getOptions()->getTitleTextStyle()->setColor('#009900');
        $line->getOptions()->getTitleTextStyle()->setItalic(true);
        $line->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $line->getOptions()->getTitleTextStyle()->setFontSize(20);
        $line->getOptions()
            ->setHeight(400)
            ->setWidth(900)
            ->setColors(['#7570b3'])
            ->getVAxis()
            ->setFormat('decimal');





        return $this->render('@Don/DonViews/Stat.html.twig',array('piechart'=>$pieChart,'chart'=>$chart ,'line'=>$line));
    }

    public function pdfAction()
    {
       $pdfOptions = new Options();
       $pdfOptions->set('defaultFont','Arial');

       $dompdf = new Dompdf($pdfOptions);

       $html = $this->renderView('@Don/DonViews/pdf.html.twig', ['title' => "Welcome to our PDF test"]);
       $dompdf->loadHtml($html);
      $dompdf->setPaper('A4','portrait');
      $dompdf->render();
      $dompdf->stream("LITO.pdf",["Attachment" => true ]);
return null;    }

    public function topdonprodmAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $date1 = new \DateTime();
       $mois=(int) $date1->format('m');
        $date1 = new \DateTime();
        $année= $date1->format('Y');
        $query = $entityManager->createQuery(
            'select f.username,d.idUser,sum(p.qt) as prods from DonBundle\Entity\DonProd p INNER JOIN DonBundle\Entity\Don d WHERE d.idDon=p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE d.idUser = f.id and Month(d.dateDon) = :ids and Year(d.dateDon) = :id group by d.idUser order by prods 
desc')
  ->setParameter(':ids',$mois)

            ->setParameter(':id',$année);
// returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/TopDonneursProdm.html.twig',array('list_DonArgent'=> $list_DonArgent));
    }
    public function topdonargmAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $date1 = new \DateTime();
        $mois=(int) $date1->format('m');
        $date1 = new \DateTime();
        $année= $date1->format('Y');
        $query = $entityManager->createQuery(
            'select f.username,d.idUser,sum(p.somme) as prods from DonBundle\Entity\DonArgent p INNER JOIN DonBundle\Entity\Don d WHERE d.idDon=p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE d.idUser = f.id and Month(d.dateDon) = :ids and Year(d.dateDon) = :id group by d.idUser order by prods 
desc')
            ->setParameter(':ids',$mois)

            ->setParameter(':id',$année);
// returns an array of Product objects
        $list_DonArgent=$query->getResult();

        return $this->render('@Don/DonViews/TopDonneursArgm.html.twig',array('list_DonArgent'=> $list_DonArgent));
    }
    public function listDonProdsbAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT f.username,a.dateDon,a.heureDon,p.idDon,p.qt,p.date,p.heure,p.lieu,d.libelleProd FROM DonBundle\Entity\DonProd p inner join DonBundle\Entity\Produit d WHERE d.idProd = p.idProd INNER JOIN DonBundle\Entity\Don a WHERE a.idDon = p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE a.idUser = f.id 
           order by a.dateDon desc , a.heureDon desc ');

        // returns an array of Product objects
        $list_DonProd=$query->getResult();

        return $this->render('@Don/DonViews/listDonProdsb.html.twig',array('list_DonProd'=>$list_DonProd));
    }

    public function listDonArgentbAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT f.username,a.dateDon,a.heureDon,p.idDon,p.somme FROM DonBundle\Entity\DonArgent p inner join DonBundle\Entity\Don a WHERE a.idDon = p.idDon INNER JOIN DonBundle\Entity\FosUser f WHERE a.idUser = f.id 
          order by a.dateDon desc , a.heureDon desc ');

        // returns an array of Product objects
        $list_DonProd=$query->getResult();

        return $this->render('@Don/DonViews/listDonArgentb.html.twig',array('list_DonProd'=>$list_DonProd));
    }

}

