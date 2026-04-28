<?php
require 'include/db.php';

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];

    // Handle image upload
    $image = "";

    // handle image upload
    if (!empty($_FILES['image']['name'])) {

        $image = time() . "_" . $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        // make sure uploads folder exists
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }

        move_uploaded_file($tmp, "uploads/" . $image);
    }

    // insert into database
    $conn->query("INSERT INTO products (name, category, price, quantity, brand, image)
    VALUES ('$name', '$category', '$price', '$quantity', '$brand', '$image')");

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <style>
        body {
            background: #f4f6f9;
        }
        .card {
            border-radius: 12px;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn {
            border-radius: 20px;
        }
    </style>
</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow p-4">

                <h3 class="text-center mb-4">✏️ Edit Product</h3>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control"
                               value="<?= $product['name'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control"
                               value="<?= $product['category'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control"
                               value="<?= $product['price'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control"
                               value="<?= $product['quantity'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">brand</label>
                        <input type="text" name="brand" class="form-control"
                               value="<?= $product['brand'] ?>" required>
                    </div>

                    <div class="mb-3">
                   <label class="form-label">Product Image</label>
                   <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                   <p class="hint">Upload JPG / PNG / GIF image only.</p>
                   <img id="preview" class="preview-img">
                   </div>
                    

                    <button type="submit" name="update" class="btn btn-warning w-100">
                        Update Product
                    </button>

                    <a href="index.php" class="btn btn-secondary w-100 mt-2">
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>