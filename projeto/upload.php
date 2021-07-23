    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $file = $_FILES['imagem'];

        if (empty($file)) {
            echo "File is empty";
        } else {

            move_uploaded_file($file["tmp_name"], "webcam.jpg");
          

        }
        
    }
?>