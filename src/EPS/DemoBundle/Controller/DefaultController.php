<?php

namespace EPS\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use EPS\JqGridBundle\Grid\Grid;
use EPS\DemoBundle\Entity\Author;
use EPS\DemoBundle\Entity\Post;
use EPS\DemoBundle\Entity\Comment;

class DefaultController extends Controller {

    /**
     * @Route("/", name="viewgrid")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getEntityManager();


        $qb = $em->createQueryBuilder()
                ->from('EPSDemoBundle:Post', 'p')
                ->leftJoin('p.author', 'a')
                ->leftJoin('p.comments', 'c')
                ->select('a.name, p.id, p.datepost, p.title, count(c.id) as nbcomments')
                ->groupBy('p.id');


        $authors = $em->getRepository('EPSDemoBundle:Author')->findAll();

        $lstauthor = array();
        $lstauthor[''] = 'All';
        foreach ($authors as $a) {
            $lstauthor[$a->getName()] = $a->getName();
        }

        $grid = $this->get('eps_jq_grid');

        //OPTIONAL
        $grid->setName('gridpost');
        $grid->setCaption('list of posts');
        $grid->setOptions(array('height' => 'auto', 'width' => '910'));
        $grid->setRouteForced($this->get('router')->generate('viewgrid'));
        $grid->setHideIfEmpty(false);

        //MANDATORY
        $grid->setSource($qb);

        //COLUMNS DEFINITION
        $grid->addColumn('Action', array('twig' => 'EPSDemoBundle:Default:_testgridaction.html.twig', 'name' => 'action', 'resize' => false, 'sortable' => false, 'search' => false, 'width' => '50'));
        $grid->addColumn('ID', array('name' => 'id', 'index' => 'p.id', 'hidden' => true, 'sortable' => false, 'search' => false));
        $grid->addColumn('Author', array('name' => 'name', 'index' => 'a.name', 'width' => '150', 'stype' => 'select', 'searchoptions' => array('value' => $lstauthor)));
        $grid->addColumn('Post', array('name' => 'title', 'index' => 'p.title', 'width' => '150'));
        $grid->addColumn('Date post', array('name' => 'datepost', 'index' => 'p.datepost', 'formatter' => 'date', 'datepicker' => true));
        $grid->addColumn('Nb comments', array('name' => 'nbcomments', 'index' => 'nbcomments', 'search' => false));

        return ($grid->render());
    }

    /**
     * @Route("/multi", name="multiviewgrid")
     * @Template()
     */
    public function multigridAction() {
        $grid1 = $this->getGrid1(true);
        $grid2 = $this->getGrid2(true);

        return array(
            'grid1' => $grid1,
            'grid2' => $grid2,
        );
    }

    /**
     * @Route("/gene", name="gene")
     * @Template()
     */
    public function geneDataAction() {

        $em = $this->getDoctrine()->getEntityManager();

        for ($i = 0; $i < 10; $i++) {
            $auth = new Author;
            $auth->setName('author' . $i);
            for ($j = 0; $j < 10; $j++) {
                $post = new Post();
                $post->setTitle('post N°' . $j);
                $post->setAuthor($auth);
                $dat = new \DateTime();
                $dat->add(new \DateInterval('P' . ($j + 1) . 'D'));
                $post->setDatepost($dat);

                for ($k = 0; $k < (int) mt_rand(1, 15); $k++) {
                    $comm = new Comment();
                    $dat = new \DateTime();
                    $dat->add(new \DateInterval('P' . ($k + 1) . 'D'));
                    $comm->setDatecomment($dat);
                    $comm->setContent('content' . $k);
                    $comm->setPost($post);
                    $em->persist($comm);
                    $em->persist($post);
                    $em->persist($auth);
                }
            }
        }
        $em->flush();
        return array();
    }

