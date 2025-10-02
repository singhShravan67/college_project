<div class="filter-bar">
    <form method="GET" class="filter-form">
        <div class="form-group">
            <label><i class="fas fa-search"></i> Search Events</label>
            <input type="text" name="search" class="form-control" 
                   placeholder="Search by title or description..." 
                   value="<?php echo htmlspecialchars($search); ?>">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn">
                <i class="fas fa-search"></i> Filter
            </button>
        </div>
    </form>
</div>