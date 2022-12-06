<?php

// db connection
include('./config/db_connection.php');

    $input = '';
    // $errors = array('input' => '');




// Get all action

// query for all
$sql = 'SELECT * FROM todos';

// make query and get result
$result = mysqli_query($conn, $sql);

// fetching and turning data to assoc array
$todos  = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free memory
mysqli_free_result($result);



// Add to database
// check title
if(empty($_POST['input'])){
    $errors['input'] =  'A input is required <br />';
} else{
    $input = $_POST['input'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $input)){
        $errors['input'] =  'input must be letters and spaces only';
    }
}

if(array_filter($errors)){
    // echo 'there are errors in the form';
} else {
    $input = mysqli_real_escape_string($conn, $_POST['input']);

    // create sql
    $sql = "INSERT INTO todos(content) VALUES('$input')";

    // save to db
    if(mysqli_query($conn, $sql)){
        // success;
        // echo 'form is valid';
    header('Location: index.php');
    } else {
        // error
        echo 'query error: ' . mysqli_error($conn);
    }
};


// Update databas
$('.check-input').click(function(){
    $done = "done";
    $undone = "undone";

    $id_to_update = mysqli_real_escape_string($conn, $_POST['id_to_change']);

        $Sql = "SELECT * FROM todos WHERE id = $id_to_change";

        // make query and get result
        $data = mysqli_query($conn, $Sql);
        
        // fetching and turning data to assoc array
        $todos  = mysqli_fetch_all($data, MYSQLI_ASSOC);
        
    if ($(this).is(':checked')){
    //   if (isset($_POST['change'])){
           // make sql
            $sql = "UPDATE `todos` SET `status`= 'done' WHERE id = $id_to_change";
            $result = mysqli_query($conn, $sql);
            // fetching the resulting rowa as an array
      //   if($result){
        // success
        // header('Location: index.php');
       //   } else {
       //     // failure
       //     echo 'query error: ' . mysqli_error($conn);
      //   }

    } else {
        // uncheck
        $sql = "UPDATE `todos` SET `status`= 'undone' WHERE id = $id_to_change";
        $result = mysqli_query($conn, $sql);
    }
});




// Delete action
if (isset($_POST['delete'])){

    // escape sql chars
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
    
    // make sql
    $sql = "DELETE FROM todos WHERE id = $id_to_delete";


  if(mysqli_query($conn, $sql)){
    // success
    header('Location: index.php');
  } else {
    // failure
    echo 'query error: ' . mysqli_error($conn);
  }

}

// close connection
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Todo-Web-2</title>
    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <div>
        <div class="whole-page">
            <div class="todo-card">
                <h1>Awesome Todo List</h1>
                <!-- todo input -->
                <div>
                    <form action="index.php" method="POST">
                        <input type="text" name="input" class="todo-input" placeholder="What do you need to do today?"
                            <?php echo htmlspecialchars($input);  ?> />
                        <button class="add-btn" type="submit">
                            Add
                        </button>
                        <!-- <div class="warning"</div> -->
                    </form>

                </div>
                <?php foreach($todos as $todo) { ?>
                <!-- todo list -->
                <?php
                $done = $todo['status'] == "undone" ? "" : "checked";
                $line = $todo['status'] == "undone" ? "" : "line-through";
                ?>
                <div class="todo-list">
                    <ul class="ul">
                        <li class="li">


                            <form action="index.php" method="POST">
                                <input type="hidden" name="id_to_change" value="<?php echo $todo['id'];?>">
                                <input type="checkbox" class="check-input" name="change" value="Change"
                                    <?php echo $done;?> />

                            </form>


                            <label class=" <?php echo $line ?> todo-label"
                                for=""><?php echo htmlspecialchars($todo['content']); ?></label>

                            <form action="index.php" method="POST">
                                <input type="hidden" name="id_to_delete" value="<?php echo $todo['id'];?>">
                                <button type="submit" name="delete" value="Delete" class="delete-btn">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </li>
                    </ul>

                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="./script.js"></script>
</body>

</html>