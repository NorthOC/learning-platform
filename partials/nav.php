<nav>
    <div class="nav-color">
        <div class="flex">
            <a href="#" class="burger" href="javascript:void(0);" onclick="myFunction()"><i id="burger" class="fa-solid fa-bars fa-2x fa-fw"></i></a>
            <a href="/teensteaching"><img src="/teensteaching/static/images/icon2.png" alt=""></a>
        </div>
        <?php
        echo "<div class='flex'>";
        if (!isset($_SESSION['email'])) {
            $home_or_dashboard = "Home";
            echo '<a href="/teensteaching/login" class="sign-in">Sign in</a>';
        } else {
            $home_or_dashboard = "Dashboard";

            $mysqli = new mysqli($config['db_host'], $config['db_username'], $config['db_password'], $config['db_database']);
            if (!$mysqli->connect_error) {

                if ($_SESSION['type'] == 'teacher') {
                    $table = 'Teachers';
                } else {
                    $table = 'Users';
                }
                $id = $_SESSION['id'];
                $qry = "SELECT credit FROM $table WHERE id = '$id' LIMIT 1";
                $nav_result = $mysqli->query($qry);
                if ($nav_result) {
                    if (mysqli_num_rows($nav_result) > 0) {
                        $row = mysqli_fetch_array($nav_result);
                        echo '<a id="balance">balance: €' . $row['credit'] . '</a>';
                    } else {
                        die("BalanceError: loc: nav");
                    }
                }
            }

            echo '<a href="/teensteaching/logout" class="sign-in">Log out</a>';
        }
        echo "</div>";
        ?>
    </div>
    <div id="navLinks">
        <a href="/teensteaching"><i class="fas fa-home fa-2x fa-fw"></i>
            <p><?php echo $home_or_dashboard; ?></p>
        </a>
        <a href="/teensteaching/courses"><i class="fa-solid fa-book-open fa-2x fa-fw"></i>
            <p>Courses</p>
        </a>
        <a href="/teensteaching/subjects"><i class="fa-solid fa-atom fa-2x fa-fw"></i>
            <p>Subjects</p>
        </a>
        <a href="/teensteaching/about"><i class="fa-regular fa-face-smile fa-2x fa-fw"></i>
            <p>About us</p>
        </a>
    </div>
    <script>
        function myFunction() {
            var burger = document.getElementById("burger");
            var x = document.getElementById("navLinks");
            if (x.style.display === "block") {
                x.style.display = "none";
                burger.className = "fa-solid fa-bars fa-2x fa-fw";
            } else {
                x.style.display = "block";
                burger.className = "fa fa-times fa-2x fa-fw";
            }
        }
    </script>
</nav>