 <!-- ye events , Total participants, categories ka View hai -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-number"><?php echo $stats['total_events']; ?></div>
        <div class="stat-label">Total Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-number"><?php echo $stats['upcoming_events']; ?></div>
        <div class="stat-label">Upcoming</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-number"><?php echo $stats['total_participants']; ?></div>
        <div class="stat-label">Participants</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-tags"></i></div>
        <div class="stat-number"><?php echo $stats['total_categories']; ?></div>
        <div class="stat-label">Categories</div>
    </div>
</div>