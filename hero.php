<div class="hero" id="home">
    <h1><i class="fas fa-star"></i> Welcome to College Events</h1>
    <p>Discover, register, and participate in amazing college events</p>
    <div>
        
        <?php if (!$authController->isLoggedIn()): ?>
            <button class="btn" onclick="openModal('registerModal')">
                <i class="fas fa-user-plus"></i> Register
            </button>
        <?php endif; ?>
    </div>
</div>