<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if($_SERVER['REQUEST_METHOD'] == "GET")
{
    // When the user clicks on the create account button
   
    

        // Reading from the data base
        $query = "select * from products";

        $result = mysqli_query($con, $query);
        // print_r( $result);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $products_data = mysqli_fetch_all($result);
            }
        }
    
    else{
        echo "problem in getting data";
    }

}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg bg-light">
          <div class="container-fluid">
              <a class="navbar-brand" href="#">C S M</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarScroll">
              <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                  <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Link
                  </a>
                  <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                  </li>
                  <li class="nav-item">
                  <a class="nav-link disabled">Link</a>
                  </li>
              </ul>
              
                  <span class="align-middle mr-2">
                      <h1 class="display-4 fs-5 text-left ">Welcome, <?php echo $user_data['user_name']; ?> </h1>
                  </span>
                  <a href="logout.php">
                      <button class="btn btn-warning  m-1" type="submit">Log out</button>
                  </a>
              </div>
          </div>
      </nav>
      
      <div class="row mt-2 justify-content-center">
          <div class="col-6">
              <h1 class="display-4 fs-3 "><b>Content Scheduling and Management</b></h1>
          </div>
      </div>
  
  
      

      <div class="row mt-4">
            <div class="row">
                <a href="addproducts.php">
                    <button class="btn btn-success  ml-2" type="button">Add product</button>
                </a>
            </div>
        
          <?php for ($row = 0; $row < count($products_data); $row++) { ?>
          <div class="col-4">
              <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                  <div class="col-md-6">
                    <img src="..." class="img-fluid rounded-start" alt="...">
                  </div>
                  <div class="col-md-6  bg-light">
                  
                    <div class="card-body">
                      <?php  for ($col = 1; $col < 4; $col++) { ?>
                      <h1 class="display-4 fs-5 "><?php echo $products_data[$row][$col] ?></h1>
                      <?php }?>
                      <div class="container mt-4 justify-content-center">
                        <div class="row">
                          <div class="col-4">
                            <button type="button" class="btn btn-success" onclick="quantity_counter(1,<?php echo $products_data[$row][0] ?>)">+</button>
                          </div>

                          <div class="col-4">
                            <p class="text-center" name="quantity" id="<?php echo $products_data[$row][0] ?>">0</p>
                          </div>

                          <div class="col-4">
                            <button type="button" class="btn btn-warning"  onclick="quantity_counter(-1, <?php echo $products_data[$row][0] ?>)">-</button>
                          </div>
                        </div>
                      
                        <div class="row">
                          <button type="button" class="btn btn-primary mt-2 mx-auto" onclick="add_to_cart(<?php echo $products_data[$row][0] ?>,
                                                                                                          '<?php echo strval( $products_data[$row][1]);?>', 
                                                                                                          '<?php echo strval( $products_data[$row][2]);?>',
                                                                                                          '<?php echo strval( $products_data[$row][3]);?>'
                                                                                                          )">
                            Add to cart
                          </button>
                        </div>
                      </div>

                    </div> 
                  </div>
                </div>
              </div>
            </div>
           
        <?php }?>        
      </div>
      <footer class="footer">
        <div class=" text-center bg-light">
          <a href="checkout.php">
              <button class="btn btn-success  m-2" type="button">Check out</button>
          </a>
        </div>
      </footer>
      <script>
        var check = 1;
        function add_to_cart(product_id,product_name,
                            product_brand,product_type)
        {
          if (check == 1)
          {
            localStorage.clear();
            check = 2;
          }
          console.log(product_id,product_name,
                            product_brand,product_type);

        var quantity = parseInt(document.getElementById(String(product_id)).innerHTML);
        console.log(quantity)
        var product_data = {
        "product_id"    : product_id,
        "product_name"  : product_name,
        "product_brand" : product_brand,
        "product_type"  : product_type,
        "quantity"      : quantity
        }

        data = JSON.stringify(product_data);
        // data = JSON.parse(data_crude);

         localStorage.setItem(product_id, data);
        //  console.log(JSON.parse(localStorage.getItem(7)));
        }


        function quantity_counter(operation,element_id)
        {
          // localStorage.clear();
          // var i = localStorage.getItem(6);
          // var obj = JSON.stringify(i);
          // alert(JSON.stringify(i));
          // console.log(obj);
          value = parseInt(document.getElementById(String(element_id)).innerHTML);
          if (operation > 0)
          {
            document.getElementById(String(element_id)).innerHTML = value + 1;
          }
          else
          {
            if(value > 0)
            document.getElementById(String(element_id)).innerHTML = value - 1;
            else
            {
              document.getElementById(String(element_id)).innerHTML = value;
            }
          }
          
        }
        </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>

