<!-- ye ek events ka view hai Login karne ke bad ka -->

<div id="events">
    <?php if (isset($event_register_success)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $event_register_success; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($event_register_error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $event_register_error; ?>
        </div>
    <?php endif; ?>

    <div class="events-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($event = $result->fetch_assoc()) {
                $icon_class = $eventController->getCategoryIcon($event['category']);
                
                $event_date = date('M j, Y', strtotime($event['event_date']));
                $event_time = date('g:i A', strtotime($event['event_time']));
                
                $progress_percentage = ($event['current_participants'] / $event['max_participants']) * 100;
                
                $is_registered = in_array($event['id'], $user_registrations);
                
                echo "
                <div class='event-card'>
                    <div class='event-image'>
                        <i class='$icon_class'></i>
                        <div class='event-badge'>{$event['status']}</div>
                        " . ($is_registered ? "<div class='registration-status'>Registered</div>" : "") . "
                    </div>
                    
                    <div class='event-content'>
                        <h3 class='event-title'>" . htmlspecialchars($event['title']) . "</h3>
                        
                        <div class='event-meta'>
                            <div class='meta-item'>
                                <i class='fas fa-calendar'></i> {$event_date}
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-clock'></i> {$event_time}
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-map-marker-alt'></i> " . htmlspecialchars($event['location']) . "
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-tag'></i> " . htmlspecialchars($event['category']) . "
                            </div>
                        </div>
                        
                        <div class='event-description'>
                            " . htmlspecialchars(substr($event['description'], 0, 150)) . "...
                        </div>
                        
                       
                        
                        <div class='participants-info'>
                            <i class='fas fa-users'></i> 
                            {$event['current_participants']}/{$event['max_participants']} participants
                        </div>
                        
                        <div class='event-footer'>
                            <div>";
                
                if ($event['registration_fee'] > 0) {
                    echo "<strong style='color: #28a745;'>₹" . number_format($event['registration_fee'], 2) . "</strong>";
                } else {
                    echo "<strong style='color: #28a745;'>Free</strong>";
                }
                
                echo "          </div>
                            <div>";
                
                if (!$authController->isLoggedIn()) {
                    echo "<button class='btn' onclick='openModal(\"loginModal\")'>
                            <i class='fas fa-sign-in-alt'></i> Login to Register
                          </button>";
                } elseif ($is_registered) {
                    echo "<button class='btn btn-success' disabled>
                            <i class='fas fa-check'></i> Registered
                          </button>";
                } elseif ($event['current_participants'] >= $event['max_participants']) {
                    echo "<button class='btn' disabled style='background: #ccc;'>
                            <i class='fas fa-times'></i> Full
                          </button>";
                } else {
                    echo "<button class='btn btn-success' onclick='registerForEvent({$event['id']}, \"" . htmlspecialchars($event['title']) . "\")'>
                            <i class='fas fa-calendar-plus'></i> Register
                          </button>";
                }
                
                echo "          </div>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "
            <div class='no-events'>
                <i class='fas fa-calendar-times'></i>
                <h2>No Events Found</h2>
                <p>Try adjusting your search filters or check back later for new events!</p>
            </div>";
        }
        ?>
    </div>
</div><div id="events">
    <?php if (isset($event_register_success)): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo $event_register_success; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($event_register_error)): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> <?php echo $event_register_error; ?>
        </div>
    <?php endif; ?>

    <div class="events-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($event = $result->fetch_assoc()) {
                $icon_class = $eventController->getCategoryIcon($event['category']);
                
                $event_date = date('M j, Y', strtotime($event['event_date']));
                $event_time = date('g:i A', strtotime($event['event_time']));
                
                $progress_percentage = ($event['current_participants'] / $event['max_participants']) * 100;
                
                $is_registered = in_array($event['id'], $user_registrations);
                
                echo "
                <div class='event-card'>
                    <div class='event-image'>
                        <i class='$icon_class'></i>
                        <div class='event-badge'>{$event['status']}</div>
                        " . ($is_registered ? "<div class='registration-status'>Registered</div>" : "") . "
                    </div>
                    
                    <div class='event-content'>
                        <h3 class='event-title'>" . htmlspecialchars($event['title']) . "</h3>
                        
                        <div class='event-meta'>
                            <div class='meta-item'>
                                <i class='fas fa-calendar'></i> {$event_date}
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-clock'></i> {$event_time}
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-map-marker-alt'></i> " . htmlspecialchars($event['location']) . "
                            </div>
                            <div class='meta-item'>
                                <i class='fas fa-tag'></i> " . htmlspecialchars($event['category']) . "
                            </div>
                        </div>
                        
                        <div class='event-description'>
                            " . htmlspecialchars(substr($event['description'], 0, 150)) . "...
                        </div>
                        
                        <div class='progress-bar'>
                            <div class='progress-fill' style='width: {$progress_percentage}%'></div>
                        </div>
                        
                        <div class='participants-info'>
                            <i class='fas fa-users'></i> 
                            {$event['current_participants']}/{$event['max_participants']} participants
                        </div>
                        
                        <div class='event-footer'>
                            <div>";
                
                if ($event['registration_fee'] > 0) {
                    echo "<strong style='color: #28a745;'>₹" . number_format($event['registration_fee'], 2) . "</strong>";
                } else {
                    echo "<strong style='color: #28a745;'>Free</strong>";
                }
                
                echo "          </div>
                            <div>";
                
                if (!$authController->isLoggedIn()) {
                    echo "<button class='btn' onclick='openModal(\"loginModal\")'>
                            <i class='fas fa-sign-in-alt'></i> Login to Register
                          </button>";
                } elseif ($is_registered) {
                    echo "<button class='btn btn-success' disabled>
                            <i class='fas fa-check'></i> Registered
                          </button>";
                } elseif ($event['current_participants'] >= $event['max_participants']) {
                    echo "<button class='btn' disabled style='background: #ccc;'>
                            <i class='fas fa-times'></i> Full
                          </button>";
                } else {
                    echo "<button class='btn btn-success' onclick='registerForEvent({$event['id']}, \"" . htmlspecialchars($event['title']) . "\")'>
                            <i class='fas fa-calendar-plus'></i> Register
                          </button>";
                }
                
                echo "          </div>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "
            <div class='no-events'>
                <i class='fas fa-calendar-times'></i>
                <h2>No Events Found</h2>
                <p>Try adjusting your search filters or check back later for new events!</p>
            </div>";
        }
        ?>
    </div>
</div>