    /**
     * @Route("/grid1", name="grid1")
     */
    public function getGrid1($returnGrid = false) {
        $em = $this->getDoctrine()->getEntityManager();


        $qb = $em->createQueryBuilder()
               ->from('EPSDemoBundle:Post', 'p')
                ->leftJoin('p.author', 'a')
                ->leftJoin('p.comments', 'c')
                ->select('a.name, p.id, p.datepost, p.title, count(c.id) as nbcomments')
                ->groupBy('p.id');


        $authors = $em->getRepository('EPSDemoBundle:Author')->findAll();

        $lstauthor = array();
        $lstauthor[''] = 'All';
        foreach ($authors as $a) {
            $lstauthor[$a->getName()] = $a->getName();
        }

        $grid = $this->get('eps_jq_grid');

        //OPTIONAL
        $grid->setName('gridpost1');
        $grid->setCaption('list of posts');
        $grid->setOptions(array('height' => 'auto', 'width' => '910'));
        $grid->setRouteForced($this->get('router')->generate('grid1'));
        $grid->setHideIfEmpty(false);

        //MANDATORY
        $grid->setSource($qb);

        //COLUMNS DEFINITION
        $grid->addColumn('Action', array('twig' => 'EPSDemoBundle:Default:_testgridaction.html.twig', 'name' => 'action', 'resize' => false, 'sortable' => false, 'search' => false, 'width' => '50'));
        $grid->addColumn('ID', array('name' => 'id', 'index' => 'p.id', 'hidden' => true, 'sortable' => false, 'search' => false));
        $grid->addColumn('Author', array('name' => 'name', 'index' => 'a.name', 'width' => '150', 'stype' => 'select', 'searchoptions' => array('value' => $lstauthor)));
        $grid->addColumn('Post', array('name' => 'title', 'index' => 'p.title', 'width' => '150'));
        $grid->addColumn('Date post', array('name' => 'datepost', 'index' => 'p.datepost', 'formatter' => 'date', 'datepicker' => true));
        $grid->addColumn('Nb comments', array('name' => 'nbcomments', 'index' => 'nbcomments', 'search' => false));

        if ($returnGrid) {
            return $grid;
        } else {
            return $grid->render();
        }
    }

    /**
     * @Route("/grid2", name="grid2")
     */
    public function getGrid2($returnGrid = false) {
        $em = $this->getDoctrine()->getEntityManager();


        $qb = $em->createQueryBuilder()
          	->from('EPSDemoBundle:Post', 'p')
                ->leftJoin('p.author', 'a')
                ->leftJoin('p.comments', 'c')
                ->select('a.name, p.id, p.datepost, p.title, count(c.id) as nbcomments')
                ->groupBy('p.id');


        $authors = $em->getRepository('EPSDemoBundle:Author')->findAll();

        $lstauthor = array();
        $lstauthor[''] = 'All';
        foreach ($authors as $a) {
            $lstauthor[$a->getName()] = $a->getName();
        }

        $grid = $this->get('eps_jq_grid');

        //OPTIONAL
        $grid->setName('gridpost2');
        $grid->setCaption('list of posts');
        $grid->setOptions(array('height' => 'auto', 'width' => '910'));
        $grid->setRouteForced($this->get('router')->generate('grid2'));
        $grid->setHideIfEmpty(false);

        //MANDATORY
        $grid->setSource($qb);

        //COLUMNS DEFINITION
        $grid->addColumn('Action', array('twig' => 'EPSDemoBundle:Default:_testgridaction.html.twig', 'name' => 'action', 'resize' => false, 'sortable' => false, 'search' => false, 'width' => '50'));
        $grid->addColumn('ID', array('name' => 'id', 'index' => 'p.id', 'hidden' => true, 'sortable' => false, 'search' => false));
        $grid->addColumn('Author', array('name' => 'name', 'index' => 'a.name', 'width' => '150', 'stype' => 'select', 'searchoptions' => array('value' => $lstauthor)));
        $grid->addColumn('Post', array('name' => 'title', 'index' => 'p.title', 'width' => '150'));
        $grid->addColumn('Date post', array('name' => 'datepost', 'index' => 'p.datepost', 'formatter' => 'date', 'datepicker' => true));
        $grid->addColumn('Nb comments', array('name' => 'nbcomments', 'index' => 'nbcomments', 'search' => false));

        if ($returnGrid) {
            return $grid;
        } else {
            return $grid->render();
        }
    }

}
