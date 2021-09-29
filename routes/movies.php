<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

header('Access-Control-Allow-Origin: *');


//All Movies
$app->get('/movies/all-movies', function (Request $request, Response $response){
    $sql = "SELECT * FROM movies";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $movies = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db=null;
        $response->getBody()->write(json_encode($movies));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response   
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


//Selected Movie
$app->get('/movies/{id}', function (Request $request, Response $response, array $args){
    $id = $args['id'];
    $sql = "SELECT * FROM movies WHERE id_movie = $id";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->query($sql);
        $movies = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db=null;
        $response->getBody()->write(json_encode($movies));

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response   
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});


//Add Movie
$app->post('/movies/add-movie', function(Request $request, Response $response, array $args){
    $movie_name = $request->getParam('movie_name');
    $year_release = $request->getParam('year_release');
    $movie_director = $request->getParam('movie_director');
    $movie_review = $request->getParam('movie_review');
    $movie_img = $request->getParam('movie_img');

    $sql = "INSERT INTO movies (movie_name, year_release, movie_director, movie_review, movie_img) VALUE (:movie_name, :year_release, :movie_director, :movie_review, :movie_img)";

    try{
        $db = new DB();
        $conn = $db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':movie_name', $movie_name);
        $stmt->bindParam(':year_release', $year_release);
        $stmt->bindParam(':movie_director', $movie_director);
        $stmt->bindParam(':movie_review', $movie_review);
        $stmt->bindParam(':movie_img', $movie_img);

        $result = $stmt->execute();

        $db = null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e){
        $error = array("message"=> $e->getMessage());

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(500);
    }
});

