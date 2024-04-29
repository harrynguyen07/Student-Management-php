<?php
// router
session_start();
$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';

// import config & database
require 'config.php';
require 'connectDB.php';

// import model
require 'model/Student.php';
require 'model/StudentRepository.php';

require 'model/Subject.php';
require 'model/SubjectRepository.php';

require 'model/Register.php';
require 'model/RegisterRepository.php';


$controller = ucfirst($c) . 'Controller'; //StudentController
require "controller/$controller.php"; //require controller/StudentController.php

$controller = new $controller(); //new StudentController()
$controller->$a();//$controller->index();