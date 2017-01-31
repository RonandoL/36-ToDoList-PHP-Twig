<?php
            // Required Red Tape
              date_default_timezone_set('America/Los_Angeles');
              require_once __DIR__."/../vendor/autoload.php";
              require_once __DIR__."/../src/tasks.php";

              session_start();            // For global variable, saving in browser cache
              if (empty($_SESSION['array_of_tasks'])) {
                  $_SESSION['array_of_tasks'] = array();
              }

              $app = new Silex\Application();

              $app->register(new Silex\Provider\TwigServiceProvider(), array(
                  'twig.path' => __DIR__.'/../views'
              ));                  // look for our template files in a folder called views

  // 1. Route to Homepage - Displays tasks, form & buttons
    $app->get("/", function() use ($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));  // This tells the $app object to use Twig to render a file called tasks.html.twig (our template file).  pass an array of all tasks into the template. All this route has to do (with Twig now) is get the data that our template needs and pass it in to render the template, and all the template needs to do is display the data. Cleaner than previously
    });

  // 2. Route for post request for /tasks (where it will display newly created task)
    $app->post("/tasks", function() use ($app) {
        $task = new Task($_POST['task']);
        $task->save();
        return $app['twig']->render('create_task.html.twig', array('newtask' => $task));
    });

  // 3. Rout for post request to DELETE all tasks
    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('delete_tasks.html.twig');
    });





    return $app;




?>
