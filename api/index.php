<?php

//url que van a direccionar a un html
$url = '/api/';
$urlLogin = '/api/login';
$urlRegister = '/api/register';
$urlWelcome = '/api/welcome';
$urlHome = '/api/home';
$urlLecture = '/api/lectura';
$urlViewLecture = '/api/lectura/ver';
$urlLectureSingle = '/api/lectura/ver/escrito';
$urlCreateQuiz = '/api/lectura/ver/crearquiz';
$urlQuiz = '/api/lectura/quiz';
$urlQuizResolve = '/api/lectura/quiz/resolver';
$urlRes = '/api/lectura/quiz/resultado';

switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
	case 'GET':
		if ($_SERVER["REQUEST_URI"] == $url) {
			require('../index.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlLogin) {
			require('../login.php');
		} elseif ($_SERVER["REQUEST_URI"] == $urlRegister) {
			require('../register.php');
		} elseif ($_SERVER["REQUEST_URI"] == $urlWelcome) {
			require('../welcome.php');
		} elseif ($_SERVER["REQUEST_URI"] == $urlHome) {
			require('../welcome.php');
		} elseif ($_SERVER["REQUEST_URI"] == $urlLecture) {
			require('../editor.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlViewLecture) {
			require('../lecturas.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlLectureSingle) {
			require('../ver.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlCreateQuiz) {
			require('../crearquiz.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlQuiz) {
			require('../verquizes.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlQuizResolve) {
			require('../quiz.html');
		} elseif ($_SERVER["REQUEST_URI"] == $urlRes) {
			require('../resultado.html');
		} elseif (isset($_GET['action'])) {
			Lecturas();
		} elseif (isset($_GET['id'])) {
			$id = $_GET['id'];
			proceso($id);
			verLectura($id);
		} elseif (isset($_GET['send2'])) {

			llega();
		} elseif (isset($_GET['crearquiz'])) {
			obtenerIdQuiz();
		} elseif (isset($_GET['id2'])) {
			$id2 = $_GET['id2'];
			verLectura($id2);
		} elseif (isset($_GET['obtener_id_pregunta'])) {
			obtenerIdPregunta();
		} elseif (isset($_GET['ver_examenes'])) {
			ListarExamenes();
		} elseif (isset($_GET['obtener_quiz_id'])) {
			llegaPost4();
			//ListarExamen($_SESSION['QUIZDATAS']['IDRESQUIZ']);
		} elseif (isset($_GET['obtener_quiz'])) {
			$obtenerQuiz = $_GET['obtener_quiz'];
			ListarExamen($obtenerQuiz);
		} elseif (isset($_GET['obtener_options'])) {
			$obtenerOpciones = $_GET['obtener_options'];
			ListarOpciones($obtenerOpciones);
		} elseif (isset($_GET['obtener_res'])) {
			$obtenerRes = $_GET['obtener_res'];
			ObtenerRespuesta($obtenerRes);
		} elseif (isset($_GET['resultado'])) {
			llegaPost5();
		}

		break;
	case 'POST':
		if (isset($_POST['send'])) {
			$name = $_POST['name'];
			$content = $_POST['editor'];
			enviarLecturas($name, $content);
		} elseif (isset($_POST['idQ']) && isset($_POST['name'])) {
			$idQ = $_POST['idQ'];
			$name = $_POST['name'];
			//se esta enviando el id de la lectura, no del quiz
			crearQuiz($name, $idQ);
			procesoPost($idQ, $name);
		} elseif (isset($_POST['idQE']) && isset($_POST['nameLE'])) {
			$idQuizReceived = $_POST['idQE'];
			$nameLEReceived = $_POST['nameLE'];
			crearPregunta($idQuizReceived, $nameLEReceived);
		} elseif (isset($_POST['id_pregunta']) && isset($_POST['p_correcta'])) {

			$option1 = $_POST['op1'];
			$option2 = $_POST['op2'];
			$option3 = $_POST['op3'];
			$option4 = $_POST['op4'];
			$id_pregunta = $_POST['id_pregunta'];
			$valor = $_POST['p_correcta'];
			guardarOpciones($option1, $option2, $option3, $option4, $id_pregunta, $valor);
		} elseif (isset($_POST['id_quiz_res']) && isset($_POST['title_quiz'])) {
			$idQuizRes2 = $_POST['id_quiz_res'];
			$quizTitleToResponse = $_POST['title_quiz'];
			procesoPost4($idQuizRes2, $quizTitleToResponse);
		} elseif (isset($_POST['idDel']) && isset($_POST['delete'])) {
			$idDelete = $_POST['idDel'];
			deleteLecture($idDelete);
		} elseif (isset($_POST['puntajeTotal'])) {
			$pTotal = $_POST['puntajeTotal'];
			procesoPost5($pTotal);
		}


		break;
	case 'PUT':
		break;
	case 'DELETE':

		break;
}


//Metodos
function Lecturas()
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM lecture");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
function verLectura($id)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM lecture where id='$id'");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
	exit();
}
function obtenerIdPregunta()
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT id_pregunta FROM questions ORDER by id_pregunta DESC LIMIT 1");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}

function enviarLecturas($name, $content)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = "INSERT INTO lecture(content, nombre) VALUES ('$content', '$name')";
	$statement = $dbConn->prepare($sql);
	$statement->execute();
	echo json_encode('¡Lectura creada exitosamente!');
}
function crearPregunta($idQuiz, $nameLectQuiz)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = "INSERT INTO questions(qns, id_quiz) VALUES ('$nameLectQuiz', '$idQuiz')";
	$statement = $dbConn->prepare($sql);
	$statement->execute();
}



function proceso($dataRecived)
{
	session_start();
	$_SESSION['DATA']  = $dataRecived;
}

function procesoPost($dataRecivedId, $dataRecivedName)
{
	session_start();
	$_SESSION['DATAS'] = array();
	$_SESSION['DATAS']['DATAID']  = $dataRecivedId;
	$_SESSION['DATAS']['DATANAME']  = $dataRecivedName;
}
function procesoPost3($idQuiz3)
{
	session_start();
	$_SESSION['IDQUIZ'] = $idQuiz3;
}
function procesoPost4($idResolver, $quizTitle)
{
	session_start();
	$_SESSION['QUIZDATAS'] = array();
	$_SESSION['QUIZDATAS']['IDRESQUIZ'] = $idResolver;
	$_SESSION['QUIZDATAS']['QUIZTITLE'] = $quizTitle;
}
function procesoPost5($res)
{
	session_start();
	$_SESSION['RESULTADO'] = $res;
}

function llega()
{
	session_start();
	echo json_encode($_SESSION['DATA']);
}
function llegaPost()
{
	session_start();
	echo json_encode($_SESSION['DATAS']);
	//echo json_encode($_SESSION['DATANAME']);
}
function llegaPost3()
{
	session_start();
	echo json_encode($_SESSION['IDQUIZ']);
}
function llegaPost4()
{
	session_start();
	echo json_encode($_SESSION['QUIZDATAS']);
}
function llegaPost5()
{
	session_start();
	echo json_encode($_SESSION['RESULTADO']);
}
function crearQuiz($name, $idLectura)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = "INSERT INTO quiz(title, id_lecture) VALUES ('$name','$idLectura')";
	$statement = $dbConn->prepare($sql);
	//bindAllValues($statement, $input);
	$statement->execute();
	echo json_encode('Quiz creado');
}
function obtenerIdQuiz()
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM quiz ORDER by id DESC LIMIT 1");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}


function guardarOpciones($opcion1, $opcion2, $opcion3, $opcion4, $idPreguntaAsig, $valorCorrecto)
{

	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = "INSERT INTO options(choice, id_question) VALUES ('$opcion1','$idPreguntaAsig'),
		('$opcion2','$idPreguntaAsig'),
		('$opcion3','$idPreguntaAsig'),
		('$opcion4','$idPreguntaAsig');
		INSERT INTO answers(id_question_rel, answer) VALUES ('$idPreguntaAsig','$valorCorrecto')
		";
	$statement = $dbConn->prepare($sql);
	$statement->execute();
	echo json_encode('Guardado exitoso');
}

function guardarOpcionCorrecta($idPreguntaCorrecta, $valorCorrecto)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = "INSERT INTO answers(id_question_rel, answer) VALUES ('$idPreguntaCorrecta','$valorCorrecto')";
	$statement = $dbConn->prepare($sql);
	//bindAllValues($statement, $input);
	$statement->execute();
	echo json_encode('Quiz creado');
}

function deleteLecture($idDelete)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$statement = $dbConn->prepare("DELETE FROM lecture where id='$idDelete'");
	$statement->execute();
	header("HTTP/1.1 200 OK");
	echo json_encode('Lectura borrada exitosamente');
}

//Metodos examenes

function ListarExamenes()
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM quiz");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
function ListarExamen($idQuizRes1)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM questions WHERE '$idQuizRes1'=id_quiz");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
function ListarOpciones($idPreguntaOpcion)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM options WHERE '$idPreguntaOpcion'=id_question");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
function ObtenerRespuesta($idPreguntaResponder)
{
	require('../php/config.php');
	require('../php/utils.php');
	$dbConn =  connect($db);
	$sql = $dbConn->prepare("SELECT * FROM answers WHERE '$idPreguntaResponder'=id_question_rel");
	$sql->execute();
	$data = $sql->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
