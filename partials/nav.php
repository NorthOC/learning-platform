<nav>
    <div class="nav-color">
        <div class="flex">
            <a href="#"class="burger" href="javascript:void(0);" onclick="myFunction()"><i id="burger" class="fa-solid fa-bars fa-2x fa-fw"></i></a>
            <a href="#"><img src="../static/images/icon2.png" alt=""></a>
        </div>
        <a href="#" class="sign-in">Sign in</a>
    </div>
        <div id="navLinks">
            <a href="#news"><i class="fas fa-home fa-2x fa-fw"></i> <p>Home</p></a>
            <a href="#contact"><i class="fa-solid fa-atom fa-2x fa-fw"></i> <p>Subjects</p></a>
            <a href="#"><i class="fa-solid fa-book-open fa-2x fa-fw"></i> <p>Courses</p></a>
            <a href="#about"><i class="fa-solid fa-gear fa-2x fa-fw"></i> <p>Settings</p></a>
            <a href="#"><i class="fa-regular fa-face-smile fa-2x fa-fw"></i> <p>About us</p></a>
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