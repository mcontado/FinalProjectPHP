<?php
require('dbconnection.php');
require('model/Movie.php');

$genres = Movie::select_all_genres();

?>

<?php include 'templates/header.html'; ?>

        <h3>Movie Form</h3>

        <form name="wishListForm" action="confirmation.php" onsubmit="return validateForm()" method="post">

            <div class="form-group">
                <label for="movieTitle">Movie Title:</label>
                <input type="text" class="form-control" id="movieTitle" placeholder="Enter movie title" name="movieTitle">
            </div>

            <div class="form-group">
                <label for="releaseYear">Release Year:</label>
                <input type="text" class="form-control" id="releaseYear" placeholder="Enter release year"
                       name="releaseYear"
                       onchange="validateYear()">
            </div>

            <div class="form-group">
                <label for="imdbID">IMDB ID: </label>
                <input type="text" class="form-control" id="imdbId" placeholder="Enter IMDB ID" name="imdbId" pattern="tt\d{7}">
            </div>

            <div class="form-group">
                <label for="comment">Description:</label>
                <textarea class="form-control" rows="3" id="description" placeholder="Enter description for movie" name="description"></textarea>
            </div>

            <div class="form-group">
                <label> Genre: </label>
                <?php foreach ($genres as $genre) : ?>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="genre_list[]" value="<?php echo $genre['genreId']; ?>">
                            <?php echo $genre['genreName']; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-info btn-rounded"">Add to Watch List</button>
        </form>
    <br>
<?php include 'templates/footer.html'; ?>