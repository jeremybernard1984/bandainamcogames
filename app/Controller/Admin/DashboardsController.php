<?php

namespace App\Controller\Admin;

use Core\HTML\BootstrapForm;
class DashboardsController extends AppController{

    public function __construct(){
        parent::__construct();
        // Je load les modeles VOIR dans le dossier table
        $this->loadModel('Dashboard');
        $this->loadModel('Lang');
    }

    public function index(){
        //$dashboards = $this->Dashboard->all();
        //$this->render('admin.dashboards.index', compact('dashboards'));
        $this->render('admin.dashboards.index');
    }





}