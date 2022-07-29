<?php
/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();

$currentNote = [
    'id' => '',
    'title' => '',
    'description' => '',
    'image' => ''
];
if (isset($_GET['id'])) {
    $currentNote = $connection->getNoteById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note Website</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
</head>

<body>
<nav class="navbar navbar-dark bg-light navbar-expand-sm">

        <div class="row" style="width:100%; height:100%">
            <div class="col-sm-6-md-3" style="width:0%; height:100%">
                <a href=""><img src="logo.png" alt=""> </a>
            </div>
            <div class="col-sm-6-md-9" style="width:100%; height:100%; text-align:center" >
                <h1 class="webname">Note taking</h1>
            </div>
    </div>        
</nav>


<div class="main-body">
    <form class="new-note" action="create.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $currentNote['id'] ?>">
        <input type="text" name="title" placeholder="Note title" autocomplete="off"
               value="<?php echo $currentNote['title'] ?>">
        <textarea name="description" cols="30" rows="4"
                  placeholder="Note Description"><?php echo $currentNote['description'] ?></textarea>
                   
                   
                   
                


        
            <?php if ($currentNote['id']): ?>
                <input type="file" name="image" value="<?php echo $currentNote['image'] ?>">
                 
                <button>Update</button>
            <?php else: ?>
                 
                <input type="file" name="image" value="<?php echo $currentNote['image'] ?>">
                   
                <button>New note</button>
            
            <?php endif ?>
      
    </form>
    <div class="notes">
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <div class="title">
                    <a href="?id=<?php echo $note['id'] ?>">
                        <?php echo $note['title'] ?>
                    </a>
                </div>
                <div class="description">
                    <?php echo $note['description'] ?>
                </div>
                <div class="image">
                    
                    <img src="image/<?php echo $note['image'] ?>" style="width:150px; height:100px;" alt="">
                    <?php $currentNote['image']=$note['image']; ?>
                </div>
                <small><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
                <form action="delete.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                    <button class="close">X</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>