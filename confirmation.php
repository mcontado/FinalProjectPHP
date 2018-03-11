<?php
header("refresh: 5; url=index.php");

require('dbconnection.php');
require('model/Movie.php');

$movieTitle = $_POST['movieTitle'];
$releaseYear = $_POST['releaseYear'];
if (empty($releaseYear)) {
    $releaseYear = NULL;
}
$imdbId = $_POST['imdbId'];
if (empty($imdbId)) {
    $imdbId = NULL;
}
$description = $_POST['description'];

$genreName = Movie::get_genre_by_id($genre);

$isDupeImdbID = Movie::is_Dupe_IMDB_ID($imdbId);

if (!$isDupeImdbID) {
    $lastInsertedMovieId = Movie::add_movie($movieTitle, $releaseYear, $imdbId, $description);

    $genreArrayList = filter_input(INPUT_POST, 'genre_list',
        FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    $genreArrayListFromMain = filter_input(INPUT_POST, 'genre_list_main');
    $dataArrayGenre = unserialize($genreArrayListFromMain);

    $values = array();

    //Genre options from Movie Form Page
    if ($genreArrayList !== NULL) {
        foreach ($genreArrayList as $key => $value) {
            $values[] = '(' .$lastInsertedMovieId .',' .intval($value) . ')';
        }
    }

    // Genre List from Main (index) page
    if ($genreArrayListFromMain !== NULL) {
        foreach ($dataArrayGenre as $key => $value) {
            $values[] = '(' .$lastInsertedMovieId .',' . $value . ')';
        }
    }

    //The implode function is used to "join elements of an array with a string".
    $strValuesMovieIdGenreId = implode(',', $values);

    // Update the MOVIE_GENRE table based in the latest inserted movieId
    Movie::update_movie_genre($strValuesMovieIdGenreId);
}

?>

<?php include 'templates/header.html'; ?>

        <?php
        if ($isDupeImdbID) { ?>
            <div class="card border-danger mb-3" style="max-width: 100rem;">
                <div class="card-header">Duplicate IMDB ID</div>
                <div class="card-body text-danger">
                    <h5 class="card-title">Please enter unique IMDB ID for each movie.</h5>
                </div>
            </div>
        <?php
        } else {?>
            <!--Panel-->
            <div class="card border-dark mb-3" style="max-width: 100rem;">
                <div class="card-header">Now added to your WatchList: </div>
                <div class="card-body text-dark">
                    <h5 class="card-title"><?php echo $movieTitle ?> (<?php echo $releaseYear ?>)</h5>
                    <p class="card-text"><?php echo $description ?></p>
                    <?php
                    $genresPerMovie = Movie::genres_per_movie($lastInsertedMovieId);
                        foreach ($genresPerMovie as $genre) :
                            $strGenres .= $genre['genreName'] . ',';
                        endforeach;
                        $strGenres = rtrim($strGenres, ',');
                        ?>
                    <br>
                    <p class="card-text">Genre: <?php echo $strGenres ?></p> <br>
                    <p class="card-text">IMDB ID: <?php echo $imdbId ?></p>
                </div>
            </div>
            <!--/.Panel-->

        <?php } ?>
        <br/>
        <p> Redirecting to Home page in 5 seconds... </p>


<?php include 'templates/footer.html'; ?>
