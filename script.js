function addMovie(movieID){
    window.location.replace("./index.php?action=add&movie_id=" + movieID);
    return true;
}

function confirmCheckout(){

    //ask user if you want to confirm checkout

    if(confirm("Are you ready to checkout?")){
        window.location.replace("./index.php?action=checkout");
        return true;
    }

    else{
        return false;
    }
}

function confirmLogout(){
    //ask user if you want to confirm logout

    if(confirm("Are you sure you want to log out?")){
        window.location.replace("./logon.php?action=logoff");
        return true;
    }

else{
        return false;
    }
}

function confirmRemove(title, movieID){
    //ask user if they really want to remove (display movie title in prompt)
    if(confirm("Are you sure you want to remove " + title + "?")){
        window.location.replace("./index.php?action=remove&movie_id=" + movieID);
        return true;
    }

    else{
        return false;
    }
}
