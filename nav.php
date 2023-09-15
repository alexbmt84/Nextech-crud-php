    <section class="top-nav">

        <a href="landing.php"><img src="img/rocket.png" class="lgWayz" alt=""></a>
        <input id="menu-toggle" type="checkbox" />

        <label class='menu-button-container' for="menu-toggle">
            <div class='menu-button'></div>
        </label>

        <ul class="menu">

            <li><a id="style-2" class="a" href="landing.php" data-replace="FEED" href="">HOME</a></li>
            <li><a id="style-2" class="a" href="profile.php" data-replace="PROFILE">PROFILE</a></li>
            <li><a id="style-2" class="a" data-replace="DECONNEXION" href="logout.php">DECONNEXION</a></li>
        
            <div class="globalsearch">

                <li>

                    <form class="formsearch" method="get" action="search.php" onsubmit="return validateField()">
                        
                        <input type="search" class="searchbar" placeholder="" name="query" id="query">
                        <button name="submit" onclick="validateField();" type="submit" value="Search" id="querybutton">
                        <i id="fa" class="fa fa-search"></i>
                        </button>

                    </form>

                </li>

            </div>

        </ul>

    </section>