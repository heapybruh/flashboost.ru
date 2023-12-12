<?php
    $query = (isset($_POST["query"]) && strlen($_POST["query"]) <= 32) ? $_POST["query"] : "";
    $compressed = (isset($_GET["compressed"]) && $_GET["compressed"] == 1) ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.5">
        <title>ClassicCounter / Maps</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link href="/source/style.css" rel="stylesheet">
    </head>

    <body data-bs-theme="dark">
        <div class="d-flex flex-column align-items-center h-100 p-3">
            <h1>
                Maps
            </h1>

            <div class="table d-flex flex-row m-1">
                <a href="/" class="btn btn-dark">Back</a>

                <form class="d-flex flex-row" method="post">
                    <input type="text" class="form-control mx-2" name="query" placeholder="de_example.bsp" maxlength="32">
                    <button type="submit" class="btn btn-dark">Search</button>
                </form>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 440px">Filename</th>
                        <th scope="col" style="width: 72px">Size</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $files = array();
                        $directory = new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/fastdl/maps/");

                        foreach ($directory as $file)
                            if ($file->isFile())
                                $files[] = $file;

                        sort($files, SORT_NATURAL);

                        foreach ($files as $file) {
                            if (!str_contains($file->getFilename(), $query) 
                                || !$file->getSize() 
                                || ((
                                    $compressed && ($file->getExtension() != "bz2") 
                                    || !$compressed && ($file->getExtension() != "bsp")
                                ))
                            )
                                continue;

                            echo '
                                <tr>
                                    <td>
                                        <a href="/fastdl/maps/' . $file->getFilename() . '" class="link-underline link-underline-opacity-0">
                                            ' . $file->getFilename() . '
                                        </a>
                                    </td>

                                    <td>
                                        ' . round($file->getSize() / 1_000_000) . ' MB
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>