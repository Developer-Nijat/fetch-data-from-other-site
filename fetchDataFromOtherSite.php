<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Nijat Aliyev">
    <title>Fetch job posts from other site</title>
    <link rel="stylesheet" href="">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="well">
            <h3 align="center">
                The latest job postings
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 align="center">Fetch job posts from other site</h3>
                <hr>
                <div class="list-group">
                    <?php

                    include 'simple_html_dom.php';
                    // properties and example values
                    $website_url = "http://www.example.com";
                    $website_page = "http://www.example.com/vacancies";
                    $job_title = "Developer";
                    $html_element = "div.any-css-class";
                    // end
                    $html = file_get_html($website_page);

                    if ($html) {
                        // first write to log $html and look at html structure then apply elements and css classes
                        foreach ($html->find($html_element) as $article) {
                            $item['salary'] = $article->find('b.class-', 0)->plaintext;
                            $item['intro']  = $article->find('div.class', 0)->plaintext;
                            $item['title']  = $article->find('a.class-', 0)->plaintext;
                            $item['link']   = $article->find('a.class-', 0)->href;
                            $item['area']   = $article->find('b.class-', 0)->plaintext;

                            $htmlv = file_get_html($website_url . $item['link']);
                            // first write to log $htmlv and look at html structure then apply elements and css classes
                            if ($htmlv) {
                                foreach ($htmlv->find($html_element) as $vaxt) {
                                    $item['date'] = $vaxt->find('p.class-', 0)->plaintext;
                                }
                            }

                            if ($item['title'] == $job_title) {
                                echo '<a target="_blank" class="list-group-item list-group-item-default" href="' . $website_url . $item['link'] . '">
                                <span style="font-size: 25px;">' . $item['title'] . '</span> --- 
                                <span style="color: red; font-weight:bold;">' . $item['salary'] . '</span><br>
                                <p><b>Date:</b> - ' . $item['date'] . '</p>
                                <p style="font-size:16px;"><b>Address:</b> - ' . $item['area'] . '</p>
                                <p style="font-size:16px;"><b>Short desc:</b> - <i>' . $item['intro'] . '</i></p>
                                <p style="font-size:16px;"><u>Details.</u></p>
                                </a>';
                            }
                        }
                    } else {
                        echo ('No result found.');
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>