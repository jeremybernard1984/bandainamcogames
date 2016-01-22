<?php

namespace App\Controller;

use Core\Controller\Controller;

class GamesController extends AppController{

    public function __construct(){
        parent::__construct();
        $this->loadModel('Game');
        $this->loadModel('Category');

    }

    public function index(){
        $games = $this->Game->last();
        $categories = $this->Category->all();
        $this->render('games.index', compact('games', 'categories'));
    }

    public function category(){
        $categorie = $this->Category->find($_GET['id']);
        if($categorie === false){
            $this->notFound();
        }
        $articles = $this->Game->lastByCategory($_GET['id']);
        $categories = $this->Category->all();
        $this->render('game.category', compact('articles', 'categories', 'categorie'));
    }

    public function show(){
        $article = $this->Game->findWithCategory($_GET['id']);
        $this->render('games.show', compact('article'));
    }

}