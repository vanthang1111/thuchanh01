<?php
// Kiểm tra sự tồn tại của tham số id trước khi xử lý thêm
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include file config.php
    require_once "config.php";
    
    // Chuẩn bị câu lệnh Select
    $sql = "SELECT * FROM employees WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Liên kết các biến với câu lệnh đã chuẩn bị
        $stmt->bindParam(":id", $param_id);
        
        // Thiết lập tham số
        $param_id = trim($_GET["id"]);
        
        // Cố gắng thực thi câu lệnh đã chuẩn bị
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Lấy hàng kết quả dưới dạng một mảng kết hợp. Vì tập kết quả chỉ chứa một hàng, chúng tôi không cần sử dụng vòng lặp while */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Lấy giá trị trường riêng lẻ
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // URL không chứa tham số id hợp lệ. Chuyển hướng đến trang error
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oh, no. Có gì đó sai sai. Vui lòng thử lại.";
        }
    }
     
    // Đóng câu lệnh
    unset($stmt);
    
    // Đóng kết nối
    unset($pdo);
} else{
    // URL không chứa tham số id. Chuyển hướng đến trang error
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>