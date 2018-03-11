<?php

require('dbconnection.php');
require('model/Movie.php');
require('templates/functions.php');

 $ch = curl_init();

 $movieTitle = $_GET['searchbox'];

 if ($movieTitle == NULL) {
     $url = "https://api.themoviedb.org/3/discover/movie?page=1&include_video=false&include_adult=false&sort_by=popularity.desc&language=en-US&api_key=47096e9f413866406e8887e56411ced5";
 } else {
     $parsedTitle = str_replace(' ', '%20', $movieTitle);
     $url = "https://api.themoviedb.org/3/search/movie?api_key=47096e9f413866406e8887e56411ced5&language=en-US&query=".$parsedTitle."&page=1&include_adult=false";
 }

 $baseImageUrl = "http://image.tmdb.org/t/p/w185/";

     //Set the URL that you want to GET by using the CURLOPT_URL option.
    curl_setopt($ch, CURLOPT_URL, $url);
     //Set CURLOPT_RETURN TRANSFER so that the content is returned as a variable.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     //Set CURLOPT_FOLLOW LOCATION to true to follow redirects.
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
     //Set method to GET
    curl_setopt($ch, CURLOPT_HTTPGET, true);

    //Execute the request.
    $data = curl_exec($ch);

    //Close the cURL handle.
    curl_close($ch);
    $json_output = json_decode($data);

    $results = $json_output->results;
?>

<?php include 'templates/header.html'; ?>
    <h3>Popular Movies</h3>

    <div class="row">
        <?php

            foreach($results as $k=>$v){

                $posterPath = $v->poster_path;

                if ($posterPath != NULL) {
                    $title = $v->title;
                    $overview = $v->overview;
                    $releaseDate = $v->release_date;
                    $filmId = $v->id;
                    $voteAverage = $v->vote_average;

                    # TEST
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.themoviedb.org/3/movie/". $filmId ."?language=en-US&api_key=47096e9f413866406e8887e56411ced5",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_POSTFIELDS => "{}",
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    $json_outputResponse = json_decode($response);
                    $imdbId = $json_outputResponse->imdb_id;

                    curl_close($curl);

                    #TEST

                    $genreIds = $v->genre_ids;
                    $dataStringGenreIds = serialize($genreIds);

                    $parts = explode('-', $releaseDate);
                    $releaseYear = $parts[0];

                    $posterPathUrl = $baseImageUrl.$posterPath;
        ?>
                <div class="col-md-6">
                   <form name="addToWishListForm" action="confirmation.php" method="post" >

                        <input type="hidden" id="movieTitle" name="movieTitle" value="<?php echo $title; ?>">
                        <input type="hidden" id="releaseYear" name="releaseYear" value="<?php echo $releaseYear; ?>">
                        <input type="hidden" name="genre_list_main" value="<?php echo $dataStringGenreIds; ?>">
                        <input type="hidden" id="imdbId" name="imdbId" value="<?php echo $imdbId; ?>">
                        <input type="hidden" id="description" name="description" value="<?php echo $overview?>">

                            <div class="media" style="border: 1px solid lightgray">
                                <img class="align-self-start mr-3"  src="<?php echo $posterPathUrl; ?>" alt="<?php echo $title; ?>">
                                <div class="media-body">
                                    <h5 class="mt-0"><?php echo $title; ?></h5>
                                    <p> (<?php echo $releaseYear;?>) </p>
                                    <p>  <?php echo $voteAverage; ?>/10</p>
                                    <p class="overview"> <?php echo truncate($v->overview, 300); ?> </p>
                                </div>

                                <?php
                                if (!(Movie::is_Dupe_IMDB_ID($imdbId))) {
                                    echo '<p>';
                                    echo '<button type="submit" class="btn btn-info btn-rounded"> + WatchList</button>';
                                    echo '</p>';
                                } else {
                                    echo '<p>';
                                    echo '<button type="button" class="btn btn-info btn-rounded" disabled>On list</button>';
                                    echo '</p>';
                                }
                                ?>

                            </div>
                            <br>

                   </form>
                </div>



             <?php
                }

            }
        ?>
    </div> <!-- end div row -->

<?php include 'templates/footer.html'; ?>
