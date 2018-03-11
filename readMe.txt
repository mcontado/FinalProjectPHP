- The database component of my application is a mysql database which has a database named “moviedb”
which has 3 tables as the following:
1.) Movie - has film/movie data where each row is a movie with movieId, title, description, category, releaseYear, imdbId
2.) Genres - has genre data where each row is a genre with genreId, and genreName.
3.) Movie_Genre - is a linking table between movieId and genreId.

- The page index.php is the home page of the movie wishlist web page.
Contains list of movies based on popularity - this is an api call to the movie db api.

- The page create.php contains a Movie Form to create a new entry for a movie.
It has 5 fields: movie title (required),
category (optional),
releaseYear (optional),
imdbId (optional),
description (optional).
 On submit, the form uses the HTTP post method to send the data to confirmation.php

- The confirmation.php checks the database for an existing entry of the same movie imdb id,
and if none is found, creates an INSERT query, connects to the dB and runs the query.
On success, the form shows a confirmation message and redirects to index.php.
On failure, it outputs a message and redirects to index.php.

- The movielist.php is a list of movie wish list where the user can see all movies being added from the form.
Each movie can have related links where the user can see the related genres through relatedmovies.php.
The user can also delete one movie data at a time by hitting the delete button next to each movie record.      

 The following CDNs are added to the header page:
 https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js
 https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js
  