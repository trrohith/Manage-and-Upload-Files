<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Auto Print</title>
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="page-header">
        <h1>Automatically Print<small> All uploaded PDFs</small></h1>
    </div>
    <div class="bd-content">
          <h1 class="bd-title" id="content">Information</h1>
          <p>Just upload a PDF file and it will be printed using the default settings in colour on A4 paper. After you are sure it has been printed you can delete the file. To print more than one copy or otherwise for an error just delete the file and upload it again.</p>
          </div>
          <br>
           <div class="container">
        <?php
        include "config.php";
        if(isset($_FILES['file'])){
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            $type = $_FILES['file']['type'];
            $tmp = $_FILES['file']['tmp_name'];
            $filename = 'uploads/'.$_FILES['file']['name'];
            if(!file_exists($filename)){
            $moveFile = move_uploaded_file($tmp,$filename);
            if($moveFile){
                $query = "INSERT INTO `files`(`id`, `name`) VALUES (NULL,'$name')";
                $result = $db->query($query);
                if($result){
                    ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> File uploaded.
        </div>
        <?php
                }
                else{
                    ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> File not uploaded. Database
        </div>
        <?php
                }
            }
            else{
                ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error!</strong> File not uploaded.
        </div>
        <?php
            }
        }
        else{
                ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Info!</strong> File already exists.
        </div>
        <?php
            }
        }
        
        ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="filer">Upload File</label>
                <input type="file" id="file" name="file" accept="application/pdf">
                <p class="help-block">Select the file</p>
            </div>
            <button type="submit" class="btn btn-default">Upload</button>
        </form>
        <p><br/></p>
        <div class="row">
            <?php
        if(isset($_GET['delete'])){
            $name = $_GET['delete'];
            $id = $_GET['id'];
            $delete = unlink('uploads/'.$name);
            if($delete){
                $query = "DELETE FROM `files` WHERE id='$id'";
                $result = $db->query($query);
                if($result){
                    ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> File deleted.
            </div>
            <script>
                location.href='index.php'
            </script>
            <?php
                }
                else{
                    ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> File not deleted. Database
            </div>
            <script>
                location.href='index.php'
            </script>
            <?php
                }
            }
            else{
                ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Error!</strong> File not deleted.
            </div>
            <script>
                location.href='index.php'
            </script>
            <?php
            }
        }
        $query = $db->prepare("select * from files");
        $query->execute();
        while($row = $query->fetch()){
        ?>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <p align="center"><a href="uploads/<?php echo $row['name']?>" target="_blank"><strong><?php echo $row['name']?></strong></a></p>
                    <img style="height:128px;" src="PDF.png" alt="<?php echo $row['name']?>" title="<?php echo $row['name']?>">
                    <div class="caption text-center">
                        <p><a href="?delete=<?php echo $row['name']?> &id=<?php echo $row['id']?>" class="btn btn-danger" role="button">Delete</a></p>
                    </div>
                </div>
            </div>
            <?php
            }
        ?>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.cssjs/bootstrap.min.js"></script>
</body>

</html>