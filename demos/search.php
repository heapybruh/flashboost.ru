<?php
    $query = (isset($_POST["query"]) && strlen($_POST["query"]) <= 48) ? $_POST["query"] : "";
    $region = (isset($_GET["region"]) && in_array($_GET["region"], ["eu", "na"])) ? $_GET["region"] : header("Location: /");;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ClassicCounter / Demos</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <link href="/source/style.css" rel="stylesheet">
    </head>

    <body data-bs-theme="dark">
        <div class="d-flex flex-column align-items-center h-100 p-3">
            <h1>
                Demos
            </h1>

            <div class="table d-flex flex-row m-1">
                <a href="/" class="btn btn-dark">Back</a>

                <form class="d-flex flex-row" method="post">
                    <input type="text" class="form-control mx-2" name="query" placeholder="pug_2024-01-01_0000_de_example.dem" maxlength="48">
                    <button type="submit" class="btn btn-dark">Search</button>
                </form>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Filename</th>
                        <th scope="col">Size</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $files = array();

                        $directory = new DirectoryIterator($_SERVER["DOCUMENT_ROOT"] . "/demos/" . $region);

                        foreach ($directory as $file) {
                            if($file->isDot() 
                                || !str_contains($file->getFilename(), $query) 
                                || !$file->getSize()
                                || !in_array($file->getExtension(), ["dem", "bz2"])
                            )
                                continue;

                            $files[] = '
                                <tr>
                                    <td>
                                        <a href="/demos/' . $region . '/' . $file->getFilename() . '" class="link-underline link-underline-opacity-0">
                                            ' . $file->getFilename() . '
                                        </a>
                                    </td>

                                    <td>
                                        ' . round($file->getSize() / 1_000_000) . ' MB
                                    </td>
                                </tr>
                            ';
                        }

                        foreach(array_reverse($files) as $file)
                            echo($file);
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>