<?php

require '../vendor/autoload.php';

class FilesContr extends Files
{

    //get employee contract
    public function getEmployeeContract($id)
    {
        $result = $this->getUsersContract($id);
        return $result;
    }

    //check if user has a contract
    public function checkAndDeleteOldContract($id)
    {
        $contract = $this->getEmployeeContract($id);
        $filename = $contract[0]['file_name'];

        if ($filename != "") {
            $result = false;
            if (unlink($filename) == true) {
                $result = true;
                $this->deleteContract($id);
            } else {
                $result = false;
            }
        }
        return $result;
    }

    //upload contract and move it to the contracts folder in includes
    public function uploadContract($id, $file, $corps_id, $file_type)
    {
        //if directory doesn't exist, create it
        if (file_exists('../includes/contracts')) {
            $target_dir = "../includes/contracts/";
        } else {
            mkdir('../includes/contracts');
            $target_dir = "../includes/contracts/";
        }

        $new_name = $id . "_" . $corps_id . "_" . basename($file["name"]);
        $target_file = $target_dir . $new_name;
        $error = "";
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            // echo "Sorry, file already exists.";
            $error = "fileAlreadyExists";
        }

        // Check file size
        if ($file["size"] > 20000000) {
            // echo "Sorry, your file is too large.";
            $error = "fileTooLarge";
        }

        // Allow certain file formats
        if (
            $imageFileType != "pdf"
        ) {
            // echo "Sorry, only pdf is allowed.";
            $error = "onlyPdfAllowed";
        }

        // Check if $uploadOk is set to 0 by an error
        if (!empty($error)) {
            echo $error;
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($file["name"])) . " has been uploaded.";
                $this->updateContract($id, $target_file, $corps_id, $file_type);
            } else {
                return false;
            }
        }
    }

    //Delete user contract
    public function deleteUserContract($id)
    {
        $this->deleteContract($id);
    }

    //take users images and combine them into a pdf
    // function combineImagesToPdf($images, $user_id)
    // {
    //     // Set the temporary directory where the images will be stored
    //     $tmp_directory = "../includes/tmp_directory/";

    //     // Loop through the array of images
    //     foreach ($images['name'] as $key => $value) {
    //         // Get the original file name
    //         $original_name = $images['name'][$key];

    //         // Set the temporary file path
    //         $tmp_file = $tmp_directory . $original_name;

    //         // Move the uploaded image to the temporary directory
    //         move_uploaded_file($images['tmp_name'][$key], $tmp_file);
    //     }

    //     // Create an instance of Imagick
    //     $imagick = new Imagick();

    //     // Set the resolution of the PDF
    //     $imagick->setResolution(300, 300);

    //     // Set the format to PDF
    //     $imagick->setFormat('PDF');

    //     // Loop through the array of images

    //     foreach ($images['name'] as $key => $value) {
    //         // Read the image file in the temporary directory into Imagick
    //         $imagick->readImage($tmp_directory . $images['name'][$key]);
    //     }

    //     // Save the PDF to a file
    //     $imagick->writeImages('combined.pdf', true);

    //     // Get today's date
    //     $date = date("Y-m-d");

    //     // Rename the file
    //     $new_filename = "../includes/reciepts/" . $date . "." . $user_id . ".reciepts.pdf";

    //     // Move the file to the reciepts folder
    //     rename("combined.pdf", "../includes/reciepts/$new_filename");

    //     return $new_filename;
    // }


    //Function to take array of files and combine them into a pdf do not use imagick
    function combineImagesToPdf($images, $user_id)
    {

        $ignored = false;
        // Set the temporary directory where the images will be stored
        $tmp_directory = "../includes/tmp_directory/";

        //random number to add to the end of the file name
        $random_number = rand(1000, 9999);

        // Loop through the array of images
        foreach ($images['name'] as $key => $value) {
            // Get the original file name
            $original_name = $images['name'][$key];

            // Set the temporary file path
            $tmp_file = $tmp_directory . $original_name;

            // Move the uploaded image to the temporary directory
            move_uploaded_file($images['tmp_name'][$key], $tmp_file);
        }

        // Get today's date
        $date = date("Y-m-d");

        // Rename the file
        $new_filename = "../includes/reciepts/" . $date . "." . $random_number . ".reciept.pdf";

        // Create a new PDF document
        $pdf = new setasign\Fpdi\Fpdi();

        // Loop through the array of images
        foreach ($images['name'] as $key => $value) {
            // Add a new page to the PDF
            $pdf->AddPage();

            // Set the temporary file path for the current image
            $tmp_file = $tmp_directory . $images['name'][$key];
            try {
                // Check if the current file is a PDF
                if (pathinfo($tmp_file, PATHINFO_EXTENSION) == 'pdf') {
                    // Include the PDF file as a page in the PDF document
                    $pdf->setSourceFile($tmp_file);
                    $page = $pdf->importPage(1);
                    $pdf->useTemplate($page);
                } else {
                    // Set the source image
                    $pdf->Image($tmp_file, 0, 0, 0, 297);
                }
            } catch (Exception $ignored) {
                $ignored = true;
            }
        }

        // Save the PDF to a file
        if ($ignored !== true)
            $pdf->Output("F", $new_filename);

        // Get a list of all the files in the temporary directory
        $files = glob($tmp_directory . '*');

        // Loop through the array of files
        foreach ($files as $file) {
            // Delete the file
            unlink($file);
        }
        if ($ignored !== true) {
            return $new_filename;
        } else {
            return false;
        }
    }

    //upload reciepts and move them to the reciepts folder in includes
    public function uploadReciepts($id, $files, $corps_id, $file_type, $info)
    {
        $file_name = $this->combineImagesToPdf($files, $id);
        $this->updateReciept($id, $file_name, $corps_id, $file_type, $info);
        return $file_name;
    }


    //get employee reciepts
    public function getEmployeeReciepts($id)
    {
        $reciepts = $this->getUsersReceipts($id);
        return $reciepts;
    }
}
