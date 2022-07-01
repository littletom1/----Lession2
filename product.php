<?php
     $filepath = realpath(dirname(__FILE__));
     include_once  ($filepath.'/lib/database.php');
     include_once  ($filepath.'/lib/format.php');
?>

<?php
    class product
    {
        private $db;
        private $fm;

            public function __construct()
            {
                $this->db = new Database();
                $this->fm = new Format();
            }

            public function insert_product($data, $files)
            {
                $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
                $category = mysqli_real_escape_string($this->db->link, $data['categories']);

                //check image and put into upload folder
                $permited = array('jpg', 'jpeg', 'png', 'gif');
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_temp = $_FILES['image']['tmp_name'];

                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
                $uploaded_image = "uploads/".$unique_image;

                //check field
                if($productName==""  || $category=="" || $file_name == ""){
                    $alert = "<span class='error'>EMPTY!!!</span>";
                    return $alert;
                }else{
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query = "INSERT INTO product(productName, cat_id, image) VALUES ('$productName','$category','$unique_image')";
                    $result = $this->db->insert($query);
                    if($result){
                        $alert = "<span class='success'>Add product successfully</span>";
                        return $alert;
                    }else{
                        $alert = "<span class='error'>Can't insert product</span>";
                        return $alert;
                    }       
                } 
            }

            public function show_product()
            {
                $query = "
                SELECT product.*,categories.catName

                FROM product INNER JOIN categories ON product.cat_id = categories.cat_id
                
                order by product.id desc";
                    $result = $this->db->select($query);
                    return $result;
            }

            //update product
            public function update_product($data, $file, $id){

            }

            public function del_product($id){
                $query = "DELETE FROM product WHERE id = '$id'";
                    $result = $this->db->delete($query);
                    if($result){
                        $alert = "<span class='success'>Delete Successfully</span>";
                        return $alert;
                    }else{
                        $alert = "<span class='error'>ERROR!!</span>";
                        return $alert;
                    }
                    return $result;
            }
            //get details product
            public function get_product($id){
                $query = "
                SELECT product.*,categories.catName

                FROM product INNER JOIN categories ON product.cat_id = category.cat_id

                where product.id ='$id'
                
                ";
                    $result = $this->db->select($query);
                    return $result;

            }

            //get all product
            public function readAll($from_record_num, $records_per_page){
  
                $query = "SELECT
                            productName, cat_id, image
                        FROM
                            product
                        ORDER BY
                            productName ASC
                        LIMIT
                            {$from_record_num}, {$records_per_page}";
              
                $result = $this->db->select($query);
                return $result;
                }

            //count all
            public function countAll(){
  
                $query = "SELECT id FROM product"  ;
              
                $stmt = $this->db->select( $query );
                //$num = $stmt->rowCount();
              
                return $stmt;
            }

            //read one
            function readOne(){
  
                $query = "SELECT
                            productName, cat_id, image
                        FROM
                            product
                        WHERE
                            id = ?
                        LIMIT
                            0,1";
              
                $stmt = $this->db->select( $query );
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
              
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
              
                $this->productName = $row['productName'];
                $this->cat_id = $row['cat_id'];
                $this->image = $file['image'];

            }
    }
?>