<?php
    $filepath = realpath(dirname(__FILE__));
    include_once  ($filepath.'/lib/database.php');
    include_once  ($filepath.'/format.php');

?>

<?php
    class Category
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_category($catName){
            $catName = $this->fm->validation($catName);
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            if(empty($catName)){
                $alert = "<span class='error'>NOT EMPTY</span>";
                return $alert;
            }else{
                $query = "INSERT INTO categories(catName) VALUES ('$catName')";
                $result = $this->db->insert($query);
                if($result){
                    $alert = "<span class='success'>Successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Error</span>";
                    return $alert;
                }       
            }
        }
        public function show_category(){
            $query = "SELECT * FROM categories order by cat_id desc";
            $result = $this->db->select($query);
            return $result;
        }

        public function getcatbyID($id){
            $query = "SELECT * FROM categories WHERE cat_id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function del_category($id){
            $query = "DELETE FROM categories WHERE cat_id = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Delete Category successfully</span>";
                return $alert;
            }else{
                $alert = "<span class='error'>Delete Error</span>";
                return $alert;
            }
            return $result;
        }
        public function get_product_by_cat($id){
            $query = "SELECT * FROM product WHERE cat_id = '$id' order by cat_id desc limit 8 ";
            $result = $this->db->select($query);
            return $result;
        }

        public function get_name_by_cat($id){
            $query = "SELECT  product.*,categories.catName, categories.cat_id FROM product, categories WHERE product.cat_id = categories.cat_id AND product.cat_id = '$id' limit 1 ";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>