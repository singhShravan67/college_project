<nav class="navbar">
    <div class="nav-container">
        <a href="#" class="logo">
            <i class="fas fa-graduation-cap"></i> College Events
        </a>
        <ul class="nav-menu">
            <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#events"><i class="fas fa-calendar"></i> Events</a></li>
            <li><a href="#about"><i class="fas fa-info-circle"></i> About</a></li>
            <?php if ($authController->isLoggedIn()): ?>
                <li>
                    <div class="user-info">
                        <i class="fas fa-user"></i>
                        <span>Hello, <?php echo htmlspecialchars($authController->getCurrentUserName()); ?></span>
                        <a href="?logout=1" class="btn btn-outline" style="margin-left: 10px;">Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><button class="btn" onclick="openModal('loginModal')">Login</button></li>
                <li><button class="btn btn-outline" onclick="openModal('registerModal')">Register</button></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>