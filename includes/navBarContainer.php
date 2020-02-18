<div id="navBarContainer">
    <nav class="navBar">

        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo buttonSpecial">
            <img src="assets/images/icons/logo.png" alt="Musical note">
        </span>

        <div class="group">

            <div class="navItem">
                <span role='link' tabindex='0' onclick="openPage('search.php')" class="navItemLink buttonSpecial">
                    Search
                    <img src="assets/images/icons/search.png" class="icon" alt="Search">
                </span>
            </div>
            
        </div>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink buttonSpecial">Browse</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink buttonSpecial">Your Music</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink buttonSpecial"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>
        </div>

    </nav>
</div>