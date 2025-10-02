<!-- ye admin panel ka code hai jisme admin login, event management, registration management aur statistics dikhaya gaya hai. -->

<?php
session_start();

// Admin ka name or password
$admin_username = 'admin';
$admin_password = 'admin123';

// Database connection karne  ka code
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'college_events';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// admin login  control karega
if (isset($_POST['admin_login'])) {
    if ($_POST['admin_username'] === $admin_username && $_POST['admin_password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $login_error = "Invalid credentials!";
    }
}

// Handle logout button ka code 
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Check karega login page ko
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Admin Login</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                font-family: Arial, sans-serif;
                background: #667eea;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
            }
            .login-box {
                background: white;
                padding: 40px;
                border-radius: 10px;
                width: 350px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            }
            h2 { text-align: center; margin-bottom: 30px; color: #333; }
            .form-group { margin-bottom: 20px; }
            label { display: block; margin-bottom: 5px; color: #555; font-weight: 600; }
            input {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 14px;
            }
            button {
                width: 100%;
                padding: 12px;
                background: #667eea;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            button:hover { background: #5568d3; }
            .error { color: red; margin-bottom: 15px; text-align: center; }
        </style>
    </head>
    <body>
        <div class="login-box">
            <h2>Admin Login</h2>
            <?php if (isset($login_error)) echo "<p class='error'>$login_error</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="admin_username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="admin_password" required>
                </div>
                <button type="submit" name="admin_login">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Event create, update, delete aur registration delete ka code hai 
if (isset($_POST['create_event'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_time = mysqli_real_escape_string($conn, $_POST['event_time']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $max_participants = mysqli_real_escape_string($conn, $_POST['max_participants']);
    $registration_fee = mysqli_real_escape_string($conn, $_POST['registration_fee']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql = "INSERT INTO events (title, description, category, event_date, event_time, location, max_participants, registration_fee, status, current_participants) 
            VALUES ('$title', '$description', '$category', '$event_date', '$event_time', '$location', '$max_participants', '$registration_fee', '$status', 0)";
    
    if ($conn->query($sql)) {
        $success_msg = "Event created successfully!";
    }
}
// ye event update karne ka code hai
if (isset($_POST['update_event'])) {
    $id = $_POST['event_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $event_time = mysqli_real_escape_string($conn, $_POST['event_time']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $max_participants = mysqli_real_escape_string($conn, $_POST['max_participants']);
    $registration_fee = mysqli_real_escape_string($conn, $_POST['registration_fee']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql = "UPDATE events SET title='$title', description='$description', category='$category', 
            event_date='$event_date', event_time='$event_time', location='$location', 
            max_participants='$max_participants', registration_fee='$registration_fee', status='$status' 
            WHERE id=$id";
    
    if ($conn->query($sql)) {
        $success_msg = "Event updated successfully!";
    }
}

// ye event delete karne ka code hai
if (isset($_GET['delete_event'])) {
    $id = $_GET['delete_event'];
    $conn->query("DELETE FROM registrations WHERE event_id = $id");
    $conn->query("DELETE FROM events WHERE id = $id");
    $success_msg = "Event deleted!";
}

// ye registration delete karne ka code hai
if (isset($_GET['delete_registration'])) {
    $id = $_GET['delete_registration'];
    $event_id = $_GET['event_id'];
    $conn->query("DELETE FROM registrations WHERE id = $id");
    $conn->query("UPDATE events SET current_participants = current_participants - 1 WHERE id = $event_id");
    $success_msg = "Registration deleted!";
}

// Get statistics
$stats = $conn->query("SELECT 
    COUNT(*) as total_events,
    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming,
    COALESCE(SUM(current_participants), 0) as participants
    FROM events")->fetch_assoc();

$total_users = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$total_registrations = $conn->query("SELECT COUNT(*) as c FROM registrations")->fetch_assoc()['c'];
?>

 <!-- ye admin panel ka HTML aur CSS code hai jisme dashboard, events, registrations aur create event ke tabs hain. -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }
        
        .header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 { font-size: 24px; }
        
        .logout-btn {
            background: #ef4444;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        
        .container { padding: 20px; max-width: 1400px; margin: 0 auto; }
        
        .tabs {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .tab-btn {
            padding: 10px 20px;
            border: none;
            background: #f0f0f0;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .tab-btn.active { background: #667eea; color: white; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        
        .stat-box h3 { font-size: 32px; color: #667eea; margin-bottom: 5px; }
        .stat-box p { color: #666; font-size: 14px; }
        
        .card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .card h2 { margin-bottom: 20px; font-size: 20px; }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #f8f8f8;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
            font-size: 14px;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        
        table tr:hover { background: #f9f9f9; }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .form-group { margin-bottom: 15px; }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 14px;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        textarea { resize: vertical; min-height: 100px; }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
        }
        
        .btn-primary { background: #667eea; color: white; }
        .btn-success { background: #10b981; color: white; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-warning { background: #f59e0b; color: white; }
        
        .badge {
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-warning { background: #fed7aa; color: #d97706; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success { background: #d1fae5; color: #059669; }
        .alert-error { background: #fee2e2; color: #dc2626; }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .close {
            font-size: 30px;
            cursor: pointer;
            color: #999;
        }
        
        .close:hover { color: #333; }
        
        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            table { font-size: 12px; }
            .stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Panel - College Events</h1>
        <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
    
    <div class="container">
        <?php if (isset($success_msg)) echo "<div class='alert alert-success'>$success_msg</div>"; ?>
        <!-- ye ek tab ka code hai -->
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('dashboard')">Dashboard</button>
            <button class="tab-btn" onclick="showTab('events')">Events</button>
            <button class="tab-btn" onclick="showTab('registrations')">Registrations</button>
            <button class="tab-btn" onclick="showTab('create')">Create Event</button>
        </div>
        
        <!-- Dashboard  data show karega -->
        <div id="dashboard" class="tab-content active">
            <div class="stats">
                <div class="stat-box">
                    <h3><?php echo $stats['total_events']; ?></h3>
                    <p>Total Events</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $stats['upcoming']; ?></h3>
                    <p>Upcoming Events</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $stats['participants']; ?></h3>
                    <p>Total Participants</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $total_registrations; ?></h3>
                    <p>Registrations</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="card">
                <h2>Recent Events</h2>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $recent = $conn->query("SELECT * FROM events ORDER BY id DESC LIMIT 10");
                    while ($event = $recent->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo $event['category']; ?></td>
                        <td><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                        <td>
                            <span class="badge badge-<?php 
                                echo $event['status'] == 'upcoming' ? 'success' : 
                                    ($event['status'] == 'ongoing' ? 'warning' : 'danger'); 
                            ?>">
                                <?php echo ucfirst($event['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        
        <!-- Events -->
        <div id="events" class="tab-content">
            <div class="card">
                <h2>All Events</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $events = $conn->query("SELECT * FROM events ORDER BY id DESC");
                    while ($event = $events->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $event['id']; ?></td>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo $event['category']; ?></td>
                        <td><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                        <td><?php echo $event['current_participants'] . '/' . $event['max_participants']; ?></td>
                        <td>
                            <span class="badge badge-<?php 
                                echo $event['status'] == 'upcoming' ? 'success' : 
                                    ($event['status'] == 'ongoing' ? 'warning' : 'danger'); 
                            ?>">
                                <?php echo ucfirst($event['status']); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning" onclick='editEvent(<?php echo json_encode($event); ?>)'>Edit</button>
                            <a href="?delete_event=<?php echo $event['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Delete this event?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        
        <!-- Registrations -->
        <div id="registrations" class="tab-content">
            <div class="card">
                <h2>All Registrations</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th>Semester</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $regs = $conn->query("SELECT r.*, e.title as event_title FROM registrations r LEFT JOIN events e ON r.event_id = e.id ORDER BY r.id DESC");
                    while ($reg = $regs->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?php echo $reg['id']; ?></td>
                        <td><?php echo htmlspecialchars($reg['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($reg['user_email']); ?></td>
                        <td><?php echo htmlspecialchars($reg['user_phone']); ?></td>
                        <td><?php echo htmlspecialchars($reg['event_title'] ?? $reg['event_name']); ?></td>
                        <td><?php echo $reg['semester']; ?></td>
                        <td><?php echo htmlspecialchars($reg['branch']); ?></td>
                        <td>
                            <button class="btn btn-primary" onclick='viewReg(<?php echo json_encode($reg); ?>)'>View</button>
                            <a href="?delete_registration=<?php echo $reg['id']; ?>&event_id=<?php echo $reg['event_id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Delete this registration?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        
        <!-- Create Event -->
        <div id="create" class="tab-content">
            <div class="card">
                <h2>Create New Event</h2>
                <form method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Event Title *</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category" required>
                                <option value="">Select</option>
                                <option value="Technical">Technical</option>
                                <option value="Cultural">Cultural</option>
                                <option value="Sports">Sports</option>
                                <option value="Academic">Academic</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Competition">Competition</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date *</label>
                            <input type="date" name="event_date" required>
                        </div>
                        <div class="form-group">
                            <label>Time *</label>
                            <input type="time" name="event_time" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Location *</label>
                            <input type="text" name="location" required>
                        </div>
                        <div class="form-group">
                            <label>Max Participants *</label>
                            <input type="number" name="max_participants" required min="1">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Registration Fee *</label>
                            <input type="number" name="registration_fee" required min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" required>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" required></textarea>
                    </div>
                    
                    <button type="submit" name="create_event" class="btn btn-success">Create Event</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit Event</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form method="POST">
                <input type="hidden" name="event_id" id="edit_id">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" id="edit_title" required>
                    </div>
                    <div class="form-group">
                        <label>Category *</label>
                        <select name="category" id="edit_category" required>
                            <option value="Technical">Technical</option>
                            <option value="Cultural">Cultural</option>
                            <option value="Sports">Sports</option>
                            <option value="Academic">Academic</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Competition">Competition</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Date *</label>
                        <input type="date" name="event_date" id="edit_date" required>
                    </div>
                    <div class="form-group">
                        <label>Time *</label>
                        <input type="time" name="event_time" id="edit_time" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Location *</label>
                        <input type="text" name="location" id="edit_location" required>
                    </div>
                    <div class="form-group">
                        <label>Max Participants *</label>
                        <input type="number" name="max_participants" id="edit_max" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Fee *</label>
                        <input type="number" name="registration_fee" id="edit_fee" required step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Status *</label>
                        <select name="status" id="edit_status" required>
                            <option value="upcoming">Upcoming</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Description *</label>
                    <textarea name="description" id="edit_desc" required></textarea>
                </div>
                
                <button type="submit" name="update_event" class="btn btn-success">Update Event</button>
            </form>
        </div>
    </div>
    
    <!-- View Registration Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registration Details</h2>
                <span class="close" onclick="closeViewModal()">&times;</span>
            </div>
            <div id="regDetails"></div>
        </div>
    </div>
    
    <script>
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
        
        function editEvent(event) {
            document.getElementById('edit_id').value = event.id;
            document.getElementById('edit_title').value = event.title;
            document.getElementById('edit_category').value = event.category;
            document.getElementById('edit_date').value = event.event_date;
            document.getElementById('edit_time').value = event.event_time;
            document.getElementById('edit_location').value = event.location;
            document.getElementById('edit_max').value = event.max_participants;
            document.getElementById('edit_fee').value = event.registration_fee;
            document.getElementById('edit_status').value = event.status;
            document.getElementById('edit_desc').value = event.description;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function viewReg(reg) {
            const html = `
                <p><strong>Name:</strong> ${reg.user_name}</p>
                <p><strong>Email:</strong> ${reg.user_email}</p>
                <p><strong>Phone:</strong> ${reg.user_phone}</p>
                <p><strong>Event:</strong> ${reg.event_title || reg.event_name}</p>
                <p><strong>Semester:</strong> ${reg.semester}</p>
                <p><strong>Branch:</strong> ${reg.branch}</p>
                <p><strong>IU Number:</strong> ${reg.iu_number}</p>
                ${reg.special_requirements ? `<p><strong>Special Requirements:</strong> ${reg.special_requirements}</p>` : ''}
            `;
            document.getElementById('regDetails').innerHTML = html;
            document.getElementById('viewModal').style.display = 'block';
        }
        
        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }
        
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>