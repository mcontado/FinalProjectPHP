<?php

class Movie {
    public static function list_all_movies() {
        $db = Database::getDB();

        $queryMovies= 'SELECT distinct m.movieId, title, description, releaseYear, imdbId
                       FROM MOVIE m
                       LEFT JOIN MOVIE_GENRE mg on mg.movieId = m.movieId
                       LEFT JOIN GENRE g on g.genreId = mg.genreId';
        $statement= $db->prepare($queryMovies);
        $statement->execute();
        $movies= $statement->fetchAll();
        $statement->closeCursor();

        return $movies;
    }

    public static function genres_per_movie($movieId) {
        $db = Database::getDB();

        $queryMovies= 'SELECT mg.movieId, g.genreId, genreName 
                       FROM MOVIE_GENRE mg
                       INNER JOIN GENRE g on g.genreId = mg.genreId
                       WHERE mg.movieId = :movieId';
        $statement= $db->prepare($queryMovies);
        $statement->bindValue(':movieId', $movieId);
        $statement->execute();
        $genresPerMovie = $statement->fetchAll();
        $statement->closeCursor();

        return $genresPerMovie;
    }

    public static function movies_by_genre($movieId) {
        $db = Database::getDB();

        // Select all movies related to selected genre
        $queryAllMoviesByGenre = "SELECT DISTINCT m.movieId, title, description, releaseYear, imdbId
                                  FROM MOVIE m
                                  LEFT JOIN MOVIE_GENRE mg on mg.movieId = m.movieId
                                  WHERE mg.genreId in (select genreId from MOVIE_GENRE where movieId = :movieId)";
        $statement= $db->prepare($queryAllMoviesByGenre);
        $statement->bindValue(':movieId', $movieId);
        $statement->execute();
        $moviesByGenre = $statement->fetchAll();
        $statement->closeCursor();

        return $moviesByGenre;
    }

    public static function add_movie($movieTitle, $releaseYear, $imdbId, $description) {
        $db = Database::getDB();

        $query = 'INSERT INTO MOVIE
                 (movieId, title, releaseYear, imdbId, description)
              VALUES
                (NULL, :movieTitle, :releaseYear, :imdbId, :description);';

        $statement = $db->prepare($query);
        $statement->bindValue(':movieTitle', $movieTitle);
        $statement->bindValue(':releaseYear', $releaseYear);
        $statement->bindValue(':imdbId', $imdbId);
        $statement->bindValue(':description', $description);
        $statement->execute();
        $statement->closeCursor();

        // Get the last movie ID that was automatically generated
        $movieId = $db->lastInsertId();

       return $movieId;
    }

    public static function update_movie_genre($movieIdGenreId) {
        $db = Database::getDB();

        $query = "INSERT INTO MOVIE_GENRE (movieId, genreId) VALUES $movieIdGenreId;";
        $statement = $db->prepare($query);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function delete_movie($movieId) {
        $db = Database::getDB();

        $query = 'DELETE FROM MOVIE
              WHERE movieId = :movieId';
        $statement = $db->prepare($query);
        $statement->bindValue(':movieId', $movieId);
        $statement->execute();
        $statement->closeCursor();
    }


    public static function select_all_genres() {
        $db = Database::getDB();

        $query = 'SELECT * FROM genre';
        $statement = $db->prepare($query);
        $statement->execute();
        $genres = $statement->fetchAll();
        $statement->closeCursor();

        return $genres;
    }

    public static function get_genre_by_id($genreId) {
        $db = Database::getDB();

        $query = 'SELECT genreName FROM GENRE WHERE genreId = :genreId';
        $statement = $db->prepare($query);
        $statement->bindValue(':genreId', $genreId);
        $statement->execute();
        $genreName = $statement->fetchColumn();
        $statement->closeCursor();

        return $genreName;
    }

    public static function is_Dupe_IMDB_ID($imdbId) {
        $db = Database::getDB();

        $dupeImdbIDQuery = "SELECT  * FROM MOVIE WHERE imdbId = '$imdbId'";

        $statement = $db->prepare($dupeImdbIDQuery);
        $statement->execute();
        $rowCount = $statement->rowCount();

        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>