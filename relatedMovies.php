<?php
require('dbconnection.php');
require('model/Movie.php');

$movieId = $_GET['movieId'];
$moviesByGenre = Movie::movies_by_genre($movieId);
?>

<?php include 'templates/header.html'; ?>

<h3>
    Genre:
    <?php
    $genresPerMovie = Movie::genres_per_movie($movieId);

    foreach ($genresPerMovie as $genre) :
        $strGenres .= $genre['genreName'] . ',';
    endforeach;

    $strGenres = rtrim($strGenres, ',');
    echo $strGenres;
    ?>
</h3>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Movie</th>
            <th>Release Year</th>
            <th>IMDB ID</th>
            <th>Description</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($moviesByGenre as $movie) : ?>
            <tr>
                <td><?php echo $movie['title']; ?> </td>
                <td><?php echo $movie['releaseYear']; ?></td>
                <td><?php echo $movie['imdbId']; ?></td>
                <td><?php echo $movie['description']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <button type="submit" class="btn btn-info btn-rounded" onclick="window.history.back();" > Go Back </button>
    <br> <br>

<?php include 'templates/footer.html'; ?>

