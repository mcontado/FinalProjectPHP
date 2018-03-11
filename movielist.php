<?php
require('dbconnection.php');
require('model/Movie.php');
require('templates/functions.php');

$movies = Movie::list_all_movies();

$action = filter_input(INPUT_POST, 'action');

if ($action == 'delete_movie') {
    $movieId = filter_input(INPUT_POST, 'movieId', FILTER_VALIDATE_INT);
    if ($movieId != NULL) {
        Movie::delete_movie($movieId);
        header("Location: ./movielist.php");
    }
}

?>

<?php include 'templates/header.html'; ?>

        <h3>My WatchList</h3>

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Movie</th>
                <th>Genre</th>
                <th>Release Year</th>
                <th>IMDB ID</th>
                <th>Description</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
                <?php foreach ($movies as $movie) : ?>
                    <tr class="delete_mem<?php echo $movie['movieId'];?>">
                        <td>
                            <?php echo $movie['title']; ?> <br>
                            <a href="relatedMovies.php?movieId=<?= $movie['movieId']; ?>" target="_self"> Related </a>
                        </td>
                        <td>
                            <?php
                            $strGenres = "";
                            $genresPerMovie = Movie::genres_per_movie($movie['movieId']);
                            foreach ($genresPerMovie as $genre) :
                            ?>
                            <?php $strGenres .= $genre['genreName'] . ', '; ?>

                            <?php endforeach;
                            $strGenres = rtrim($strGenres, ', ');
                            echo $strGenres;
                            ?>

                        </td>
                        <td><?php echo $movie['releaseYear']; ?></td>
                        <td><?php echo $movie['imdbId']; ?></td>
                        <td><?php echo truncate($movie['description'], 100); ?></td>
                        <td>
                            <form action="movielist.php" method="post">
                                <input type="hidden" name="action"
                                       value="delete_movie">

                                <input type="hidden" name="movieId"
                                       value="<?php echo $movie['movieId']; ?>">

                                <button type="submit" class="btn btn-danger" id="<?php echo $movie['movieId'];?>">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

<?php include 'templates/footer.html'; ?>

