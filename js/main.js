
function validateForm() {
    var movieTitle = document.forms["wishListForm"]["movieTitle"].value;
    if (movieTitle == null || movieTitle == "")
    {
        alert("Movie Title must be filled out");
        return false;
    }

    if (!validateYear()) {
        return false;
    }
}

function validateYear() {
    var year = document.forms["wishListForm"]["releaseYear"].value;
    var re = /^(19|20)\d{2}$/;

    if (year !== '') {
        var OK = re.exec(year);
        if (!OK) {
            window.alert(year+ ' isn\'t a valid year. Please enter 1900-2099.');
            document.getElementById("releaseYear").focus();
            return false;
        }
    }
    return true;
}
