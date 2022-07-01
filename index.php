<?php
  $filepath = realpath(dirname(__FILE__));
  include './category.php';
  include './product.php';
  include_once  ($filepath.'/lib/format.php');
?>

<?php

  $fm = new Format();

  $pd = new product();
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
		

        $insertProduct = $pd->insert_product($_POST, $_FILES);
      
	}

 


  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])){
		

        $updateProduct = $pd->update_product($_POST, $_FILES, $id);
		
	}

  if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$delpro = $pd->del_product($id);
	}


  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  
  // set number of records per page
  $records_per_page = 10;
    
  // calculate for the query LIMIT clause
  $from_record_num = ($records_per_page * $page) - $records_per_page;

  $database = new database();
  $db = $database->connectDB();
    
  $product = new product($db);
  $category = new category($db);
    
  // query products
  $stmt = $product->readAll($from_record_num, $records_per_page);
  //$num = $stmt->rowCount();

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Product Management</h2>
        <input type="button" onclick="window.location.href = 'http://localhost/PG_TEST/index.php'" value="Product"/>
        <input type="button" onclick="window.location.href = 'http://localhost/PG_TEST/Catlist.php'" value="Category"/>
        <?php  
        if(isset($delpro)){
          echo $delpro;
        }
        ?>
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
              <th>Product name</th>
              <th>Category</th>
              <th>Image</th>
              <th>Operation</th>
            </tr>
          </thead>
          <tbody>
            
            <tr>

            <!-- show product -->
            <?php
              $pd = new product();

              $pdlist = $pd->show_product();
              if($pdlist){
                $i=0;
                while($result = $pdlist->fetch_assoc()){
                  $i++;
              ?>
                <tr>
                  <td><?php echo $i?></td>
                  <td><?php echo $result['productname']?></td>
                  <td><?php echo $result['catName']?></td>
                  <td> <img src="uploads/<?php echo $result['image']?>"></td>
                  <td>
                    <button class="add" data-toggle="modal" data-target="#add">
                      <i class="fas fa-plus"></i>
                  </button>
                  <!-- add modal -->
                  <div class="modal" id="add">
                    <div class="modal-dialog">
                      <div class="modal-content">
                  
                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Add new Product</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                  
                        <!-- Modal body -->
                        <div class="modal-body">
                          <!-- add product name -->
                          <?php
                            if(isset($insertProduct)){
                              echo $insertProduct;
                            }
                          ?>
                          <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                              <label>Product name</label>
                              <input type="text" name="productName" class="form-control">
                            </div>
                            <!-- add Category -->
                            <div>
                              <label>Category</label>
                              <div>
                                <select name="categories">
                                      <option>Categories</option>
                                      <?php 
                                      $cat = new Category();
                                      $catlist = $cat->show_category();
                                      if($catlist){
                                          while($result = $catlist->fetch_assoc()){
                                      ?>
                                      <option value="<?php echo $result['cat_id'] ?>"><?php echo $result['catName'] ?></option>
                                      <?php
                                              }
                                          }
                                      ?>
                                </select>
                              </div>
                            </div>
                            <!-- add image -->
                            <div class="form-group">
                              <label for="exampleFormControlFile1">Product image</label>
                              <input type="file" name="image" class="custom-file">
                            </div>
                            <div class="form-group">
                              <input type="submit" name="submit" class="btn btn-primary" value="Submit"></input>
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                          </div>
                      </div>
                    </div>
                  </div>
                  <!-- read product -->
                  <button class="read" name="read" data-toggle="modal" data-target="#readdetails">
                      <i class="fab fa-readme"></i>
                      <!-- read modal -->
                      <div class="modal" id="readdetails">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Product Details</h4>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                              
                            </div>

                          </div>
                     </div>
                          

                  </button>
                  <!-- edit product -->
                  <button class="update" data-toggle="modal" data-target="#editProduct">
                      <i class="fas fa-pen"></i>
                      <!-- editmodal -->
                      <div class="modal" id="editProduct">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Product</h4>
                            </div>
                            <!-- edit Modal body -->
                            <div class="modal-body">
                              
                            </div>
                          </div>
                      </div>
                  </button>
                  <!-- delete product -->
                  <button >
                      <i class="fas fa-minus-circle" onclick = "return confirm('You want to delete this product?')" href="?id=<?php echo $result['id']?>"></i>
                  </button>
                   
                </tr>
              <?php
                  }
                }
            ?>
              
            </tr>
          </tbody>
        </table>
        <?php
        $page_url = "index.php?";
  
        // count all products in the database to calculate total pages
        $total_rows = $product->countAll();
          
        // paging buttons here
        include_once 'paging.php';
        ?>
      </div>
</body>
</html>