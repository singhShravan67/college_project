<!-- ye ek modals hai jo login, register aur event registration ke liye hai -->
<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
            <span class="close" onclick="closeModal('loginModal')">&times;</span>
        </div>
        <div class="modal-body">
            <?php if (isset($login_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $login_error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" name="login" class="btn" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 15px;">
                <p>Don't have an account? 
                    <a href="#" onclick="closeModal('loginModal'); openModal('registerModal');" style="color: #667eea;">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-user-plus"></i> Register</h2>
            <span class="close" onclick="closeModal('registerModal')">&times;</span>
        </div>
        <div class="modal-body">
            <?php if (isset($register_error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $register_error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($register_success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $register_success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="reg_email" class="form-control" aria-atomic="true" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone</label>
                    <input type="tel" name="phone" class="form-control" max="10" required>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="reg_password" class="form-control" required minlength="6">
                </div>
                
                <button type="submit" name="register" class="btn btn-success" style="width: 100%;">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 15px;">
                <p>Already have an account? 
                    <a href="#" onclick="closeModal('registerModal'); openModal('loginModal');" style="color: #667eea;">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Event Registration Modal -->
<div id="eventRegisterModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-calendar-plus"></i> Event Registration</h2>
            <span class="close" onclick="closeModal('eventRegisterModal')">&times;</span>
        </div>
        <div class="modal-body">
            <div id="eventDetails"></div>
            
            <form method="POST" id="eventRegisterForm">
                <input type="hidden" name="event_id" id="eventIdInput">
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Registration Information:</strong>
                    <ul style="margin: 10px 0 0 20px;">
                        <li>Fill all required details for event registration</li>
                        <li>Confirmation email will be sent after registration</li>
                        <li>Event updates will be sent to your registered email</li>
                        <li>Please arrive 15 minutes before the event time</li>
                    </ul>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Semester *</label>
                        <select name="semester" class="form-control" required>
                            <option value="">Select Semester</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                            <option value="3">3rd Semester</option>
                            <option value="4">4th Semester</option>
                            <option value="5">5th Semester</option>
                            <option value="6">6th Semester</option>
                            <option value="7">7th Semester</option>
                            <option value="8">8th Semester</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-code-branch"></i> Branch *</label>
                        <select name="branch" class="form-control" required>
                            <option value="">Select Branch</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="Electronics & Communication">Electronics & Communication</option>
                            <option value="Electrical Engineering">Electrical Engineering</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                            <option value="Civil Engineering">Civil Engineering</option>
                            <option value="Chemical Engineering">Chemical Engineering</option>
                            <option value="Biotechnology">Biotechnology</option>
                            <option value="MBA">MBA</option>
                            <option value="MCA">MCA</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> IU Number / Student ID *</label>
                    <input type="text" name="iu_number" class="form-control" required 
                           placeholder="Enter your IU Number or Student ID">
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-comment-alt"></i> Special Requirements / Comments</label>
                    <textarea name="special_requirements" class="form-control" rows="4" 
                              placeholder="Any dietary restrictions, accessibility needs, or other requirements..."></textarea>
                </div>
                
                <div class="form-group">
                    <label>
                        <input type="checkbox" required style="margin-right: 10px;">
                        I agree to the terms and conditions and event guidelines
                    </label>
                </div>
                
                <button type="submit" name="event_register" class="btn btn-success" style="width: 100%;">
                    <i class="fas fa-calendar-check"></i> Confirm Registration
                </button>
            </form>
        </div>
    </div>
</div>