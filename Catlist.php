<?php include './category.php';?>

<?php
    $cat = new category();
    if(isset($_GET['delid'])) {
        $id = $_GET['delid'];
        $delcat = $cat->del_category($id);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$catName = $_POST['catName'];

        $insertCat = $cat->insert_category($catName);
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h3>Category Management</h3>
        <input type="button" onclick="window.location.href = 'http://localhost/PG_TEST/index.php'" value="Product"/>
        <?php
            if(isset($delcat)){
                echo $delcat;
            }
        ?>
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addcat">Add Category</button>
        <!-- Modal -->
        <div class="modal fade" id="addcat" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Add Category</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($insertCat)){
                                echo $insertCat;
                            }
                        ?>
                        <div class="form-group">
                            <label>Category name</label>
                            <input type="text" name="catName" class="form-control">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit"></input>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>
                    </form>
                </div>
            </div>
            
            </div>
        </div>
        <div class="input-group rounded">
          <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
          <span class="input-group-text border-0" id="search-addon">
            <button class="fas fa-search"></button>
          </span>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Operation</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $show_cate = $cat->show_category();
                    if($show_cate){
                        $i = 0;
                        while($result = $show_cate->fetch_assoc()){
                            $i++;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $result['catName'] ?></td>
                    <td><a onclick = "return confirm('Are you sure?')" href="?delid=<?php echo $result['cat_id'] ?>">Delete</a></td>
                </tr>
                <?php
                }
                     }
                ?>
            </tbody>
        </table>
    </div>
</body>