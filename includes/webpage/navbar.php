<div class="warper hoover_collapse">
    <div class="top_navbar">
        <!-- logo -->
            <div class="logo">
                <div class="hamburger toggle icon">
                    <i class="bi bi-list"></i>
                </div>

                <span class="text">
                    MODSIFY
                </span>
            </div>
        <!-- menu button -->
        <div class="menu">
            <div class="navBtns">
                <a href="#" class="previous round" onclick="history.back();">&#8249;</a>
                <a href="#" class="next round" onclick="history.forward();">&#8250;</a>
            </div>
            <?php include("loginRegister.php") ?>
        </div>
    </div>
    <div class="sidebar close">
        <div class="menu-bar">
            <div class="menu">
                <ul>
                    <li class="search-box">
                        <i class='bx bx-search icon'></i>
                        <input type="text" placeholder="Search...">
                    </li>

                    <ul class="menu-links">
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-home-alt icon' ></i>
                                <span class="text nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-album icon'></i>
                                <span class="text nav-text">Albums</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-music icon'></i>
                                <span class="text nav-text">Songs</span>
                            </a>
                        </li>

                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-face icon'></i>
                                <span class="text nav-text">Artistas</span>
                            </a>
                        </li>
                    <?php 
                        if(isset($_SESSION["user"]))
                        {
                            echo "
                                <li class='nav-link'>
                                    <div class='dropdown-divider'></div>
                                </li>

                                <li class='nav-link'>
                                    <a href='#'>
                                        <i class='bx bx-plus-circle icon'></i>
                                        <span class='text nav-text'>Adicionar Albums</span>
                                    </a>
                                </li>

                                <li class='nav-link'>
                                    <a href='#'>
                                        <i class='bx bx-plus-circle icon'></i>
                                        <span class='text nav-text'>Adicionar Songs</span>
                                    </a>
                                </li>
                                
                                <li class='nav-link'>
                                    <a href='#'>
                                        <i class='bx bx-plus-circle icon'></i>
                                        <span class='text nav-text'>Adicionar Artistas</span>
                                    </a>
                                </li>
                                
                                <li class='nav-link'>
                                    <a href='#'>
                                        <i class='bx bx-plus-circle icon'></i>
                                        <span class='text nav-text'>Adicionar Generos</span>
                                    </a>
                                </li>";
                        }
                    ?>
                </ul>
                <div class="bottom-content">
                    <li class="mode">
                        <div class="sun-moon">
                            <i class='bx bx-moon icon moon'></i>
                            <i class='bx bx-sun icon sun'></i>
                        </div>
                        <span class="mode-text text">Dark mode</span>

                        <div class="toggle-switch">
                            <span class="switch"></span>
                        </div>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>